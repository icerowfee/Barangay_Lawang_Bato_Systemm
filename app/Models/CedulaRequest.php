<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CedulaRequest extends Model
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
        'tin',
        'gross_income',
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
            ->useLogName('cedula_request');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'updated' && $this->getOriginal('status') !== 'Rejected' && $this->status === 'Rejected') {
            return 'Rejected a cedula request';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Approved' && $this->status === 'Approved') {
            return 'Approved a cedula request';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Completed' && $this->status === 'Completed') {
            return 'Issued a cedula';
        }
        elseif ($eventName === 'deleted'){
            return 'Deleted a cedula request';
        }


        return "{$eventName} event on cedula";
    }
}
