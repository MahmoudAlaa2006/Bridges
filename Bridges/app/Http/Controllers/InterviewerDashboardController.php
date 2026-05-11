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
        return view('interviewer.interviews');
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
