<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'candidate_id',
        'cover_letter',
        'video_path',
        'status',
        'reviewed_at',
        'reviewed_by',
        'employer_notes',
        'appointment_id',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the job listing for this application
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, 'job_id');
    }

    /**
     * Get the candidate who applied
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Get the reviewer (employer/admin)
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the associated appointment/interview
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Check if application is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if application is shortlisted
     */
    public function isShortlisted(): bool
    {
        return in_array($this->status, ['shortlisted', 'interview', 'offered']);
    }
}
