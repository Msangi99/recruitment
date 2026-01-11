<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CandidateManagementController;
use App\Http\Controllers\Admin\JobManagementController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\AppointmentManagementController;
use App\Http\Controllers\Admin\PaymentManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Candidate\CandidateController;
use App\Http\Controllers\Candidate\ProfileController;
use App\Http\Controllers\Candidate\JobApplicationController;
use App\Http\Controllers\Candidate\ConsultationController as CandidateConsultationController;
use App\Http\Controllers\Candidate\DocumentController;
use App\Http\Controllers\Candidate\BillingController;
use App\Http\Controllers\Employer\JobListingController;
use App\Http\Controllers\Employer\CandidateBrowseController;
use App\Http\Controllers\Employer\InterviewRequestController;
use App\Http\Controllers\Employer\ConsultationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Payment\AzamPayController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// AzamPay webhook (no auth required)
Route::post('/azampay/webhook', [AzamPayController::class, 'webhook'])->name('azampay.webhook');
Route::get('/azampay/redirect', [AzamPayController::class, 'redirect'])->name('azampay.redirect');
Route::get('/azampay/cancel', [AzamPayController::class, 'cancel'])->name('azampay.cancel');

// Authentication routes
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registration routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Password reset routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'employer':
                return redirect()->route('employer.dashboard');
            case 'candidate':
                return redirect()->route('candidate.dashboard');
            default:
                return redirect('/');
        }
    })->name('dashboard');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Candidate Management
        Route::get('/candidates', [CandidateManagementController::class, 'index'])->name('candidates.index');
        Route::get('/candidates/{candidate}', [CandidateManagementController::class, 'show'])->name('candidates.show');
        Route::patch('/candidates/{candidate}/status', [CandidateManagementController::class, 'updateStatus'])->name('candidates.updateStatus');

        // Verification
        Route::get('/verification/pending', [VerificationController::class, 'pending'])->name('verification.pending');
        Route::post('/verification/profile/{profile}/approve', [VerificationController::class, 'verifyProfile'])->name('verification.profile.approve');
        Route::post('/verification/profile/{profile}/reject', [VerificationController::class, 'rejectProfile'])->name('verification.profile.reject');
        Route::post('/verification/document/{document}/approve', [VerificationController::class, 'verifyDocument'])->name('verification.document.approve');
        Route::post('/verification/document/{document}/reject', [VerificationController::class, 'rejectDocument'])->name('verification.document.reject');
        Route::get('/documents/{document}', [VerificationController::class, 'viewDocument'])->name('documents.show');

        // Job Management
        Route::resource('jobs', JobManagementController::class);
        Route::patch('/jobs/{job}/toggle-status', [JobManagementController::class, 'toggleStatus'])->name('jobs.toggleStatus');

        // Appointment Management
        Route::get('/appointments', [AppointmentManagementController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentManagementController::class, 'show'])->name('appointments.show');
        Route::patch('/appointments/{appointment}/status', [AppointmentManagementController::class, 'updateStatus'])->name('appointments.updateStatus');

        // Payment Management
        Route::get('/payments', [PaymentManagementController::class, 'index'])->name('payments.index');
        Route::get('/payments/{appointment}', [PaymentManagementController::class, 'show'])->name('payments.show');

        // Category Management
        Route::resource('categories', CategoryController::class);
    });

    // Employer routes
    Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('dashboard');

        // Job Management
        Route::resource('jobs', JobListingController::class);
        Route::patch('/jobs/{job}/toggle-status', [JobListingController::class, 'toggleStatus'])->name('jobs.toggleStatus');

        // Browse Candidates (Verified Only)
        Route::get('/candidates', [CandidateBrowseController::class, 'index'])->name('candidates.index');
        Route::get('/candidates/{candidate}', [CandidateBrowseController::class, 'show'])->name('candidates.show');

        // Interview Requests
        Route::get('/interviews', [InterviewRequestController::class, 'index'])->name('interviews.index');
        Route::get('/interviews/create/{candidate}', [InterviewRequestController::class, 'create'])->name('interviews.create');
        Route::post('/interviews/{candidate}', [InterviewRequestController::class, 'store'])->name('interviews.store');
        Route::get('/interviews/{appointment}', [InterviewRequestController::class, 'show'])->name('interviews.show');

        // Free Consultations
        Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
        Route::get('/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
        Route::post('/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
        Route::get('/consultations/{appointment}', [ConsultationController::class, 'show'])->name('consultations.show');
    });

    // Candidate routes
    Route::middleware('role:candidate')->prefix('candidate')->name('candidate.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('dashboard');

        // Profile Management
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/step1', [ProfileController::class, 'storeStep1'])->name('profile.storeStep1');
        Route::post('/profile/step2', [ProfileController::class, 'storeStep2'])->name('profile.storeStep2');
        Route::post('/profile/step3', [ProfileController::class, 'storeStep3'])->name('profile.storeStep3');
        Route::post('/profile/submit', [ProfileController::class, 'submit'])->name('profile.submit');

        // Job Applications
        Route::get('/jobs', [JobApplicationController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{job}', [JobApplicationController::class, 'show'])->name('jobs.show');
        Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'apply'])->name('jobs.apply');
        Route::get('/applications', [JobApplicationController::class, 'applications'])->name('applications.index');
        Route::get('/applications/{application}', [JobApplicationController::class, 'showApplication'])->name('applications.show');

        // Documents
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

        // Paid Consultations
        Route::get('/consultations', [CandidateConsultationController::class, 'index'])->name('consultations.index');
        Route::get('/consultations/create', [CandidateConsultationController::class, 'create'])->name('consultations.create');
        Route::post('/consultations', [CandidateConsultationController::class, 'store'])->name('consultations.store');
        Route::get('/consultations/{appointment}', [CandidateConsultationController::class, 'show'])->name('consultations.show');

        // Billing & Subscription
        Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
        Route::get('/billing/upgrade', [BillingController::class, 'upgrade'])->name('billing.upgrade');
        Route::post('/billing/subscribe', [BillingController::class, 'subscribe'])->name('billing.subscribe');
        Route::get('/billing/cancel', [BillingController::class, 'cancel'])->name('billing.cancel');
        Route::post('/billing/cancel', [BillingController::class, 'cancelConfirm'])->name('billing.cancelConfirm');
    });
});
