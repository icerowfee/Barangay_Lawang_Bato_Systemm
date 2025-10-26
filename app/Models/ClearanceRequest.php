<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClearanceRequest extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'house_number',
        'barangay',  // New column
        'city',      // New column
        'province',  // New column
        'civil_status',
        'birthplace',
        'birthdate',
        'age',
        'sex', 
        'email',
        'contact_number',
        'years_stay',
        'user_purpose',
        'actual_purpose',
        'valid_id',
        'data_privacy_agreement',
        'rejecting_reason',
        'request_expires_at',
        'status',
        // add valid_id_viewed
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'status'
            ])
            ->logOnlyDirty()
            ->useLogName('clearance_request');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'updated' && $this->getOriginal('status') !== 'Rejected' && $this->status === 'Rejected') {
            return 'Rejected a clearance request';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Approved' && $this->status === 'Approved') {
            return 'Approved a clearance request';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Completed' && $this->status === 'Completed') {
            return 'Issued a clearance certificate';
        }
        elseif ($eventName === 'deleted'){
            return 'Deleted a clearance request';
        }


        return ucfirst($eventName) .  " a clearance request";
    }
}
