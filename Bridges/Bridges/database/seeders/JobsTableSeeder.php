<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds the `jobs` table with the 6 static positions.
 *
 * requirements column → JSON: { card_id, level, min_score, skills }
 *   card_id   → matches the JS card ID ("job-1" … "job-6")
 *   level     → Junior / Mid-level / Senior
 *   min_score → minimum % a candidate must score to pass screening
 *   skills    → weighted skill map for CvScoringService
 */
class JobsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jobs')->delete();
        $now = now();

        $jobs = [
            [
                'title'        => 'Senior Frontend Developer',
                'department'   => 'TechCorp Inc.',
                'salary_range' => '$130k – $155k',
                'active'       => 1,
                'location'     => 'Remote',
                'benefits'     => 'Build and maintain high-performance React applications serving 2M+ users. Lead architecture decisions and mentor junior engineers.',
                'requirements' => json_encode(['card_id' => 'job-1', 'level' => 'Senior',   'min_score' => 60, 'skills' => ['React' => 40, 'TypeScript' => 30, 'Node.js' => 20, 'Git' => 10]]),
                'created_at'   => $now,
            ],
            [
                'title'        => 'Full Stack Engineer',
                'department'   => 'Innovate Labs',
                'salary_range' => '$110k – $130k',
                'active'       => 1,
                'location'     => 'Remote',
                'benefits'     => 'Join a fast-growing fintech startup and own features end-to-end. Work with React, Node.js, and PostgreSQL in a fully remote environment.',
                'requirements' => json_encode(['card_id' => 'job-2', 'level' => 'Mid-level', 'min_score' => 55, 'skills' => ['React' => 30, 'Node.js' => 30, 'PostgreSQL' => 25, 'Git' => 15]]),
                'created_at'   => $now,
            ],
            [
                'title'        => 'React Developer',
                'department'   => 'StartupCo',
                'salary_range' => '$90k – $115k',
                'active'       => 1,
                'location'     => 'Remote',
                'benefits'     => 'Be the 3rd frontend engineer at a seed-stage SaaS startup. Shape the product from day one and grow into a senior role within 12 months.',
                'requirements' => json_encode(['card_id' => 'job-3', 'level' => 'Mid-level', 'min_score' => 50, 'skills' => ['React' => 50, 'Next.js' => 30, 'CSS' => 20]]),
                'created_at'   => $now,
            ],
            [
                'title'        => 'UI/UX Engineer',
                'department'   => 'DesignForward',
                'salary_range' => '$100k – $120k',
                'active'       => 1,
                'location'     => 'Hybrid',
                'benefits'     => 'Bridge the gap between design and engineering. Work with Figma, React, and a world-class design team to deliver polished, accessible interfaces.',
                'requirements' => json_encode(['card_id' => 'job-4', 'level' => 'Mid-level', 'min_score' => 50, 'skills' => ['Figma' => 40, 'React' => 35, 'CSS' => 25]]),
                'created_at'   => $now,
            ],
            [
                'title'        => 'Software Engineer — Frontend',
                'department'   => 'CloudBase',
                'salary_range' => '$120k – $145k + RSUs',
                'active'       => 1,
                'location'     => 'Remote',
                'benefits'     => "Work on CloudBase's developer-facing dashboard used by 50,000+ companies. Own critical infrastructure and shape the future of cloud tooling.",
                'requirements' => json_encode(['card_id' => 'job-5', 'level' => 'Senior',   'min_score' => 60, 'skills' => ['React' => 40, 'AWS' => 30, 'TypeScript' => 20, 'Git' => 10]]),
                'created_at'   => $now,
            ],
            [
                'title'        => 'Frontend Architect',
                'department'   => 'MegaTech',
                'salary_range' => '$150k – $175k + equity',
                'active'       => 1,
                'location'     => 'Remote',
                'benefits'     => "Lead the front-end architecture for MegaTech's flagship product suite. Drive technical strategy, performance benchmarking, and platform decisions.",
                'requirements' => json_encode(['card_id' => 'job-6', 'level' => 'Senior',   'min_score' => 65, 'skills' => ['TypeScript' => 40, 'React' => 25, 'Architecture' => 25, 'Git' => 10]]),
                'created_at'   => $now,
            ],
        ];

        DB::table('jobs')->insert($jobs);
        $this->command->info('Jobs seeded: ' . count($jobs) . ' positions inserted.');
    }
}
