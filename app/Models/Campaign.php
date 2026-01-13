<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'fundraiser_id',
        'report_id',
        'title',
        'category',
        'slug',
        'description',
        'target_amount',
        'collected_amount',
        'deadline',
        'image_url',
        'is_verified',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_verified' => 'boolean',
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
    ];

    public function fundraiser()
    {
        return $this->belongsTo(User::class, 'fundraiser_id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function updates()
    {
        return $this->hasMany(CampaignUpdate::class)->latest();
    }
}
