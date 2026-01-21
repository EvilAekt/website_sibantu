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
  <a href="#tentang">Tentang</a> •
  <a href="#fitur-utama">Fitur</a> •
  <a href="#dokumentasi-teknis">Dokumentasi Teknis</a> •
  <a href="#instalasi">Instalasi</a>
</p>

---

## 📖 Tentang

**SiBantu** adalah platform penghubung masyarakat dengan bantuan kemanusiaan. Sistem ini memvalidasi laporan bencana dari warga sebelum mengubahnya menjadi kampanye donasi publik yang transparan. Solusi ini mengatasi masalah validitas data bencana dan distribusi bantuan yang tidak merata.

## 🚀 Fitur Utama

### 1. Pelaporan Bencana (Crowdsourcing)
- **Laporan Warga:** Upload foto kejadian, lokasi, dan deskripsi.
- **Verifikasi Admin:** Filter laporan valid/hoax sebelum publikasi.
- **Konversi Kampanye:** Ubah laporan valid langsung menjadi galang dana.

### 2. Ekosistem Donasi
- **Tracking Real-time:** Pantau progress dana terkumpul.
- **Multi-Role:** Akses khusus untuk Admin, Fundraiser, dan Donatur.
- **Withdrawal System:** Penarikan dana aman dengan persetujuan admin.

### 3. Keamanan & Performa
- **Role-Based Access Control (RBAC):** Middleware keamanan berlapis.
- **Optimized Assets:** Menggunakan Tailwind CSS dan Vite.

---
### Pipeline Laporan ke Kampanye
```mermaid
graph LR
    A[User Lapor] -->|Status: Pending| B(Admin Review)
    B -->|Valid| C[Verified]
    B -->|Tidak Valid| D[Rejected]
    B -->|Butuh Dana| E[Konversi ke Campaign]
    E --> F[Donasi Publik Dibuka]

## 🔄 Alur Sistem
    
### Alur Donasi
---

## 📚 Dokumentasi Teknis

Detail lengkap struktur kode dan controller untuk pengembang.

### 📁 Struktur Database
| Tabel | Fungsi |
| :--- | :--- |
| `users` | Data Admin, Fundraiser, Donatur. |
| `reports` | Data bencana (Foto, Lokasi, Severity). |
| `campaigns` | Data galang dana, target, dan deadline. |
| `transactions` | Log donasi dan status pembayaran. |
| `withdrawals` | Request pencairan dana fundraiser. |

### 🎮 Controllers

<details>
<summary><strong>1. AdminController (Manajemen Pusat)</strong></summary>

Lokasi: `app/Http/Controllers/AdminController.php`

* **Dashboard** `GET /admin/dashboard`
    * Menampilkan statistik: Total Donasi, User Aktif, Laporan Pending.
* **Verifikasi Laporan** `POST /admin/report/{id}/verify`
    * Mengubah status laporan menjadi `verified`.
* **Konversi Kampanye** `POST /admin/report/{id}/convert`
    * Parameter: `target_amount`, `deadline`, `title`.
    * Fungsi: Membuat kampanye baru dari data laporan dan upgrade user pelapor menjadi fundraiser.
* **Approval Withdrawal** `POST /admin/withdrawal/{id}/approve`
    * Menyetujui pencairan dana fundraiser.
* **Verifikasi User** `POST /admin/user/{id}/verify`
    * Memvalidasi akun fundraiser baru.

</details>

<details>
<summary><strong>2. CampaignController (Publik & Donasi)</strong></summary>

Lokasi: `app/Http/Controllers/CampaignController.php`

* **List Kampanye** `GET /campaigns`
    * Filter: `search`, `category`, `sort` (terbaru, target dana).
* **Detail** `GET /campaigns/{slug}`
    * Menampilkan info kampanye dan list 10 donatur terakhir.
* **Proses Donasi** `POST /campaigns/{slug}/donate`
    * Validasi: Min. Rp 10.000.
    * Logika: Buat transaksi baru dan update `collected_amount`.

</details>

<details>
<summary><strong>3. LaporanController (Input Warga)</strong></summary>

Lokasi: `app/Http/Controllers/LaporanController.php`

* **Buat Laporan** `POST /laporan`
    * Upload bukti foto ke `storage/app/public/reports`.
    * Status awal: `pending`.
* **List Laporan** `GET /laporan`
    * Filter berdasarkan `severity` (ringan/berat) dan lokasi.

</details>

<details>
<summary><strong>4. FundraiserController (Penggalang Dana)</strong></summary>

Lokasi: `app/Http/Controllers/FundraiserController.php`

* **Create Campaign** `POST /fundraiser/campaigns`
    * Hanya untuk user terverifikasi.
    * Status awal: `pending` (perlu approval admin).
* **Withdrawal** `POST /fundraiser/withdraw`
    * Logic: Lock saldo saat request dibuat.

</details>

---

## ⚙️ Instalasi Lokal

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/username/sibantu.git](https://github.com/username/sibantu.git)
    cd sibantu
    ```

2.  **Setup Dependencies**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Sesuaikan database name di file .env*

4.  **Database Migration**
    ```bash
    php artisan migrate --seed
    php artisan storage:link
    ```

5.  **Start Server**
    ```bash
    php artisan serve
    ```

Akses aplikasi di `http://localhost:8000`.

---

## 🔒 Security & Validation

* **Middleware:**
    * `auth`, `verified`: Wajib login & email valid.
    * `role:admin|fundraiser|donatur`: Pembatasan akses route.
* **File Upload:** Validasi mime-type image max 2MB.
* **CSRF:** Proteksi token pada semua form submit.

---

<p align="center">
  Dibuat dengan ❤️ oleh Tim SiBantu
  <br>
  <strong>© 2026</strong>
</p>


