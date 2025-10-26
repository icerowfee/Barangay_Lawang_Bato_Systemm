<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'job_title',
        'job_category',
        'job_description',
        'job_location',
        'min_salary',
        'max_salary',
        'employment_type',
        'application_deadline',
        'min_age',
        'max_age',
        'min_height',
        'max_height',
        'min_weight',
        'max_weight',
        'educational_attainment',
        'special_program',
        'certificate_number',
        'is_special_program_optional',
        'rejecting_reason',
        'posted_by',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($job) {
            if (empty($job->job_id)) {
                // Lock table to prevent race conditions if needed
                $lastId = self::lockForUpdate()->max('id') ?? 0;
                $nextId = $lastId + 1;

                $job->job_id = 'JP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'posted_by');
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'job_listing_id');
    }
}
