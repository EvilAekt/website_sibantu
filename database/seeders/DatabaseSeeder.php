<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bantuan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Users
        User::create([
            'nama' => 'Admin Utama',
            'email' => 'admin@bantuan.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Relawan 1',
            'email' => 'relawan@bantuan.com',
            'password' => Hash::make('relawan123'),
            'role' => 'relawan'
        ]);

        // Create Bantuan
        $bantuanData = [
            ['nama_bantuan' => 'Beras 10kg', 'kategori' => 'pangan', 'stok' => 100, 'keterangan' => 'Beras kualitas baik'],
            ['nama_bantuan' => 'Minyak Goreng 2L', 'kategori' => 'pangan', 'stok' => 80, 'keterangan' => 'Minyak goreng kemasan'],
            ['nama_bantuan' => 'Pakaian Layak', 'kategori' => 'sandang', 'stok' => 50, 'keterangan' => 'Pakaian bekas layak pakai'],
            ['nama_bantuan' => 'Selimut', 'kategori' => 'sandang', 'stok' => 30, 'keterangan' => 'Selimut tebal'],
            ['nama_bantuan' => 'Terpal', 'kategori' => 'papan', 'stok' => 25, 'keterangan' => 'Terpal ukuran 4x6m'],
            ['nama_bantuan' => 'Obat-obatan', 'kategori' => 'kesehatan', 'stok' => 40, 'keterangan' => 'Paket obat-obatan dasar'],
        ];

        foreach ($bantuanData as $bantuan) {
            Bantuan::create($bantuan);
        }
    }
}
