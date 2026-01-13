<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'fundraiser_id',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function fundraiser()
    {
        return $this->belongsTo(User::class, 'fundraiser_id');
    }
}
