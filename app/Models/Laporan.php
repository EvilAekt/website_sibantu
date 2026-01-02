<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'nama_pelapor',
        'lokasi',
        'deskripsi',
        'jenis_bantuan',
        'foto',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function penyaluran()
    {
        return $this->hasMany(Penyaluran::class, 'id_laporan');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'baru' => 'badge-warning',
            'diproses' => 'badge-info',
            'selesai' => 'badge-success',
        ];
        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getJenisBadgeAttribute()
    {
        $badges = [
            'pangan' => 'badge-primary',
            'sandang' => 'badge-secondary',
            'papan' => 'badge-dark',
            'kesehatan' => 'badge-danger',
            'pendidikan' => 'badge-info',
            'lainnya' => 'badge-light',
        ];
        return $badges[$this->jenis_bantuan] ?? 'badge-secondary';
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'baru' => 'Baru',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            default => ucfirst($this->status),
        };
    }
}
