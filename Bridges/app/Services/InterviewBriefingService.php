<?php

namespace App\Services;

use App\Models\Interview;
use App\Models\Brief;
use Illuminate\Support\Facades\Log;

/**
 * Service to generate and manage interview briefs for panel members.
 */
class InterviewBriefingService
{
    /**
     * Generate or update a brief for a specific interview.
     *
     * @param Interview $interview
     * @return Brief
     */
    public function generateBrief(Interview $interview)
    {
        $candidate = $interview->user;
        $application = $interview->application;
        $job = $application ? $application->job : null;
        $panel = $interview->panels()->with('user')->get();

        $content = "
INTERVIEW BRIEF
===============

CANDIDATE INFORMATION
---------------------
Name: {$candidate->name}
Email: {$candidate->email}
Current Stage: " . ($candidate->current_stage ?? 'N/A') . "

JOB INFORMATION
---------------
Title: " . ($job ? $job->title : 'N/A') . "
Requirements: " . ($job ? $job->description : 'N/A') . "

INTERVIEW DETAILS
-----------------
Date: {$interview->get_date->format('Y-m-d')}
Time: {$interview->get_date->format('H:i')} (UTC)
Status: {$interview->status}

PANEL MEMBERS
-------------
";
        foreach ($panel as $p) {
            $content .= "- {$p->user->name} ({$p->user->role}" . ($p->user->interviewer_type ? " - {$p->user->interviewer_type}" : "") . ")\n";
        }

        $content .= "
CANDIDATE SKILLS & EXPERIENCE
-----------------------------
- Education: [Static Placeholder]
- Work History: [Static Placeholder]
- Cover Letter Summary: [Static Placeholder]
";

        $brief = Brief::updateOrCreate(
            ['interview_id' => $interview->id],
            [
                'content' => $content,
                'is_read_only' => 0,
                'last_updated' => now(),
            ]
        );

        return $brief;
    }
}
