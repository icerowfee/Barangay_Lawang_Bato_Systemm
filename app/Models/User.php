<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Applicant;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'province',  // New column
        'city',      // New column
        'barangay',  // New column
        'house_number',
        'civil_status',
        'birthdate',
        'age',
        'sex', 
        'email',
        'contact_number',
        'valid_id',
        'secondary_valid_id',
        'resume',
        'password',
        'rejecting_reason',
        'status'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'firstname',
                'middlename',
                'lastname',
                'province',  // New column
                'city',      // New column
                'barangay',  // New column
                'house_number',
                'civil_status',
                'birthdate',
                'age',
                'sex',
                'email',
                'contact_number',
                'valid_id',
                'secondary_valid_id',
                'resume',
                'rejecting_reason',
                'status'
            ])
            ->logOnlyDirty()
            ->useLogName('user');
    }
    public function getDescriptionForEvent(string $eventName): string
    {

        if ($eventName === 'deleted') {
            return 'Deleted a user account';
        }
        elseif ($eventName === 'created') {
            return 'Created a user account';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Rejected' && $this->status === 'Rejected') {
            return 'Rejected a user account';
        }
        elseif ($eventName === 'updated' && $this->getOriginal('status') !== 'Active' && $this->status === 'Active') {
            return 'Approved a user account';
        }
        return ucfirst($eventName) . " a user account";
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function applications()
    {
        return $this->hasMany(Applicant::class, 'user_id');
    }

}
