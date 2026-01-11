<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'citizenship',
        'residency_status',
        'gender',
        'marital_status',
        'education_level',
        'years_of_experience',
        'expected_salary',
        'currency',
        'target_destination',
        'verification_status',
        'admin_notes',
        'verified_at',
        'verified_by',
        'is_public',
        'is_available',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'skills' => 'array',
        'languages' => 'array',
        'expected_salary' => 'decimal:2',
        'verified_at' => 'datetime',
        'is_public' => 'boolean',
        'is_available' => 'boolean',
    ];

    /**
     * Get the user that owns the profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who verified this profile
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if profile is verified
     */
    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    /**
     * Check if profile is pending verification
     */
    public function isPending(): bool
    {
        return $this->verification_status === 'pending';
    }

    /**
     * Get the skills for the profile
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'candidate_profile_skill');
    }

    /**
     * Get the languages for the profile
     */
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'candidate_profile_language');
    }
}
