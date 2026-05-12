<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailabilityWindow;
use App\Services\InterviewSchedulerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Controller to handle candidate availability submissions and trigger scheduling.
 */
class CandidateAvailabilityController extends Controller
{
    protected $schedulerService;

    public function __construct(InterviewSchedulerService $schedulerService)
    {
        $this->schedulerService = $schedulerService;
    }

    /**
     * Store candidate availability windows and attempt to schedule an interview.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'windows' => 'required|array|max:7',
            'windows.*.date' => 'required|date|after_or_equal:today',
            'windows.*.start_time' => 'required|string',
            'windows.*.end_time' => 'required|string',
            'windows.*.time_zone' => 'required|string',
            'application_id' => 'nullable|exists:applications,application_id',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            // 1. Clear existing windows for this week (or just add new ones)
            // For simplicity, we'll just add the new ones
            foreach ($request->windows as $windowData) {
                AvailabilityWindow::create([
                    'candidate_user_id' => $user->id,
                    'date' => $windowData['date'],
                    'start_time' => $windowData['start_time'],
                    'end_time' => $windowData['end_time'],
                    'time_zone' => $windowData['time_zone'],
                ]);
            }
        });

        // 2. AFTER submission finishes: attempt scheduling
        $interview = $this->schedulerService->schedule($user, $request->application_id);

        if ($interview) {
            return redirect()->route('candidate.interview')->with('success', 'Interview scheduled successfully!');
        }

        return redirect()->route('candidate.interview')->with('info', 'Availability saved, but no matching slot was found yet.');
    }
}
