<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndigencyRequest extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'recipient_firstname',
        'recipient_middlename',
        'recipient_lastname',
        'representative_firstname',
        'representative_middlename',    
        'representative_lastname',
        'house_number',
        'barangay',  // New column
        'city',      // New column
        'province',  // New column
        'email',
        'contact_number',
        'user_purpose',
        'actual_purpose',
        'valid_id',
        'data_privacy_agreement',
        'rejecting_reason',
        'request_expires_at',
        'status',
        // add valid_id_viewed
        // add recipient_data
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'status'
            ])
            ->logOnlyDirty()
            ->useLogName('indigency_request');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'updated' && $this->getOriginal('status') !== 'Rejected' && $this->status === 'Rejected') {
            return 'Rejected an indigency request';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Approved' && $this->status === 'Approved') {
            return 'Approved an indigency request';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Completed' && $this->status === 'Completed') {
            return 'Issued an indigency request';
        }
        elseif ($eventName === 'deleted'){
            return 'Deleted an indigency request';
        }


        return ucfirst($eventName) .  " an indigency request";
    }
}
