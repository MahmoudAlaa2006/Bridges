<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * ============================================================================
 * HR Admin Dashboard Controller
 * ============================================================================
 * This controller orchestrates the administrative side of the recruitment portal.
 * It handles all views related to job management, candidate tracking, 
 * interview escalations, and internal requisitions.
 * 
 * Note: Most data is currently passed as static placeholders but is structured
 * to accept Eloquent collections in future iterations.
 */
class HRAdminDashboardController extends Controller
{
    /**
     * DASHBOARD OVERVIEW
     * The primary entry point for HR users. Displays a high-level summary of 
     * recruitment metrics and recent activity.
     */
    public function overview()
    {
        /** @var User $user */
        $user = Auth::user();

        /**
         * INITIAL DATA AGGREGATION
         * We query the database for basic candidate counts to provide immediate 
         * value on the dashboard.
         */
        $data = [
            'admin' => $user,
            'stats' => [
                'total_candidates' => User::where('role', 'candidate')->count(),
                // Placeholder for future metrics like 'active_jobs', 'pending_offers'
            ]
        ];

        return view('hr_admin.overview', $data);
    }

    /**
     * SINGLE CANDIDATE DEEP-DIVE
     * Displays the comprehensive profile of a specific candidate, including 
     * their assessment scores and radar competency charts.
     */
    public function candidates()
    {
        $user = Auth::user();
        return view('hr_admin.candidates', compact('user'));
    }

    /**
     * GLOBAL CANDIDATE LIST
     * Renders a searchable, filterable table of all applicants for a 
     * specific job requisition.
     */
    public function allCandidates()
    {
        $user = Auth::user();
        return view('hr_admin.all_candidates', compact('user'));
    }

    /**
     * ELITE APPLICANT VIEW
     * A specialized view focusing on candidates in the top 10% percentile 
     * based on their system-calculated overall score.
     */
    public function topCandidates()
    {
        $user = Auth::user();
        return view('hr_admin.top_candidates', compact('user'));
    }

    /**
     * JOB REQUISITION MANAGEMENT
     * Allows HR users to monitor active job postings and see quick 
     * stats on applicant volume per job.
     */
    public function jobs()
    {
        $user = Auth::user();
        return view('hr_admin.jobs', compact('user'));
    }

    /**
     * OFFER LETTER WORKFLOW
     * Manages the lifecycle of job offers, from draft generation to 
     * candidate acceptance/rejection tracking.
     */
    public function offers()
    {
        $user = Auth::user();
        return view('hr_admin.offers', compact('user'));
    }

    /**
     * SYSTEM ALERTS & COMPLIANCE
     * Displays critical reports such as exam integrity violations (focus loss)
     * and high-similarity answers flagged by the AI.
     */
    public function reports()
    {
        $user = Auth::user();
        
        $escalations = \App\Models\Feedback::where('is_escalated', true)
            ->where('role', '!=', 'resolved') // Use 'role' or a new status to mark as resolved
            ->with(['interview.user', 'user'])
            ->get();

        $extensionRequests = \App\Models\TimeExtensionRequest::where('status', 'pending')
            ->with(['interview.user', 'requester'])
            ->get();

        return view('hr_admin.reports', compact('user', 'escalations', 'extensionRequests'));
    }

    /**
     * Handle time extension approval/rejection.
     */
    public function handleExtension(Request $request, \App\Models\TimeExtensionRequest $extension)
    {
        $status = $request->input('status');
        (new \App\Services\ExtensionRequestService())->handleRequest($extension, $status);
        
        return back()->with('success', "Extension request #{$extension->id} has been {$status}.");
    }

    /**
     * Resolve an escalation.
     */
    public function resolveEscalation(\App\Models\Feedback $feedback)
    {
        $feedback->update(['is_escalated' => false]);
        return back()->with('success', "Escalation for interview #{$feedback->interview_id} resolved.");
    }

    /**
     * INTERNAL REQUISITION APPROVALS
     * Handles the workflow where department heads request new headcount.
     * HR can review, approve, or reject these requests here.
     */
    public function requisitions()
    {
        $user = Auth::user();
        return view('hr_admin.requisitions', compact('user'));
    }

    /**
     * HR USER PROFILE
     * Personal settings and account management for the HR administrator.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('hr_admin.profile', compact('user'));
    }
}


