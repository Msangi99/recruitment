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
use App\Http\Controllers\Candidate\CandidateController;
use App\Http\Controllers\Candidate\ProfileController;
use App\Http\Controllers\Candidate\JobApplicationController;
use App\Http\Controllers\Candidate\ConsultationController as CandidateConsultationController;
use App\Http\Controllers\Candidate\DocumentController;
use App\Http\Controllers\Candidate\BillingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Payment\AzamPayController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicJobController;
use App\Http\Controllers\PublicCandidateController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Job Browsing (no login required)
Route::get('/jobs', [PublicJobController::class, 'index'])->name('public.jobs.index');
Route::get('/jobs/{job}', [PublicJobController::class, 'show'])->name('public.jobs.show');

// Public Candidate Browsing for Employers (no login required)
Route::get('/candidates', [PublicCandidateController::class, 'index'])->name('public.candidates.index');
Route::get('/candidates/{candidate}', [PublicCandidateController::class, 'show'])->name('public.candidates.show');
Route::get('/candidates/{candidate}/interview', [PublicCandidateController::class, 'interviewForm'])->name('public.candidates.interview');
Route::post('/candidates/{candidate}/interview', [PublicCandidateController::class, 'submitInterview'])->name('public.candidates.interview.store');

// Public Appointment Booking
Route::prefix('book-appointment')->name('public.appointments.')->group(function () {
    Route::get('/', [App\Http\Controllers\PublicAppointmentController::class, 'index'])->name('index');

    // Employer
    Route::get('/employer', [App\Http\Controllers\PublicAppointmentController::class, 'employerForm'])->name('employer');
    Route::post('/employer', [App\Http\Controllers\PublicAppointmentController::class, 'storeEmployer'])->name('storeEmployer');

    // Partnership
    Route::get('/partnership', [App\Http\Controllers\PublicAppointmentController::class, 'partnershipForm'])->name('partnership');
    Route::post('/partnership', [App\Http\Controllers\PublicAppointmentController::class, 'storePartnership'])->name('storePartnership');

    // Job Seeker (Paid)
    Route::get('/job-seeker', [App\Http\Controllers\PublicAppointmentController::class, 'jobSeekerLanding'])->name('jobSeeker');
    Route::get('/job-seeker/form', [App\Http\Controllers\PublicAppointmentController::class, 'jobSeekerForm'])->name('jobSeeker.form');
    Route::post('/job-seeker/form', [App\Http\Controllers\PublicAppointmentController::class, 'storeJobSeeker'])->name('jobSeeker.store');

    // Scheduling (Mockup for flow)
    Route::get('/calendar/{id}', [App\Http\Controllers\PublicAppointmentController::class, 'calendar'])->name('calendar');
    Route::post('/calendar/{id}', [App\Http\Controllers\PublicAppointmentController::class, 'storeSchedule'])->name('storeSchedule');
});

// Serve static files from public folder (for php artisan serve compatibility)
// Profile pictures
Route::get('/profile-pictures/{filename}', function ($filename) {
    $path = public_path("profile-pictures/{$filename}");
    if (!file_exists($path))
        abort(404);
    return response()->file($path);
});

// Documents
Route::get('/documents/{user_id}/{filename}', function ($user_id, $filename) {
    $path = public_path("documents/{$user_id}/{$filename}");
    if (!file_exists($path))
        abort(404);
    return response()->file($path);
})->where(['user_id' => '[0-9]+', 'filename' => '.*']);

// Application videos with streaming support
Route::get('/application-videos/{filename}', function ($filename, \Illuminate\Http\Request $request) {
    $path = public_path("application-videos/{$filename}");
    if (!file_exists($path))
        abort(404);

    $size = filesize($path);
    $mimeType = mime_content_type($path) ?: 'video/mp4';

    // Handle byte-range requests for video streaming
    $start = 0;
    $end = $size - 1;
    $length = $size;

    if ($request->hasHeader('Range')) {
        $range = $request->header('Range');
        if (preg_match('/bytes=(\d+)-(\d*)/', $range, $matches)) {
            $start = intval($matches[1]);
            if (!empty($matches[2])) {
                $end = intval($matches[2]);
            }
        }
        $length = $end - $start + 1;

        $file = fopen($path, 'rb');
        fseek($file, $start);
        $data = fread($file, $length);
        fclose($file);

        return response($data, 206)
            ->header('Content-Type', $mimeType)
            ->header('Content-Length', $length)
            ->header('Content-Range', "bytes $start-$end/$size")
            ->header('Accept-Ranges', 'bytes')
            ->header('Cache-Control', 'public, max-age=86400');
    }

    // Full file request
    return response()->file($path, [
        'Content-Type' => $mimeType,
        'Accept-Ranges' => 'bytes',
        'Content-Length' => $size,
        'Cache-Control' => 'public, max-age=86400',
    ]);
});

