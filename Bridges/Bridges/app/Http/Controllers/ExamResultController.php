<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamResultController extends Controller
{
    private const STAGE_FROM      = 'technical_test';
    private const STAGE_INTERVIEW = 'interview';
    private const STAGE_REJECTED  = 'rejected';
    private const PASS_THRESHOLD  = 50.0;

    public function gradeResult(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'unauthorized'], 401);
        }

        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $answers = $validated['answers'];
        $totalPoints = 0;
        $earnedPoints = 0;

        // Fetch application to get the job_id
        $application = $user->applications()->where('status', '!=', 'rejected')->latest()->first();
        if (!$application) {
             return response()->json(['success' => false, 'error' => 'No active application found'], 404);
        }

        $questions = $application->job->questionBanks()->with(['mcqQuestion', 'writtenQuestion', 'codeQuestion'])->get();

        foreach ($questions as $q) {
            $totalPoints += $q->points;
            $answer = $answers[$q->question_id] ?? null;

            if ($q->mcqQuestion) {
                if ($answer !== null && (int)$answer === (int)$q->mcqQuestion->correct_option_index) {
                    $earnedPoints += $q->points;
                }
            } elseif ($q->writtenQuestion) {
                // Basic heuristic for written: if they wrote more than 20 words, give partial/full credit
                if ($answer && str_word_count($answer) >= 10) {
                    $earnedPoints += $q->points;
                }
            } elseif ($q->codeQuestion) {
                // Basic heuristic for code: if it contains a function definition, give credit
                if ($answer && (str_contains($answer, 'function') || str_contains($answer, '=>'))) {
                    $earnedPoints += $q->points;
                }
            }
        }

        $examScore = $totalPoints > 0 ? ($earnedPoints / $totalPoints) * 100 : 0;
        $cvScore = (float) ($application->match_score ?? 0);
        
        // Final score can be weighted, but for now we'll just check exam score as per user request (50%)
        $passed = $examScore >= self::PASS_THRESHOLD;
        $newStage = $passed ? self::STAGE_INTERVIEW : self::STAGE_REJECTED;

        $user->update(['current_stage' => $newStage]);
        $application->update([
            'status' => $passed ? 'shortlisted' : 'rejected',
            'exam_score' => $examScore,
            'answers' => $answers
        ]);

        if ($passed) {
            // ── Notify candidate: exam passed → enter availability ───────────
            DB::table('notifications')->insert([
                'notification_id' => \Illuminate\Support\Str::uuid(),
                'recipient_id'    => $user->id,
                'subject'         => '🎉 Exam Passed — Submit Your Availability',
                'message'         => 'Congratulations! You scored ' . round($examScore, 1) . '% on the technical assessment for the '
                                   . $application->job->title . ' position and have advanced to the Interview Stage. '
                                   . 'Please go to the Interview section now, add between 1 and 7 preferred time slots (date, start time, end time, and time zone) '
                                   . 'so our team can schedule your interview at a time that works for you.',
                'type'            => 'exam_passed',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        } else {
            DB::table('notifications')->insert([
                'notification_id' => \Illuminate\Support\Str::uuid(),
                'recipient_id'    => $user->id,
                'subject'         => 'Assessment Result',
                'message'         => 'Thank you for taking the assessment. Unfortunately, you did not meet the required threshold for the ' . $application->job->title . ' position. You are welcome to apply for other available roles.',
                'type'            => 'exam_result',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        return response()->json([
            'success'    => true,
            'passed'     => $passed,
            'cv_score'   => round($cvScore, 1),
            'exam_score' => round($examScore, 1),
            'new_stage'  => $newStage,
            'redirect'   => route('candidate.overview')
        ]);
    }

    public function saveAvailability(Request $request): JsonResponse
    {
        $candidateUserId = auth()->id();
        if (!$candidateUserId) {
            return response()->json(['success' => false, 'error' => 'unauthorized'], 401);
        }

        $validated = $request->validate([
            'windows'              => 'required|array|min:1|max:7',
            'windows.*.date'       => 'required|date|after_or_equal:today',
            'windows.*.start_time' => 'required|string',
            'windows.*.end_time'   => 'required|string',
            'windows.*.time_zone'  => 'required|string|max:50',
        ]);

        $now  = now();

        $existingCreatedAt = DB::table('availability_windows')
            ->where('candidate_user_id', $candidateUserId)
            ->min('created_at');

        $createdAt = $existingCreatedAt ?: $now;

        $rows = array_map(fn($w) => [
            'candidate_user_id' => $candidateUserId,
            'date'              => $w['date'],
            'start_time'        => $w['start_time'],
            'end_time'          => $w['end_time'],
            'time_zone'         => $w['time_zone'],
            'created_at'        => $createdAt,
            'updated_at'        => $now,
        ], $validated['windows']);

        DB::table('availability_windows')
            ->where('candidate_user_id', $candidateUserId)
            ->delete();

        DB::table('availability_windows')->insert($rows);

        User::where('id', $candidateUserId)->update(['current_stage' => self::STAGE_INTERVIEW]);

        DB::table('notifications')->insert([
            'notification_id' => \Illuminate\Support\Str::uuid(),
            'recipient_id'    => $candidateUserId,
            'subject'         => 'Availability Received',
            'message'         => 'Your interview availability has been successfully updated. Our team will review your slots.',
            'type'            => 'interview_update',
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);

        session()->forget('seen_stage');

        return response()->json([
            'success'       => true,
            'windows_saved' => count($rows),
            'message'       => 'Your availability has been saved. We will contact you soon to schedule your interview.',
        ]);
    }
}
