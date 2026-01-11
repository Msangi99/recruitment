<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'employer_id',
        'title',
        'slug',
        'description',
        'requirements',
        'responsibilities',
        'company_name',
        'company_logo',
        'location',
        'country',
        'employment_type',
        'education_level',
        'experience_required',
        'required_skills',
        'languages',
        'salary_min',
        'salary_max',
        'salary_currency',
        'salary_period',
        'is_active',
        'status',
        'positions_available',
        'application_deadline',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'languages' => 'array',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'is_active' => 'boolean',
        'application_deadline' => 'date',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($job) {
            if (empty($job->slug)) {
                $job->slug = Str::slug($job->title);
            }
        });
    }

    /**
     * Get the category this job belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the employer who posted this job
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Get all applications for this job
     */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    /**
     * Get salary range as formatted string
     */
    public function getSalaryRangeAttribute(): string
    {
        if ($this->salary_min && $this->salary_max) {
            return number_format((float) $this->salary_min) . ' - ' . number_format((float) $this->salary_max) . ' ' . $this->salary_currency;
        }
        
        return 'Negotiable';
    }

    /**
     * Check if job is still accepting applications
     */
    public function isAcceptingApplications(): bool
    {
        if (!$this->is_active) {
            return false;
        }
        
        if ($this->application_deadline && Carbon::parse($this->application_deadline)->isPast()) {
            return false;
        }
        
        return true;
    }
}
