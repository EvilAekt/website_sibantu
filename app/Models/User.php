<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'ktp_path',
        'is_verified',
        'verification_notes'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isRelawan()
    {
        return $this->role === 'relawan';
    }

    public function getKtpUrlAttriute()
    {
        return $this->ktp_path ? asset('storage/' .$this->ktp_path) : null;
    }

    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false)->where('role', 'relawan');
    }
}