<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all job listings for this category
     */
    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }

    /**
     * Get active job listings for this category
     */
    public function activeJobListings(): HasMany
    {
        return $this->hasMany(JobListing::class)->where('is_active', true);
    }
}
