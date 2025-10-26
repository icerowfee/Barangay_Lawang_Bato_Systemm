<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicant extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_listing_id',
        'user_id',
        'weight',
        'height',
        'educational_attainment',
        'special_program',
        'certificate_number',
        'resume',
        'valid_id',
        'secondary_valid_id',
        'rejecting_reason',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class, 'job_listing_id');
    }
    
}
