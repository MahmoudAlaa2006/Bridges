<?php

namespace App\Services;

use App\Models\Interview;
use App\Models\Brief;

class InterviewBriefingService
{
    public function generateBrief(Interview $interview): Brief
    {
        return Brief::create([
            'interview_id' => $interview->id,
            'candidate_bio' => "Details for candidate #{$interview->user_id}",
            'problem_statement' => "Analyze the candidate's proficiency in their applied role.",
            'guidelines' => "Standard interview guidelines apply.",
        ]);
    }
}
