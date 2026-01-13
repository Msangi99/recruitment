<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employer_id',
        'appointment_type',
        'title',
        'company_name',
        'job_title',
        'interviewer_email',
        'interviewer_phone',
        'meeting_mode',
        'scheduled_at',
        'duration_minutes',
        'meeting_link',
        'meeting_location',
        'notes',
        'requirements',
        'amount',
        'currency',
        'payment_status',
        'transaction_id',
        'order_id',
        'status',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the candidate (user) for this appointment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the employer for this appointment
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Check if payment is completed
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'completed';
    }

    /**
     * Check if appointment is confirmed
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if appointment can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) && 
               $this->scheduled_at->isFuture();
    }

    /**
     * Get formatted appointment time
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->scheduled_at->format('M d, Y \a\t h:i A');
    }
}
