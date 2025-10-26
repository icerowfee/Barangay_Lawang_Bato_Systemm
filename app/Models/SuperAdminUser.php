<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuperAdminUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password'
    ];
}
