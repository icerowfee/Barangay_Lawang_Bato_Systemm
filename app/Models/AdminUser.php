<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    Use HasFactory, Notifiable, LogsActivity;

    protected $table = 'admin_users';

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'birthdate',
        'age',
        'sex',
        'email',
        'password',
        'role',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'firstname',
                'middlename',
                'lastname',
                'birthdate',
                'age',
                'sex',
                'email',
                'password',
                'role',
            ])
            ->logOnlyDirty()
            ->useLogName('admin_user');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'updated' && $this->getDirty()) {
            return 'Edited an admin account';
        }
        elseif ($eventName === 'deleted'){
            return 'Deleted an admin account';
        }


        return ucfirst($eventName) . " an admin account";
    }
    
}
