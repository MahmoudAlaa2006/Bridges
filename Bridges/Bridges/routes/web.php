<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/**
 * ============================================================================
 * PUBLIC ACCESS ROUTES
 * ============================================================================
 */
Route::view('/', 'welcome');

Route::get('/demo-login', function (\Illuminate\Http\Request $request) {
    if (app()->environment('local')) {
        $user = \App\Models\User::find($request->id);
        if ($user) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }
    }
    return redirect()->route('login');
})->name('demo-login');

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

/**
 * ============================================================================
 * AUTHENTICATED ROUTES (Role-Based Access Control)
 * ============================================================================
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::post('/notifications/mark-read',   [\App\Http\Controllers\NotificationController::class, 'markMineAsRead'])->name('notifications.mark-read');
    Route::get('/notifications/list',          [\App\Http\Controllers\NotificationController::class, 'myList'])->name('notifications.list');
    Route::get('/notifications/unread-count',  [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');

    /**
     * DASHBOARD GATEWAY
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
     */
    Route::view('profile', 'profile')->name('profile');

    /**
     * ========================================================================
     * CANDIDATE DASHBOARD ROUTES
     * ========================================================================
     */
    Route::middleware(['candidate'])->prefix('candidate')->name('candidate.')->group(function () {
        Route::get('/overview', [\App\Http\Controllers\CandidateDashboardController::class, 'overview'])->name('overview');
        Route::get('/jobs', [\App\Http\Controllers\CandidateDashboardController::class, 'jobs'])->name('jobs');
        Route::get('/interview', [\App\Http\Controllers\CandidateDashboardController::class, 'interview'])->name('interview');
        Route::get('/exam', [\App\Http\Controllers\CandidateDashboardController::class, 'exam'])->name('exam');
        Route::get('/exam-template', [\App\Http\Controllers\CandidateDashboardController::class, 'examTemplate'])->name('exam-template');
        Route::get('/offer', [\App\Http\Controllers\CandidateDashboardController::class, 'offer'])->name('offer');
        Route::get('/profile', [\App\Http\Controllers\CandidateDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [\App\Http\Controllers\CandidateDashboardController::class, 'updateProfile'])->name('profile.update');
        
        Route::post('/jobs/apply', [\App\Http\Controllers\JobApplicationController::class, 'store'])->name('jobs.apply');
        Route::post('/exam/grade-result', [\App\Http\Controllers\ExamResultController::class, 'gradeResult'])->name('exam.grade-result');
        Route::post('/exam/availability', [\App\Http\Controllers\ExamResultController::class, 'saveAvailability'])->name('exam.availability');
        
    });

    // Global API routes (outside role-specific namespacing)
    Route::post('/api/candidates/{id}/upload-cv', [\App\Http\Controllers\CandidateDashboardController::class, 'uploadCV'])->name('api.candidates.upload-cv');

    /**
     * ========================================================================
     * HR ADMIN DASHBOARD ROUTES
     * ========================================================================
     */
    Route::middleware(['hr.admin'])->prefix('hr-admin')->name('hr.')->group(function () {
        Route::get('/overview', [\App\Http\Controllers\HRAdminDashboardController::class, 'overview'])->name('overview');
        Route::get('/candidates/{id?}', [\App\Http\Controllers\HRAdminDashboardController::class, 'candidates'])->name('candidates');
        Route::get('/all-candidates', [\App\Http\Controllers\HRAdminDashboardController::class, 'allCandidates'])->name('all-candidates');
        Route::get('/top-candidates', [\App\Http\Controllers\HRAdminDashboardController::class, 'topCandidates'])->name('top-candidates');
        Route::get('/jobs', [\App\Http\Controllers\HRAdminDashboardController::class, 'jobs'])->name('jobs');
        Route::get('/offers', [\App\Http\Controllers\HRAdminDashboardController::class, 'offers'])->name('offers');
        Route::get('/reports', [\App\Http\Controllers\HRAdminDashboardController::class, 'reports'])->name('reports');
        Route::get('/requisitions', [\App\Http\Controllers\HRAdminDashboardController::class, 'requisitions'])->name('requisitions');
        Route::get('/profile', [\App\Http\Controllers\HRAdminDashboardController::class, 'profile'])->name('profile');

        Route::post('/requisitions/{id}/approve', [\App\Http\Controllers\HRAdminDashboardController::class, 'approveRequisition'])->name('requisitions.approve');
        Route::post('/requisitions/{id}/reject', [\App\Http\Controllers\HRAdminDashboardController::class, 'rejectRequisition'])->name('requisitions.reject');

        Route::post('/extensions/{extension}/handle', [\App\Http\Controllers\HRAdminDashboardController::class, 'handleExtension'])->name('extensions.handle');
        Route::post('/escalations/{feedback}/resolve', [\App\Http\Controllers\HRAdminDashboardController::class, 'resolveEscalation'])->name('escalations.resolve');
        
        Route::post('/candidates/{application_id}/change-stage', [\App\Http\Controllers\HRAdminDashboardController::class, 'changeStage'])->name('change-stage');
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
        
        // These need an {interview} parameter
        Route::get('/interview-session/{interview}', [\App\Http\Controllers\HREmployeeDashboardController::class, 'interviewSession'])->name('interview-session');
        Route::get('/feedback/{interview}', [\App\Http\Controllers\HREmployeeDashboardController::class, 'feedback'])->name('feedback');
        
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
        
        // These need an {interview} parameter
        Route::get('/interview-session/{interview}', [\App\Http\Controllers\InterviewerDashboardController::class, 'interviewSession'])->name('interview-session');
        Route::get('/feedback/{interview}', [\App\Http\Controllers\InterviewerDashboardController::class, 'feedback'])->name('feedback');
        
        Route::get('/brief', [\App\Http\Controllers\InterviewerDashboardController::class, 'brief'])->name('brief');
        Route::get('/profile', [\App\Http\Controllers\InterviewerDashboardController::class, 'profile'])->name('profile');
    });

    /**
     * ========================================================================
     * INTERVIEW FLOW ROUTES (Shared)
     * ========================================================================
     */
    Route::get('/interview-session/{interview}', [\App\Http\Controllers\SessionController::class, 'show'])->name('session.show');
    Route::post('/interview-session/{interview}/end', [\App\Http\Controllers\SessionController::class, 'end'])->name('session.end');
    Route::post('/interview-session/{interview}/extend', [\App\Http\Controllers\SessionController::class, 'requestExtension'])->name('session.extend');

    Route::get('/interview-feedback/{interview}', [\App\Http\Controllers\FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/interview-feedback/{interview}', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');

});

require __DIR__.'/auth.php';
