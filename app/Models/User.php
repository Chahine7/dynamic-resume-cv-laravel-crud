<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
        'provider_token',
        'provider_refresh_token',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    
    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id');
    }

    public function contactInformation()
    {
        return $this->hasOne(ContactInformation::class, 'user_id');
    }

    public function education()
    {
        return $this->hasMany(Education::class, 'user_id');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'user_id');
    }

    public function projects()
    {
        return $this->hasMany(Projects::class, 'user_id');
    }

    public function skills()
    {
        return $this->hasMany(Skills::class, 'user_id');
    }

    public function languages()
    {
        return $this->hasMany(Languages::class, 'user_id');
    }

    public function interests()
    {
        return $this->hasMany(Interests::class, 'user_id');
    }
}