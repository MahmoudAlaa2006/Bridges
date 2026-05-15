<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobRequisition;

class JobRequisitionSeeder extends Seeder
{
    public function run(): void
    {
        JobRequisition::create([
            'title' => 'Senior Frontend Developer',
            'description' => 'We need a senior frontend expert to lead our dashboard migration to Vue 3.',
            'salary_range' => '$110k - $140k',
            'department' => 'Engineering',
            'requirements' => json_encode(['5+ years Vue/React', 'TypeScript expert', 'CSS/SCSS mastery']),
            'benefits' => json_encode(['Remote work', 'Health insurance', 'Stock options']),
            'status' => 'pending'
        ]);

        JobRequisition::create([
            'title' => 'HR Operations Manager',
            'description' => 'Seeking an experienced HR manager to streamline our internal recruitment workflows.',
            'salary_range' => '$90k - $120k',
            'department' => 'Human Resources',
            'requirements' => json_encode(['CIPD Level 7 preferred', 'Experience with ATS systems', 'Strong leadership skills']),
            'benefits' => json_encode(['401k matching', 'Professional development budget']),
            'status' => 'pending'
        ]);

        JobRequisition::create([
            'title' => 'Data Analyst',
            'description' => 'Looking for a data wizard to help us make better business decisions through advanced analytics.',
            'salary_range' => '$80k - $105k',
            'department' => 'Data Science',
            'requirements' => json_encode(['Strong SQL knowledge', 'Python or R proficiency', 'PowerBI/Tableau']),
            'benefits' => json_encode(['Performance bonus', 'Flexible hours']),
            'status' => 'pending'
        ]);
    }
}
