<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">SiBantu</h1>

<p align="center">
  <strong>Platform Penggalangan Dana & Pelaporan Bencana Terintegrasi</strong>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 10"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php" alt="PHP"></a>
  <a href="#"><img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind"></a>
  <a href="#"><img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL"></a>
</p>

<p align="center">
  <a href="#fitur-utama">Fitur</a> •
  <a href="#alur-sistem">Alur Sistem</a> •
  <a href="#struktur-database">Database</a> •
  <a href="#dokumentasi-teknis">Dokumentasi Teknis</a> •
  <a href="#instalasi">Instalasi</a>
</p>

---

## 📖 Deskripsi

**SiBantu** menghubungkan masyarakat yang membutuhkan pertolongan dengan bantuan kemanusiaan yang terverifikasi. Platform ini mengatasi masalah validitas data bencana dengan sistem verifikasi berjenjang sebelum dikonversi menjadi kampanye donasi publik.

## 🚀 Fitur Utama

### 1. Pelaporan Bencana (Crowdsourcing)
* **Laporan Warga:** User membuat laporan dengan bukti foto, lokasi, dan tingkat keparahan.
* **Verifikasi Admin:** Admin memvalidasi laporan sebelum publikasi.
* **Konversi Kampanye:** Laporan valid dapat langsung dikonversi menjadi kampanye donasi.

### 2. Penggalangan Dana (Campaign)
* **Transparansi:** Tracking progress donasi secara real-time.
* **Manajemen Fundraiser:** Dashboard khusus bagi penggalang dana untuk mengelola kampanye.
* **Withdrawal System:** Sistem penarikan dana dengan approval admin.

### 3. Keamanan & Peran (Role-Based)
* **Admin:** Kontrol penuh (Verifikasi User, Laporan, Withdrawal).
* **Fundraiser:** Membuat kampanye dan menarik dana.
* **Donatur:** Melapor bencana dan berdonasi.

---

## 🔄 Alur Sistem

### Pipeline Laporan ke Kampanye
```mermaid
graph LR
    A[User Lapor] -->|Status: Pending| B(Admin Review)
    B -->|Valid| C[Verified]
    B -->|Tidak Valid| D[Rejected]
    B -->|Butuh Dana| E[Konversi ke Campaign]
    E --> F[Donasi Publik Dibuka]
