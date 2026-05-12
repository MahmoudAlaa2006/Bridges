<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;

class HREmployeeDashboardController extends Controller
{
    public function overview()
    {
        return view('hr_employee.overview');
    }

    public function jobRequisitions()
    {
        return view('hr_employee.job_requisition');
    }

    public function jobRequisitionDetails()
    {
        return view('hr_employee.job_requisition_details');
    }

    public function interviews()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $interviews = \App\Models\Interview::whereHas('panels', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['user', 'application.job', 'slot', 'panels.user'])
        ->where('status', '!=', \App\Models\Interview::STATUS_COMPLETED)
        ->whereDoesntHave('feedbacks', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->get();

        return view('hr_employee.interviews', compact('interviews'));
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
        return view('hr_employee.profile');
    }

    public function brief()
    {
        abort(403, 'HR employees are not authorized to view candidate briefs.');
    }
}
