<?php

namespace App\Models\Frontend;

use App\Models\Backend\Category;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id', 'email'];

    protected $guard = 'customer';

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
