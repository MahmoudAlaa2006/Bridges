<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\InterviewSession;
use App\Services\InterviewSessionService;
use App\Services\ExtensionRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    protected $sessionService;
    protected $extensionService;

    public function __construct(InterviewSessionService $sessionService, ExtensionRequestService $extensionService)
    {
        $this->sessionService = $sessionService;
        $this->extensionService = $extensionService;
    }

    /**
     * Join or create an interview session.
     */
    public function show(Interview $interview)
    {
        $user = Auth::user();
        $access = $this->sessionService->canAccessSession($user, $interview);

        if (!$access['allowed']) {
            return redirect()->route('dashboard')->with('error', $access['message']);
        }

        $this->sessionService->startSession($interview);
        $interview->load(['user', 'application.job', 'panels.user', 'slot']);

        // Calculate seconds remaining until end_time
        $tz = $interview->slot->time_zone ?? config('app.timezone');
        $slotDate = \Carbon\Carbon::parse($interview->slot->date)->format('Y-m-d');
        
        $slotStart = \Carbon\Carbon::parse($slotDate . ' ' . $interview->slot->start_time, $tz);
        $endTime = \Carbon\Carbon::parse($slotDate . ' ' . $interview->slot->end_time, $tz);
        
        // Add approved extensions
        $extensions = (int) $interview->extensionRequests()->where('status', 'approved')->sum('requested_minutes');
        $endTime->addMinutes($extensions);

        $secondsRemaining = now()->diffInSeconds($endTime, false);
        $secondsRemaining = ($secondsRemaining < 0) ? 0 : $secondsRemaining;

        $view = (strtolower($user->role) === 'interviewer') ? 'interviewer.interview_session' : 'session.show';
        
        // If candidate, maybe use a candidate-specific view or the same one
        if (strtolower($user->role) === 'candidate') {
            $view = 'session.show'; // Or a candidate version
        }

        return view($view, compact('interview', 'secondsRemaining'));
    }

    /**
     * End the current session and redirect to feedback.
     */
    public function end(Interview $interview)
    {
        $user = Auth::user();
        
        // Authorization: Only Interviewer or HR can end session
        if (!in_array(strtolower($user->role), ['interviewer', 'hr employee'])) {
            abort(403);
        }

        $this->sessionService->endSession($interview);

        return redirect()->route('feedback.create', ['interview' => $interview->id])
                         ->with('success', 'Session ended. Please provide your feedback.');
    }

    /**
     * Request a time extension.
     */
    public function requestExtension(Request $request, Interview $interview)
    {
        $request->validate([
            'minutes' => 'required|integer|min:5|max:30',
            'reason' => 'nullable|string|max:255',
        ]);

        $this->extensionService->requestExtension(Auth::user(), $interview, $request->minutes, $request->reason);

        return back()->with('success', 'Extension request sent to HR Admins.');
    }
}