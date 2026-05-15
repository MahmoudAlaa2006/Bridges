<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;

class InterviewerDashboardController extends Controller
{
    public function overview()
    {
        return view('interviewer.overview');
    }

    public function interviews()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $interviews = \App\Models\Interview::whereHas('panels', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['user', 'application.job', 'slot', 'panels.user'])
        // Filter out if user already submitted feedback OR if completed
        ->where('status', '!=', \App\Models\Interview::STATUS_COMPLETED)
        ->whereDoesntHave('feedbacks', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->get();

        return view('interviewer.interviews', compact('interviews'));
    }

    public function interviewSession(Interview $interview)
    {
        return redirect()->route('session.show', ['interview' => $interview->id]);
    }

    public function feedback(Interview $interview)
    {
        return redirect()->route('feedback.create', ['interview' => $interview->id]);
    }

    public function profile()
    {
        return view('interviewer.profile');
    }

    public function brief(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $interviewId = $request->query('id');
        
        $interview = \App\Models\Interview::with(['panels', 'brief'])->findOrFail($interviewId);

        // Authorization check: Is user on the panel?
        $isPanelMember = $interview->panels->contains('user_id', $user->id);
        if (!$isPanelMember) {
            abort(403, 'Unauthorized. You are not a panel member for this interview.');
        }

        // REQUIREMENT: If pending_feedback, view brief should be disabled/restricted.
        if ($interview->status === \App\Models\Interview::STATUS_PENDING_FEEDBACK) {
            return back()->with('error', 'Interview brief is no longer accessible once the session has ended and is pending feedback.');
        }

        $brief = $interview->brief;
        return view('interviewer.brief', compact('interview', 'brief'));
    }
}
