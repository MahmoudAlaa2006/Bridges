<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/**
 * ============================================================================
 * PUBLIC ACCESS ROUTES
 * ============================================================================
 * These routes do not require authentication. 
 * The welcome page serves as the initial landing point for the career portal.
 */
Route::view('/', 'welcome');

/**
 * ============================================================================
 * AUTHENTICATED ROUTES (Role-Based Access Control)
 * ============================================================================
 * All routes within this group require a verified, authenticated session.
 * We use custom middleware ('candidate' and 'hr.admin') to ensure strict 
 * separation between user roles.
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    /**
     * DASHBOARD GATEWAY
     * This route acts as a smart redirector. Based on the authenticated user's 
     * 'role' field in the database, it intelligently routes them to their 
     * specific dashboard experience (Candidate or HR Admin).
     */
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $role = strtolower($user->role);

        if ($role === 'candidate') {
            return redirect()->route('candidate.overview');
        } elseif ($role === 'hr admin') {
            return redirect()->route('hr.overview');
        } elseif ($role === 'hr employee') {
            return redirect()->route('hr_employee.overview');
        } elseif ($role === 'interviewer') {
            return redirect()->route('interviewer.overview');
        }
        
        return view('dashboard');
    })->name('dashboard');

    /**
     * UNIVERSAL PROFILE
     * A shared profile view that uses the base layout to adapt its styling
     * based on the user's role.
     */
    Route::view('profile', 'profile')->name('profile');

    /**
     * ========================================================================
     * CANDIDATE DASHBOARD ROUTES
     * ========================================================================
     * Grouped under the '/candidate' prefix. Handles job browsing, exams,
     * interview schedules, and offer letters.
     */
    Route::middleware(['candidate'])->prefix('candidate')->name('candidate.')->group(function () {
        // Main summary view for candidates
        Route::get('/overview', [\App\Http\Controllers\CandidateDashboardController::class, 'overview'])->name('overview');
        // Browse available job openings
        Route::get('/jobs', [\App\Http\Controllers\CandidateDashboardController::class, 'jobs'])->name('jobs');
        // View scheduled interviews
        Route::get('/interview', [\App\Http\Controllers\CandidateDashboardController::class, 'interview'])->name('interview');
        // List of technical assessments
        Route::get('/exam', [\App\Http\Controllers\CandidateDashboardController::class, 'exam'])->name('exam');
        // The actual assessment interface/template
        Route::get('/exam-template', [\App\Http\Controllers\CandidateDashboardController::class, 'examTemplate'])->name('exam-template');
        // View and sign received job offers
        Route::get('/offer', [\App\Http\Controllers\CandidateDashboardController::class, 'offer'])->name('offer');
        // Candidate-specific profile view
        Route::get('/profile', [\App\Http\Controllers\CandidateDashboardController::class, 'profile'])->name('profile');
    });

    /**
     * ========================================================================
     * HR ADMIN DASHBOARD ROUTES
     * ========================================================================
     * Grouped under the '/hr-admin' prefix. Handles recruitment pipelines,
     * applicant reviews, offer generation, and system reports.
     */
    Route::middleware(['hr.admin'])->prefix('hr-admin')->name('hr.')->group(function () {
        // High-level overview of recruitment stats
        Route::get('/overview', [\App\Http\Controllers\HRAdminDashboardController::class, 'overview'])->name('overview');
        // Single candidate deep-dive profile
        Route::get('/candidates', [\App\Http\Controllers\HRAdminDashboardController::class, 'candidates'])->name('candidates');
        // All applicants for a specific job requisition
        Route::get('/all-candidates', [\App\Http\Controllers\HRAdminDashboardController::class, 'allCandidates'])->name('all-candidates');
        // Filtered view for high-performing candidates
        Route::get('/top-candidates', [\App\Http\Controllers\HRAdminDashboardController::class, 'topCandidates'])->name('top-candidates');
        // Active job requisition management
        Route::get('/jobs', [\App\Http\Controllers\HRAdminDashboardController::class, 'jobs'])->name('jobs');
        // Managing offer letters and candidate responses
        Route::get('/offers', [\App\Http\Controllers\HRAdminDashboardController::class, 'offers'])->name('offers');
        // System alerts and exam integrity reports
        Route::get('/reports', [\App\Http\Controllers\HRAdminDashboardController::class, 'reports'])->name('reports');
        // Internal job request and approval workflow
        Route::get('/requisitions', [\App\Http\Controllers\HRAdminDashboardController::class, 'requisitions'])->name('requisitions');
        // HR-specific profile settings
        Route::get('/profile', [\App\Http\Controllers\HRAdminDashboardController::class, 'profile'])->name('profile');
    });

    /**
     * ========================================================================
     * HR EMPLOYEE DASHBOARD ROUTES
     * ========================================================================
     */
    Route::middleware(['hr.employee'])->prefix('hr-employee')->name('hr_employee.')->group(function () {
        Route::get('/overview', [\App\Http\Controllers\HREmployeeDashboardController::class, 'overview'])->name('overview');
        Route::get('/job-requisitions', [\App\Http\Controllers\HREmployeeDashboardController::class, 'jobRequisitions'])->name('job-requisitions');
        Route::get('/job-requisition-details', [\App\Http\Controllers\HREmployeeDashboardController::class, 'jobRequisitionDetails'])->name('job-requisition-details');
        Route::get('/interviews', [\App\Http\Controllers\HREmployeeDashboardController::class, 'interviews'])->name('interviews');
        Route::get('/interview-session', [\App\Http\Controllers\HREmployeeDashboardController::class, 'interviewSession'])->name('interview-session');
        Route::get('/feedback', [\App\Http\Controllers\HREmployeeDashboardController::class, 'feedback'])->name('feedback');
        Route::get('/brief', [\App\Http\Controllers\HREmployeeDashboardController::class, 'brief'])->name('brief');
        Route::get('/profile', [\App\Http\Controllers\HREmployeeDashboardController::class, 'profile'])->name('profile');
    });

    /**
     * ========================================================================
     * INTERVIEWER DASHBOARD ROUTES
     * ========================================================================
     */
    Route::middleware(['interviewer'])->prefix('interviewer')->name('interviewer.')->group(function () {
        Route::get('/overview', [\App\Http\Controllers\InterviewerDashboardController::class, 'overview'])->name('overview');
        Route::get('/interviews', [\App\Http\Controllers\InterviewerDashboardController::class, 'interviews'])->name('interviews');
        Route::get('/interview-session', [\App\Http\Controllers\InterviewerDashboardController::class, 'interviewSession'])->name('interview-session');
        Route::get('/feedback', [\App\Http\Controllers\InterviewerDashboardController::class, 'feedback'])->name('feedback');
        Route::get('/brief', [\App\Http\Controllers\InterviewerDashboardController::class, 'brief'])->name('brief');
        Route::get('/profile', [\App\Http\Controllers\InterviewerDashboardController::class, 'profile'])->name('profile');
    });

});

/**
 * AUTHENTICATION SYSTEM
 * Includes Laravel Breeze/Jetstream default routes for Login, Register, 
 * Password Reset, etc.
 */
require __DIR__.'/auth.php';

