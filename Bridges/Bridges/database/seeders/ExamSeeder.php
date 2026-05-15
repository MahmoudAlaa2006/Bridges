<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\QuestionBank;
use App\Models\McqQuestion;
use App\Models\WrittenQuestion;
use App\Models\CodeQuestion;

class ExamSeeder extends Seeder
{
    public function run($targetJobId = null): void
    {
        $jobs = $targetJobId 
            ? Job::where('job_id', $targetJobId)->get()
            : Job::all();

        foreach ($jobs as $job) {
            // Only seed if this job has no questions yet
            if (QuestionBank::where('job_id', $job->job_id)->exists()) {
                continue;
            }

            // MCQ 1
            $q1 = QuestionBank::create([
                'job_id' => $job->job_id,
                'text' => 'What is the primary benefit of using a Virtual DOM?',
                'difficulty' => 'EASY',
                'topic' => 'React',
                'points' => 20
            ]);
            McqQuestion::create([
                'question_bank_question_id' => $q1->question_id,
                'options' => [
                    'Direct manipulation of the real DOM',
                    'Improved performance by minimizing actual DOM updates',
                    'Automatic SEO optimization',
                    'Bypassing the browser rendering engine'
                ],
                'correct_option_index' => 1 // B
            ]);

            // MCQ 2
            $q2 = QuestionBank::create([
                'job_id' => $job->job_id,
                'text' => 'Which of the following is NOT a JavaScript primitive type?',
                'difficulty' => 'MEDIUM',
                'topic' => 'JavaScript',
                'points' => 20
            ]);
            McqQuestion::create([
                'question_bank_question_id' => $q2->question_id,
                'options' => [
                    'String',
                    'Boolean',
                    'Array',
                    'Undefined'
                ],
                'correct_option_index' => 2 // C
            ]);

            // Written 1
            $q3 = QuestionBank::create([
                'job_id' => $job->job_id,
                'text' => 'Explain the concept of closures in JavaScript and provide a practical use case.',
                'difficulty' => 'MEDIUM',
                'topic' => 'JavaScript',
                'points' => 30
            ]);
            WrittenQuestion::create([
                'question_bank_question_id' => $q3->question_id,
                'word_limit' => 200,
                'rubric' => 'Check for scope and closure definition.'
            ]);

            // Code 1
            $q4 = QuestionBank::create([
                'job_id' => $job->job_id,
                'text' => 'Write a function that flattens a nested array.',
                'difficulty' => 'HARD',
                'topic' => 'Algorithms',
                'points' => 30
            ]);
            CodeQuestion::create([
                'question_bank_question_id' => $q4->question_id,
                'language' => 'javascript',
                'test_case' => 'flatten([1, [2, [3]]]) == [1, 2, 3]'
            ]);
        }
    }
}
