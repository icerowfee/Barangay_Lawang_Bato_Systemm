<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobReferralRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'biodata',
        'sss_id',
        'tin_id',
        'pagibig_id',
        'police_clearance',
        'nbi_clearance',
        'cedula',
        'barangay_clearance',
        'rejecting_reason',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'status'
            ])
            ->logOnlyDirty()
            ->useLogName('job_referral_request');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'updated' && $this->getOriginal('status') !== 'Rejected' && $this->status === 'Rejected') {
            return 'Rejected a job referral request';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Processing' && $this->status === 'Processing') {
            return 'Approved a job referral request';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Scheduled' && $this->status === 'Scheduled') {
            return 'Scheduled a job referral request';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Referred' && $this->status === 'Referred') {
            return 'Referred a job seeker';
        }
        elseif ($eventName === 'deleted'){
            return 'Deleted a job referral request';
        }
        elseif ($eventName === 'created') {
            return 'Apply for a job referral request';
        }
        return ucfirst($eventName) . " a job referral request";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
