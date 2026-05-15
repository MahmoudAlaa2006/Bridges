<?php

namespace App\Services;

use App\Models\ExamAnswer;
use App\Models\ExamSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradingExam
{
    // ────────────────────────────────────────────────────────────────────────
    // SUBMIT  –  POST /exam/{id}/submit
    // ────────────────────────────────────────────────────────────────────────
    public function submitExam(Request $request, $id)
    {
        // Get the assessment to find candidate_id
        $assessment = DB::table('assessments')->where('id', $id)->first();

        if (!$assessment) {
            return redirect()->route('exam')->with('error', 'Assessment not found');
        }

        $candidateId = $assessment->candidate_id;

        // ── 1. Find or create the submission row ─────────────────────────────
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

        // Prevent double-submission
        if ($submission->submitted_at !== null) {
            return redirect()->route('exam.result', $submission->id)
                ->with('info', 'You have already submitted this exam.');
        }

        // ── 2. Pull ONLY the questions that were shown in the exam ─────────────
        $shownIds = $request->input('shown_questions', []);
        $shownIds = array_map('intval', $shownIds);

        $mcqQuestions     = $this->getMcqQuestions($assessment->job_id, $shownIds);
        $writtenQuestions = $this->getWrittenQuestions($assessment->job_id, $shownIds);
        $codeQuestions    = $this->getCodeQuestions($assessment->job_id, $shownIds);

        // ── 3. Persist answers & grade ────────────────────────────────────────
        $mcqScore     = 0;
        $writtenScore = 0;
        $codeScore    = 0;
        $maxScore     = 0;
        $answers      = [];

        // — MCQ (auto-graded) ------------------------------------------------
        foreach ($mcqQuestions as $q) {
            $maxScore        += $q->points;
            $submitted        = strtoupper(trim($request->input("q{$q->question_id}", '')));
            $isCorrect        = ($submitted === strtoupper($q->correct_option));
            $pointsAwarded    = $isCorrect ? $q->points : 0;
            $mcqScore        += $pointsAwarded;

            $answers[] = [
                'submission_id'   => $submission->id,
                'question_id'     => $q->question_id,
                'question_type'   => 'MCQ',
                'answer_text'     => null,
                'answer_option'   => $submitted ?: null,
                'points_awarded'  => $pointsAwarded,
                'points_possible' => $q->points,
                'is_correct'      => $isCorrect,
                'grader_feedback' => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        // — Written (keyword-based auto-grade) --------------------------------
        foreach ($writtenQuestions as $q) {
            $maxScore     += $q->points;
            $text          = trim($request->input("q{$q->question_id}", ''));

            // keywords is stored as JSON in DB, decode it
            $keywords      = json_decode($q->keywords, true) ?? [];
            $pointsAwarded = $this->gradeWrittenAnswer($text, $keywords, $q->points);
            $writtenScore += $pointsAwarded;

            $answers[] = [
                'submission_id'   => $submission->id,
                'question_id'     => $q->question_id,
                'question_type'   => 'WRITTEN',
                'answer_text'     => $text ?: null,
                'answer_option'   => null,
                'points_awarded'  => $pointsAwarded,
                'points_possible' => $q->points,
                'is_correct'      => null,   // human review recommended
                'grader_feedback' => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        // — Code (auto-graded via test cases) ------------------------------------
        foreach ($codeQuestions as $q) {
            $maxScore  += $q->points;
            $code       = trim($request->input("q{$q->question_id}", ''));

            // Grade the code answer against test cases
            $codeResult    = $this->gradeCodeAnswer($q->question_id, $code, $q->points);
            $pointsAwarded = $codeResult['points_awarded'];
            $codeScore    += $pointsAwarded;

            $answers[] = [
                'submission_id'   => $submission->id,
                'question_id'     => $q->question_id,
                'question_type'   => 'CODE',
                'answer_text'     => $code ?: null,
                'answer_option'   => null,
                'points_awarded'  => $pointsAwarded,
                'points_possible' => $q->points,
                'is_correct'      => $codeResult['all_passed'],
                'grader_feedback' => $codeResult['feedback'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        // ── 4. Bulk-insert all answers ────────────────────────────────────────
        if (!empty($answers)) {
            ExamAnswer::insert($answers);
        }

        // ── 5. Update submission totals ───────────────────────────────────────
        $submission->update([
            'submitted_at' => now(),
            'mcq_score'    => $mcqScore,
            'written_score'=> $writtenScore,
            'code_score'   => $codeScore,
            'total_score'  => $mcqScore + $writtenScore + $codeScore,
            'max_score'    => $maxScore,
            'status'       => 'graded',
        ]);

        // ── 6. Determine pass/fail and update assessment status ────────────
        //    Pass (≥70%) → SUBMITTED  |  Fail (<70%) → COOLDOWN
        $totalScore = $mcqScore + $writtenScore + $codeScore;
        $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;
        $passed     = $percentage >= 70;

        DB::table('assessments')->where('id', $id)->update([
            'status'       => $passed ? 'SUBMITTED' : 'COOLDOWN',
            'submitted_at' => now(),
        ]);

        return redirect()->route('exam.result', $submission->id)
            ->with('success', 'Exam submitted successfully!');
    }

    // ────────────────────────────────────────────────────────────────────────
    // RESULT  –  GET /exam/result/{submissionId}
    // ────────────────────────────────────────────────────────────────────────
    public function showResult($submissionId)
    {
        $submission = ExamSubmission::with('answers')->findOrFail($submissionId);

        $answers = $submission->answers->groupBy('question_type');

        return view('exam-result', [
            'submission'     => $submission,
            'mcqAnswers'     => $answers->get('MCQ', collect()),
            'writtenAnswers' => $answers->get('WRITTEN', collect()),
            'codeAnswers'    => $answers->get('CODE', collect()),
            'percentage'     => $submission->percentageScore(),
            'grade'          => $submission->letterGrade(),
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Keyword-based written grader.
     * Awards proportional points based on how many keywords appear in the answer.
     */
    private function gradeWrittenAnswer(string $text, array $keywords, int $maxPoints): int
    {
        if (empty($text) || empty($keywords)) {
            return 0;
        }

        $textLower = strtolower($text);
        $found     = 0;

        foreach ($keywords as $kw) {
            if (str_contains($textLower, strtolower(trim($kw)))) {
                $found++;
            }
        }

        $ratio = $found / count($keywords);
        return (int) round($maxPoints * $ratio);
    }

    /**
     * Test-case-based code grader.
     *
     * Fetches all test_cases for the given code question, treats the
     * candidate's submitted code as output (one result per line, matching
     * each test case in order), compares against expected_output, and
     * awards proportional points based on how many test cases pass.
     *
     * Updates the test_cases table with actual_output and passed status.
     *
     * @param  int    $questionId  The code question's question_id
     * @param  string $code        The candidate's submitted answer/output
     * @param  int    $maxPoints   Maximum points for this question
     * @return array  ['points_awarded' => int, 'all_passed' => bool, 'feedback' => string]
     */
    private function gradeCodeAnswer(int $questionId, string $code, int $maxPoints): array
    {
        // Fetch test cases for this code question
        $testCases = DB::table('test_cases')
            ->where('code_question_id', $questionId)
            ->orderBy('test_case_id')
            ->get();

        if ($testCases->isEmpty()) {
            return [
                'points_awarded' => 0,
                'all_passed'     => null,
                'feedback'       => 'No test cases found for this question.',
            ];
        }

        if (empty($code)) {
            return [
                'points_awarded' => 0,
                'all_passed'     => false,
                'feedback'       => 'No code submitted. 0/' . $testCases->count() . ' test cases passed.',
            ];
        }

        // Split the candidate's output into lines (one per test case)
        $outputLines = preg_split('/\r?\n/', trim($code));

        $passed = 0;
        $total  = $testCases->count();
        $details = [];

        foreach ($testCases as $index => $tc) {
            $actualOutput = isset($outputLines[$index]) ? trim($outputLines[$index]) : '';
            $expectedTrimmed = trim($tc->expected_output);

            // Compare (case-insensitive, whitespace-trimmed)
            $isPassed = strtolower($actualOutput) === strtolower($expectedTrimmed);

            if ($isPassed) {
                $passed++;
            }

            // Update the test_cases row with results
            DB::table('test_cases')
                ->where('test_case_id', $tc->test_case_id)
                ->update([
                    'actual_output' => $actualOutput ?: null,
                    'passed'        => $isPassed,
                    'updated_at'    => now(),
                ]);

            $status = $isPassed ? '✓' : '✗';
            $details[] = "TC" . ($index + 1) . " {$status}: input={$tc->input}, expected={$expectedTrimmed}, got={$actualOutput}";
        }

        // Award proportional points
        $ratio         = $passed / $total;
        $pointsAwarded = (int) round($maxPoints * $ratio);

        return [
            'points_awarded' => $pointsAwarded,
            'all_passed'     => ($passed === $total),
            'feedback'       => "{$passed}/{$total} test cases passed.\n" . implode("\n", $details),
        ];
    }

    // — Minimal question data for grading only --------------------------------
    private function getMcqQuestions($jobId, array $shownIds = [])
    {
        $query = DB::table('questions_bank')
            ->join('mcq_questions', 'questions_bank.question_id', '=', 'mcq_questions.questions_bank_question_id')
            ->where('questions_bank.job_id', $jobId)
            ->where('questions_bank.type', 'MCQ');

        if (!empty($shownIds)) {
            $query->whereIn('questions_bank.question_id', $shownIds);
        }

        return $query->select('questions_bank.question_id', 'questions_bank.points', 'mcq_questions.correct_option')
            ->get();
    }

    private function getWrittenQuestions($jobId, array $shownIds = [])
    {
        $query = DB::table('questions_bank')
            ->join('written_questions', 'questions_bank.question_id', '=', 'written_questions.questions_bank_question_id')
            ->where('questions_bank.job_id', $jobId)
            ->where('questions_bank.type', 'WRITTEN');

        if (!empty($shownIds)) {
            $query->whereIn('questions_bank.question_id', $shownIds);
        }

        return $query->select('questions_bank.question_id', 'questions_bank.points', 'written_questions.keywords')
            ->get();
    }

    private function getCodeQuestions($jobId, array $shownIds = [])
    {
        $query = DB::table('questions_bank')
            ->join('code_questions', 'questions_bank.question_id', '=', 'code_questions.questions_bank_question_id')
            ->where('questions_bank.job_id', $jobId)
            ->where('questions_bank.type', 'CODE');

        if (!empty($shownIds)) {
            $query->whereIn('questions_bank.question_id', $shownIds);
        }

        return $query->select('questions_bank.question_id', 'questions_bank.points')
            ->get();
    }
}
