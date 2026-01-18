<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $table = 'consultation_requests';

    protected $fillable = [
        'type', // employer, partnership, job_seeker
        'name',
        'email',
        'phone',
        'company',
        'country',
        'requested_date', // datetime
        'duration_minutes',
        'status', // pending, pending_review, confirmed, completed, cancelled
        'payment_status', // pending, paid, failed, na
        'amount',
        'payment_gateway',
        'meta_data', // json
    ];

    protected $casts = [
        'requested_date' => 'datetime',
        'meta_data' => 'array',
    ];
}
