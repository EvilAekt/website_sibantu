<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyaluran extends Model
{
    use HasFactory;
    protected $table = 'penyaluran';
    protected $guarded = [];
    protected $fillable = [
        'id_laporan',
        'id_bantuan',
        'tanggal_penyaluran',
        'petugas',
        'jumlah',
        'status',
    ];

    protected $casts = [
        'tanggal_penyaluran' => 'date',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan');
    }

    public function bantuan()
    {
        return $this->belongsTo(Bantuan::class, 'id_bantuan');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'dijadwalkan' => 'badge-warning',
            'dalam_perjalanan' => 'badge-info',
            'tersalurkan' => 'badge-success',
        ];
        return $badges[$this->status] ?? 'badge-secondary';
    }
}
