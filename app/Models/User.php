<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'wallet_balance',
        'ktp_path',
        'is_verified',
        'verification_notes'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'wallet_balance' => 'decimal:2',
        'is_verified' => 'boolean',
    ];

    // --- Role Helpers ---
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isFundraiser()
    {
        return $this->role === 'fundraiser';
    }

    public function isDonatur()
    {
        return $this->role === 'donatur';
    }

    // --- Relationships ---
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'fundraiser_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getKtpUrlAttribute()
    {
        return $this->ktp_path ? asset('storage/' . $this->ktp_path) : null;
    }
}