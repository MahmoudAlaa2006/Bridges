<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Services\FeedbackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    /**
     * Show the feedback submission form.
     */
    public function create(Interview $interview)
    {
        $user = Auth::user();
        
        // Authorization: Is user part of the panel?
        $isPanelMember = $interview->panels->contains('user_id', $user->id);
        if (!$isPanelMember || strtolower($user->role) === 'candidate') {
            abort(403);
        }

        // Shadow interviewers don't need to submit feedback as per requirements
        if ($user->interviewer_type === 'shadow') {
            return redirect()->route('interviewer.interviews')->with('info', 'Shadow interviewers are not required to submit feedback.');
        }

        $interview->load(['user', 'application.job']);

        $view = (strtolower($user->role) === 'interviewer') ? 'interviewer.feedback' : 'hr_employee.feedback';
        
        return view($view, compact('interview'));
    }

    /**
     * Store the feedback.
     */
    public function store(Request $request, Interview $interview)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:100',
            'feedback_text' => 'required|string|min:10',
            'is_escalated' => 'boolean',
            'escalation_reason' => 'required_if:is_escalated,1|nullable|string|max:500',
        ]);

        $this->feedbackService->submitFeedback(Auth::user(), $interview, $request->all());

        $role = strtolower(Auth::user()->role);
        $redirectRoute = ($role === 'interviewer') ? 'interviewer.interviews' : 'hr_employee.interviews';

        return redirect()->route($redirectRoute)->with('success', 'Feedback submitted successfully.');
    }
}