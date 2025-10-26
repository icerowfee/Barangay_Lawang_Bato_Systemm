<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Authenticatable
{

    Use HasFactory, Notifiable;
    
    protected $fillable = [
        'company_name',
        'business_type',
        'street_address',
        'barangay',
        'city',
        'contact_person_name',
        'contact_person_position',
        'contact_person_email',
        'contact_person_contact_number',
        'account_email',
        'password',
        'description', 
        'registration_document',
        'contact_person_valid_id',
        'verified_at',
        'verified_by',
        'status',
        'rejecting_reason',
    ];

    protected $hidden = [
        'password',
    ];

    protected static $logAttributes = [
        'company_name',
        'business_type',
        'street_address',
        'barangay',
        'city',
        'contact_person_name',
        'contact_person_position',
        'contact_person_email',
        'contact_person_contact_number',
        'account_email',
        'description',
        'website',
        'logo',
        'registration_document',
        'contact_person_valid_id',
        'verified_at',
        'verified_by',
        'status',
        'rejecting_reason',
    ];
    protected static $logName = 'Company';
    protected static $logOnlyDirty = true;
    
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Company has been {$eventName}";
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class, 'posted_by');
    }
}
