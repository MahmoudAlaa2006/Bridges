<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InterviewerDashboardController extends Controller
{
    public function overview()
    {
        return view('interviewer.overview');
    }

    public function interviews()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // 1. Scheduled Interviews (where interviewer is a panel member)
        $interviews = \App\Models\Interview::whereHas('panels', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['user', 'application.job', 'panels'])->get();

        // 2. Candidates Pending Scheduling (In 'interview' stage with availability)
        $pendingCandidates = \App\Models\User::where('role', 'candidate')
            ->where('current_stage', 'interview')
            ->whereHas('applications', function($q) {
                $q->where('status', 'shortlisted');
            })
            ->whereExists(function ($query) {
                $query->select(\DB::raw(1))
                      ->from('availability_windows')
                      ->whereColumn('availability_windows.candidate_user_id', 'users.id');
            })
            ->with(['applications.job', 'availabilityWindows'])
            ->get();

        return view('interviewer.interviews', compact('interviews', 'pendingCandidates'));
    }

    public function interviewSession()
    {
        return view('interviewer.interview_session');
    }

    public function feedback()
    {
        return view('interviewer.feedback');
    }

    public function profile()
    {
        return view('interviewer.profile');
    }

    public function brief()
    {
        return view('interviewer.brief');
    }
}
