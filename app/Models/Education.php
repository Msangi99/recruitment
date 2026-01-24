<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'candidate_profile_id',
        'level',
        'field_of_study',
        'institution',
        'start_date',
        'end_date',
        'city',
        'country',
        'is_current',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function candidateProfile()
    {
        return $this->belongsTo(CandidateProfile::class);
    }
}
