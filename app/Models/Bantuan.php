<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bantuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bantuan',
        'kategori',
        'stok',
        'keterangan',
    ];

    protected $appends = ['stok_status', 'stok_badge'];

    public function getStokStatusAttribute()
    {
        return $this->stok > 0 ? 'Tersedia' : 'Habis';
    }

    public function getStokBadgeAttribute()
    {
        return $this->stok > 0 ? 'badge-success' : 'badge-danger';
    }
}
