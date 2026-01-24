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
        'profile_picture',
        'video_cv',
        'title',
        'description',
        'location',
        'date_of_birth',
        'gender',
        'citizenship',
        'education_level',
        'course_studied',
        'years_of_experience',
        'experience_description',
        'experience_category_id',
        'expected_salary',
        'currency',
        'target_destination',
        'verification_status',
        'admin_notes',
        'verified_at',
        'verified_by',
        'is_public',
        'is_available',
        'headline',
        'passport_status',
        'willing_to_relocate',
        'availability_status',
        'medical_clearance',
        'police_clearance',
        'preferred_job_titles',
        'experience_level',
        'preferred_destinations',
        'international_experience',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'expected_salary' => 'decimal:2',
        'verified_at' => 'datetime',
        'is_public' => 'boolean',
        'is_available' => 'boolean',
        'willing_to_relocate' => 'boolean',
        'preferred_job_titles' => 'array',
        'preferred_destinations' => 'array',
        'international_experience' => 'boolean',
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
        return $this->belongsToMany(Language::class, 'candidate_profile_language')
                    ->withPivot('proficiency')
                    ->withTimestamps();
    }

    /**
     * Get the work experiences for the profile
     */
    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    /**
     * Get the educations for the profile
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    /**
     * Get the experience category for the profile
     */
    public function experienceCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'experience_category_id');
    }

    /**
     * Get the categories (job preferences) for the profile
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'candidate_profile_category');
    }
}
