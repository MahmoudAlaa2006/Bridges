<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('hr_employee.interviews');
    }

    public function interviewSession()
    {
        return view('hr_employee.interview_session');
    }

    public function feedback()
    {
        return view('hr_employee.feedback');
    }

    public function profile()
    {
        return view('hr_employee.profile');
    }

    public function brief()
    {
        return view('hr_employee.brief');
    }
}
