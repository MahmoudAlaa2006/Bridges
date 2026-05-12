<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * ============================================================================
 * Candidate Dashboard Controller
 * ============================================================================
 * This controller manages the end-user experience for job seekers.
 * It provides visibility into their application status, assessment results,
 * interview schedules, and received job offers.
 */
class CandidateDashboardController extends Controller
{
    /**
     * CANDIDATE OVERVIEW
     * The personalized landing page for candidates. 
     * It aggregates their most critical current data: active applications
     * and upcoming interview appointments.
     */
    public function overview()
    {
        /** @var User $user */
        $user = Auth::user();
        
        /**
         * DATA HYDRATION
         * We fetch the candidate's specific relations. 
         * Note: The 'interviews' query uses a date check to ensure only 
         * future/relevant meetings are highlighted.
         */
        $data = [
            'candidate' => $user,
            'applications' => $user->applications()->with('job')->get(),
            'upcomingInterviews' => $user->interviews()->where('get_date', '>=', now())->get(),
        ];

        return view('candidate.overview', $data);
    }

    /**
     * JOB DISCOVERY
     * Renders the job board where candidates can search and apply for 
     * new career opportunities.
     */
    public function jobs()
    {
        $user = Auth::user();
        return view('candidate.jobs', compact('user'));
    }

    /**
     * INTERVIEW SCHEDULE
     * A dedicated view for managing interview invitations, viewing meeting
     * links, and tracking historical interview feedback.
     */
    public function interview()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $interviews = $user->interviews()
            ->with(['application.job', 'slot', 'panels.user'])
            ->get();

        return view('candidate.interview', compact('user', 'interviews'));
    }

    /**
     * ASSESSMENT CENTER
     * Lists all technical or behavioral exams assigned to the candidate.
     * This acts as the waiting room before starting a live test.
     */
    public function exam()
    {
        $user = Auth::user();
        return view('candidate.exam', compact('user'));
    }

    /**
     * LIVE ASSESSMENT INTERFACE
     * The high-stakes environment where candidates actually take their exams.
     * This view uses a specialized layout to minimize distractions.
     */
    public function examTemplate()
    {
        $user = Auth::user();
        return view('candidate.exam_template', compact('user'));
    }

    /**
     * OFFER MANAGEMENT
     * The final stage of the recruitment funnel. Candidates can view, 
     * download, and respond to official job offers here.
     */
    public function offer()
    {
        $user = Auth::user();
        return view('candidate.offer', compact('user'));
    }

    /**
     * CANDIDATE PROFILE & CV
     * Allows the user to manage their personal information, contact details, 
     * and upload their latest resume.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('candidate.profile', compact('user'));
    }
}


