<?php

namespace App\Http\Controllers;

use App\Models\ExamSubmission;
use App\Services\CoolDownCheck;
use App\Services\RandomizedQuestionBankGenerator;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    // ────────────────────────────────────────────────────────────────────────
    // LIST  –  exam.blade.php
    // Show only PENDING and COOLDOWN assessments
    // ────────────────────────────────────────────────────────────────────────
    public function getAssessment()
    {
        $assessments = DB::select('
            SELECT
                a.*,
                t.MCQ_Count, t.Written_Count, t.Code_Count,
                t.Easy_Count, t.Medium_Count, t.Hard_Count
            FROM assessments a
            LEFT JOIN templates t ON a.template_id = t.id
            WHERE a.status IN (?, ?)
            ORDER BY a.id DESC
        ', ['PENDING', 'COOLDOWN']);

        // Collect cool-down info for COOLDOWN assessments
        $coolDownCheck = new CoolDownCheck();
        $coolDownInfo  = [];

        foreach ($assessments as $assessment) {
            if ($assessment->status === 'COOLDOWN') {
                $result = $coolDownCheck->isEligible($assessment->candidate_id, $assessment->job_id);
                $coolDownInfo[$assessment->id] = $result;

                // If cool-down has expired, revert to PENDING so candidate can retake
                if ($result['eligible']) {
                    DB::table('assessments')
                        ->where('id', $assessment->id)
                        ->update(['status' => 'PENDING']);
                    $assessment->status = 'PENDING';
                }
            }
        }

        return view('exam', [
            'assessments'  => $assessments,
            'coolDownInfo' => $coolDownInfo,
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────
    // START  –  exam-start.blade.php
    // Only PENDING assessments can be started
    // ────────────────────────────────────────────────────────────────────────
    public function startExam($id)
    {
        $assessment = DB::table('assessments')
            ->leftJoin('templates', 'assessments.template_id', '=', 'templates.id')
            ->where('assessments.id', $id)
            ->select(
                'assessments.*',
                'templates.MCQ_Count', 'templates.Written_Count', 'templates.Code_Count',
                'templates.Easy_Count', 'templates.Medium_Count', 'templates.Hard_Count'
            )
            ->first();

        if (!$assessment) {
            return redirect()->route('exam')->with('error', 'Assessment not found');
        }

        // ── Block if not PENDING ────────────────────────────────────────────
        if ($assessment->status === 'COOLDOWN') {
            $coolDownCheck = new CoolDownCheck();
            $result = $coolDownCheck->isEligible($assessment->candidate_id, $assessment->job_id);

            if (!$result['eligible']) {
                $nextDate = $result['next_eligible_date']->format('M d, Y');
                return redirect()->route('exam')
                    ->with('cooldown_error', "You cannot retake this exam. Your cool-down period expires on {$nextDate}.");
            }

            // Cool-down expired — revert to PENDING
            DB::table('assessments')->where('id', $id)->update(['status' => 'PENDING']);
        }

        // ── Set status to ACTIVE when candidate enters the exam ─────────────
        DB::table('assessments')->where('id', $id)->update(['status' => 'ACTIVE']);

        // Use candidate_id from the assessment (no auth required)
        $candidateId = $assessment->candidate_id;

        // Record start time the first time the candidate opens the exam
        $submission = ExamSubmission::where('assessment_id', $id)
            ->where('user_id', $candidateId)
            ->first();

        if (!$submission) {
            $submission = ExamSubmission::create([
                'assessment_id' => $id,
                'user_id'       => $candidateId,
                'started_at'    => now(),
                'status'        => 'pending',
            ]);
        }

        // ── Randomized questions via RandomizedQuestionBankGenerator ─────────
        $generator = new RandomizedQuestionBankGenerator();
        $questions = $generator->generate($assessment->job_id, $assessment);

        $mcqQuestions     = $questions['mcq'];
        $writtenQuestions = $questions['written'];
        $codeQuestions    = $questions['code'];

        // ── Calculate remaining time (don't reset on reload) ─────────────────
        $timeLimitMinutes  = 60;
        $startedAt         = $submission->started_at;
        $elapsedSeconds    = now()->diffInSeconds($startedAt);
        $remainingSeconds  = max(0, ($timeLimitMinutes * 60) - $elapsedSeconds);

        // ── Current focus-loss data (don't reset on reload) ──────────────────
        $assessmentModel   = \App\Models\Assessment::find($assessment->id);
        $focusLossCount    = $assessmentModel->focusLossCount ?? 0;
        $focusThreshold    = $assessmentModel->focus_loss_threshold ?? 5;
        $flaggedForReview  = (bool) ($assessmentModel->flag_for_review ?? false);

        return view('exam-start', [
            'assessment'        => $assessment,
            'submission'        => $submission,
            'mcqQuestions'      => $mcqQuestions,
            'writtenQuestions'  => $writtenQuestions,
            'codeQuestions'     => $codeQuestions,
            'totalQuestions'    => $mcqQuestions->count() + $writtenQuestions->count() + $codeQuestions->count(),
            'remainingSeconds'  => $remainingSeconds,
            'focusLossCount'    => $focusLossCount,
            'focusThreshold'    => $focusThreshold,
            'flaggedForReview'  => $flaggedForReview,
        ]);
    }
}
