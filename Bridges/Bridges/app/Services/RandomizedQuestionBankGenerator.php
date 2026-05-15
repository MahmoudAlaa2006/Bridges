<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RandomizedQuestionBankGenerator
{
    /**
     * Generate a randomized set of questions for an exam based on the
     * assessment's template constraints (type counts + difficulty counts).
     *
     * The difficulty counts (Easy_Count, Medium_Count, Hard_Count) are
     * distributed proportionally across each question type so that MCQ
     * doesn't consume the entire budget before Written/Code get a chance.
     *
     * @param  int    $jobId          The job the questions belong to
     * @param  object $assessment     Assessment row (with template fields joined)
     * @return array  ['mcq' => Collection, 'written' => Collection, 'code' => Collection]
     */
    public function generate(int $jobId, object $assessment): array
    {
        // ── Template constraints ─────────────────────────────────────────────
        $mcqCount     = (int) ($assessment->MCQ_Count     ?? 0);
        $writtenCount = (int) ($assessment->Written_Count ?? 0);
        $codeCount    = (int) ($assessment->Code_Count    ?? 0);

        $easyCount    = (int) ($assessment->Easy_Count    ?? 0);
        $mediumCount  = (int) ($assessment->Medium_Count  ?? 0);
        $hardCount    = (int) ($assessment->Hard_Count    ?? 0);

        $totalTypeCount = $mcqCount + $writtenCount + $codeCount;

        // ── Fetch ALL questions for this job, grouped by type ────────────────
        $allMcq     = $this->fetchMcqQuestions($jobId);
        $allWritten = $this->fetchWrittenQuestions($jobId);
        $allCode    = $this->fetchCodeQuestions($jobId);

        // ── Distribute difficulty budget proportionally per type ─────────────
        // Instead of a shared budget, each type gets its fair share of
        // easy/medium/hard slots based on its proportion of the total.
        $mcqBudget     = $this->distributeDifficulty($mcqCount,     $totalTypeCount, $easyCount, $mediumCount, $hardCount);
        $writtenBudget = $this->distributeDifficulty($writtenCount, $totalTypeCount, $easyCount, $mediumCount, $hardCount);
        $codeBudget    = $this->distributeDifficulty($codeCount,    $totalTypeCount, $easyCount, $mediumCount, $hardCount);

        // ── Pick randomized questions per type ───────────────────────────────
        $pickedMcq     = $this->pickQuestions($allMcq,     $mcqCount,     $mcqBudget);
        $pickedWritten = $this->pickQuestions($allWritten,  $writtenCount, $writtenBudget);
        $pickedCode    = $this->pickQuestions($allCode,     $codeCount,    $codeBudget);

        return [
            'mcq'     => $pickedMcq,
            'written' => $pickedWritten,
            'code'    => $pickedCode,
        ];
    }

    // ────────────────────────────────────────────────────────────────────────
    // DISTRIBUTE DIFFICULTY BUDGET
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Calculate how many Easy/Medium/Hard questions this type should get,
     * proportional to its share of the total question count.
     *
     * Example: template wants 6 MCQ + 2 Written + 2 Code = 10 total
     *          difficulty: 6 Easy, 3 Medium, 1 Hard
     *          MCQ gets 60% → 4 Easy, 2 Medium, 0 Hard (rounded, adjusted to sum to 6)
     */
    private function distributeDifficulty(int $typeCount, int $totalCount, int $easy, int $medium, int $hard): array
    {
        if ($totalCount <= 0 || $typeCount <= 0) {
            return ['EASY' => 0, 'MEDIUM' => 0, 'HARD' => 0];
        }

        $ratio = $typeCount / $totalCount;

        // Proportional allocation with rounding
        $easyAlloc   = (int) round($easy   * $ratio);
        $mediumAlloc = (int) round($medium * $ratio);
        $hardAlloc   = (int) round($hard   * $ratio);

        // Adjust to ensure allocations sum to exactly $typeCount
        $sum = $easyAlloc + $mediumAlloc + $hardAlloc;
        $diff = $typeCount - $sum;

        // Distribute the rounding difference to the largest bucket
        if ($diff > 0) {
            // Need more — add to the bucket with the most allocation
            if ($mediumAlloc >= $easyAlloc && $mediumAlloc >= $hardAlloc) {
                $mediumAlloc += $diff;
            } elseif ($easyAlloc >= $hardAlloc) {
                $easyAlloc += $diff;
            } else {
                $hardAlloc += $diff;
            }
        } elseif ($diff < 0) {
            // Too many — remove from the largest bucket
            $absDiff = abs($diff);
            if ($mediumAlloc >= $easyAlloc && $mediumAlloc >= $hardAlloc) {
                $mediumAlloc = max(0, $mediumAlloc - $absDiff);
            } elseif ($easyAlloc >= $hardAlloc) {
                $easyAlloc = max(0, $easyAlloc - $absDiff);
            } else {
                $hardAlloc = max(0, $hardAlloc - $absDiff);
            }
        }

        return [
            'EASY'   => $easyAlloc,
            'MEDIUM' => $mediumAlloc,
            'HARD'   => $hardAlloc,
        ];
    }

    // ────────────────────────────────────────────────────────────────────────
    // RANDOMIZED PICKER
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Pick $count questions from $pool, distributing across difficulties
     * according to the per-type $difficultyBudget.
     *
     * Algorithm:
     *  1. Group pool by difficulty.
     *  2. For each difficulty that has budget, randomly pick up to
     *     min(budget, available) questions.
     *  3. If we haven't reached $count yet, fill remaining slots randomly
     *     from whatever is left (regardless of difficulty).
     */
    private function pickQuestions(Collection $pool, int $count, array $difficultyBudget): Collection
    {
        if ($count <= 0 || $pool->isEmpty()) {
            return collect();
        }

        $grouped  = $pool->groupBy('difficulty');
        $picked   = collect();
        $usedIds  = [];

        // ── Phase 1: fill from each difficulty using the budget ──────────────
        foreach (['EASY', 'MEDIUM', 'HARD'] as $diff) {
            if ($picked->count() >= $count) break;
            if (($difficultyBudget[$diff] ?? 0) <= 0) continue;

            $available = ($grouped->get($diff) ?? collect())
                ->filter(fn($q) => !in_array($q->question_id, $usedIds));

            if ($available->isEmpty()) continue;

            // How many can we take from this difficulty?
            $remaining = $count - $picked->count();
            $take      = min($difficultyBudget[$diff], $available->count(), $remaining);

            // Random shuffle then take
            $selected = $available->shuffle()->take($take);

            foreach ($selected as $q) {
                $picked->push($q);
                $usedIds[] = $q->question_id;
            }
        }

        // ── Phase 2: if still short, fill from remaining pool randomly ───────
        if ($picked->count() < $count) {
            $leftover = $pool->filter(fn($q) => !in_array($q->question_id, $usedIds));
            $extra    = $leftover->shuffle()->take($count - $picked->count());

            foreach ($extra as $q) {
                $picked->push($q);
            }
        }

        return $picked->shuffle(); // final shuffle for presentation order
    }

    // ────────────────────────────────────────────────────────────────────────
    // QUESTION FETCHERS  (full data for view)
    // ────────────────────────────────────────────────────────────────────────

    private function fetchMcqQuestions(int $jobId): Collection
    {
        return DB::table('questions_bank')
            ->join('mcq_questions', 'questions_bank.question_id', '=', 'mcq_questions.questions_bank_question_id')
            ->where('questions_bank.job_id', $jobId)
            ->where('questions_bank.type', 'MCQ')
            ->select(
                'questions_bank.question_id', 'questions_bank.text',
                'questions_bank.difficulty',  'questions_bank.topic',
                'questions_bank.points',      'questions_bank.type',
                'mcq_questions.option_a', 'mcq_questions.option_b',
                'mcq_questions.option_c', 'mcq_questions.option_d',
                'mcq_questions.correct_option'
            )
            ->get();
    }

    private function fetchWrittenQuestions(int $jobId): Collection
    {
        return DB::table('questions_bank')
            ->join('written_questions', 'questions_bank.question_id', '=', 'written_questions.questions_bank_question_id')
            ->where('questions_bank.job_id', $jobId)
            ->where('questions_bank.type', 'WRITTEN')
            ->select(
                'questions_bank.question_id', 'questions_bank.text',
                'questions_bank.difficulty',  'questions_bank.topic',
                'questions_bank.points',      'questions_bank.type',
                'written_questions.keywords'
            )
            ->get();
    }

    private function fetchCodeQuestions(int $jobId): Collection
    {
        return DB::table('questions_bank')
            ->join('code_questions', 'questions_bank.question_id', '=', 'code_questions.questions_bank_question_id')
            ->where('questions_bank.job_id', $jobId)
            ->where('questions_bank.type', 'CODE')
            ->select(
                'questions_bank.question_id', 'questions_bank.text',
                'questions_bank.difficulty',  'questions_bank.topic',
                'questions_bank.points',      'questions_bank.type',
                'code_questions.language'
            )
            ->get();
    }
}