// Contact Us
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Legal Pages
Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/privacy', 'legal.privacy')->name('privacy');
Route::view('/about', 'about')->name('about');

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
        Route::get('/verification/document/{document}/view', [VerificationController::class, 'viewDocument'])->name('verification.document.view');
        Route::post('/verification/document/{document}/approve', [VerificationController::class, 'verifyDocument'])->name('verification.document.approve');
        Route::post('/verification/document/{document}/reject', [VerificationController::class, 'rejectDocument'])->name('verification.document.reject');
        Route::patch('/verification/document/{document}/status', [VerificationController::class, 'updateDocumentStatus'])->name('verification.document.updateStatus');

        // Job Management
        Route::resource('jobs', JobManagementController::class);
        Route::patch('/jobs/{job}/toggle-status', [JobManagementController::class, 'toggleStatus'])->name('jobs.toggleStatus');
        Route::patch('/applications/{application}/status', [JobManagementController::class, 'updateApplicationStatus'])->name('applications.updateStatus');

        // Appointment Management
        Route::get('/appointments', [AppointmentManagementController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentManagementController::class, 'show'])->name('appointments.show');
        Route::patch('/appointments/{appointment}/status', [AppointmentManagementController::class, 'updateStatus'])->name('appointments.updateStatus');

        // Consultation Requests (Public Booking)
        Route::get('/consultations', [\App\Http\Controllers\Admin\ConsultationRequestController::class, 'index'])->name('consultations.index');
        Route::get('/consultations/{consultation}', [\App\Http\Controllers\Admin\ConsultationRequestController::class, 'show'])->name('consultations.show');
        Route::patch('/consultations/{consultation}/status', [\App\Http\Controllers\Admin\ConsultationRequestController::class, 'updateStatus'])->name('consultations.updateStatus');

        // Payment Management
        Route::get('/payments', [PaymentManagementController::class, 'index'])->name('payments.index');
        Route::get('/payments/{appointment}', [PaymentManagementController::class, 'show'])->name('payments.show');

        // Category Management
        Route::resource('categories', CategoryController::class);

        // Sidebar Calendar
        Route::get('/calendar', [AdminController::class, 'calendar'])->name('calendar');

        // Contact Messages Management
        Route::get('/contact-messages', [\App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('/contact-messages/{contactMessage}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::post('/contact-messages/{contactMessage}/reply', [\App\Http\Controllers\Admin\ContactMessageController::class, 'reply'])->name('contact-messages.reply');
        Route::patch('/contact-messages/{contactMessage}/notes', [\App\Http\Controllers\Admin\ContactMessageController::class, 'updateNotes'])->name('contact-messages.notes');
        Route::delete('/contact-messages/{contactMessage}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        // Settings Management
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        Route::post('/skills', [\App\Http\Controllers\Admin\SettingController::class, 'addSkill'])->name('skills.store');
        Route::delete('/skills/{skill}', [\App\Http\Controllers\Admin\SettingController::class, 'deleteSkill'])->name('skills.destroy');
        Route::post('/languages', [\App\Http\Controllers\Admin\SettingController::class, 'addLanguage'])->name('languages.store');
        Route::delete('/languages/{language}', [\App\Http\Controllers\Admin\SettingController::class, 'deleteLanguage'])->name('languages.destroy');

        // Currency Management
        Route::post('/settings/currencies', [\App\Http\Controllers\Admin\SettingController::class, 'addCurrency'])->name('settings.currencies.store');
        Route::delete('/settings/currencies/{currency}', [\App\Http\Controllers\Admin\SettingController::class, 'deleteCurrency'])->name('settings.currencies.destroy');
        Route::post('/settings/currencies/{currency}/default', [\App\Http\Controllers\Admin\SettingController::class, 'setDefaultCurrency'])->name('settings.currencies.default');
        Route::put('/settings/currencies/{currency}/rate', [\App\Http\Controllers\Admin\SettingController::class, 'updateCurrencyRate'])->name('settings.currencies.rate');
        Route::post('/settings/currencies/update-rates', [\App\Http\Controllers\Admin\SettingController::class, 'updateExchangeRates'])->name('settings.currencies.update-rates');
    });

    // Employer routes removed - employers can now browse candidates and request interviews without an account
    // See public routes: /candidates and /candidates/{id}/interview

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
