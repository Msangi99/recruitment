<?php

namespace App\Services;

use App\Mail\JobApplicationStatusUpdated;
use App\Mail\JobApplicationSubmitted;
use App\Mail\NewJobApplication;
use App\Mail\ProfileVerificationUpdated;
use App\Models\JobApplication;
use App\Models\CandidateProfile;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationMailService
{
    public static function enabled(): bool
    {
        return Setting::emailNotificationsEnabled();
    }

    public static function adminEmail(): string
    {
        return Setting::getAdminEmail();
    }

    /**
     * Send a notification email when the global toggle is enabled.
     */
    public static function sendIfEnabled(callable $callback, string $context): bool
    {
        if (! self::enabled()) {
            return false;
        }

        return self::send($callback, $context);
    }

    /**
     * Send an email regardless of the notification toggle (e.g. admin replies, password reset).
     */
    public static function send(callable $callback, string $context): bool
    {
        try {
            $callback();

            return true;
        } catch (\Throwable $e) {
            Log::error("Email failed: {$context}", ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function notifyNewJobApplication(JobApplication $application): void
    {
        self::sendIfEnabled(function () use ($application) {
            $application->loadMissing(['job.employer', 'candidate']);

            if ($application->candidate?->email) {
                Mail::to($application->candidate->email)->send(new JobApplicationSubmitted($application));
            }

            $employerEmail = $application->job->employer?->email;
            if ($employerEmail) {
                Mail::to($employerEmail)->send(new NewJobApplication($application));
            }

            Mail::to(self::adminEmail())->send(new NewJobApplication($application));
        }, 'new_job_application');
    }

    public static function notifyApplicationStatusChange(JobApplication $application, string $previousStatus): void
    {
        if ($previousStatus === $application->status) {
            return;
        }

        self::sendIfEnabled(function () use ($application, $previousStatus) {
            $application->loadMissing(['job', 'candidate']);

            if ($application->candidate?->email) {
                Mail::to($application->candidate->email)->send(
                    new JobApplicationStatusUpdated($application, $previousStatus)
                );
            }
        }, 'job_application_status_updated');
    }

    public static function notifyProfileVerification(CandidateProfile $profile, ?string $reason = null): void
    {
        self::sendIfEnabled(function () use ($profile, $reason) {
            $profile->loadMissing('user');

            if ($profile->user?->email) {
                Mail::to($profile->user->email)->send(new ProfileVerificationUpdated($profile, $reason));
            }
        }, 'profile_verification_updated');
    }
}
