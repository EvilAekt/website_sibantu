# Dokumentasi Project SiBantu

## Deskripsi Project
SiBantu adalah platform penggalangan dana dan pelaporan bencana yang menghubungkan masyarakat dengan bantuan kemanusiaan yang terverifikasi.

## Struktur Dokumentasi

### 📁 Controllers
Dokumentasi lengkap untuk semua controller dalam aplikasi:

- **[AdminController](controllers/AdminController.md)** - Manajemen admin, laporan, withdrawal, dan verifikasi user
- **[LaporanController](controllers/LaporanController.md)** - Manajemen laporan bencana
- **[CampaignController](controllers/CampaignController.md)** - Manajemen kampanye penggalangan dana dan donasi

### 📋 Fitur Utama

#### 1. Sistem Pelaporan Bencana
- User dapat membuat laporan bencana dengan foto dan detail lokasi
- Admin dapat memverifikasi, menolak, atau mengkonversi laporan menjadi kampanye
- Filter berdasarkan kategori, tingkat keparahan, dan status

#### 2. Kampanye Penggalangan Dana
- Fundraiser dapat membuat kampanye penggalangan dana
- Kampanye harus diverifikasi oleh admin
- User dapat berdonasi dengan berbagai metode pembayaran
- Tracking progress kampanye secara real-time

#### 3. Dashboard Admin
- Statistik lengkap (total donasi, user aktif, laporan pending, kampanye aktif)
- Manajemen laporan (terima, tolak, konversi ke kampanye)
- Manajemen withdrawal fundraiser
- Verifikasi user fundraiser

#### 4. Sistem Role & Permission
- **Admin**: Akses penuh ke semua fitur manajemen
- **Fundraiser**: Dapat membuat kampanye dan menarik dana
- **Donatur**: Dapat membuat laporan dan berdonasi

## Alur Kerja Utama

### Alur Laporan Bencana
```
User Membuat Laporan → Status: Pending
                          ↓
                    Admin Review
                    /     |     \
              Terima   Konversi  Tolak
                ↓         ↓        ↓
           Verified   Campaign  Rejected
```

### Alur Kampanye
```
Fundraiser Buat Kampanye → Pending Verification
                                ↓
                          Admin Verifikasi
                                ↓
                         Status: Active
                                ↓
                      User Dapat Berdonasi
```

### Alur Donasi
```
User Pilih Kampanye → Form Donasi → Proses Pembayaran
                                           ↓
                                    Transaksi Sukses
                                           ↓
                              Update Collected Amount
                                           ↓
                                  Halaman Konfirmasi
```

## Teknologi yang Digunakan

### Backend
- **Framework**: Laravel 10.x
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Storage**: Laravel Storage (untuk upload gambar)

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS
- **Icons**: Font Awesome
- **JavaScript**: Vanilla JS

## Struktur Database

### Tabel Utama
1. **users** - Data pengguna (admin, fundraiser, donatur)
2. **reports** - Laporan bencana
3. **campaigns** - Kampanye penggalangan dana
4. **transactions** - Transaksi donasi
5. **withdrawals** - Permintaan penarikan dana fundraiser

## Route Groups

### Public Routes
- `/` - Homepage
- `/campaigns` - Daftar kampanye
- `/campaigns/{slug}` - Detail kampanye
- `/laporan` - Daftar laporan bencana
- `/login` - Halaman login
- `/register` - Halaman registrasi

### Authenticated Routes
- `/dashboard` - Redirect ke dashboard sesuai role
- `/profile` - Manajemen profil user
- `/laporan/create` - Buat laporan baru

### Admin Routes (Prefix: `/admin`)
- `/admin/dashboard` - Dashboard admin
- `/admin/reports` - Manajemen laporan
- `/admin/report/{id}/verify` - Verifikasi laporan
- `/admin/report/{id}/reject` - Tolak laporan
- `/admin/report/{id}/convert` - Konversi laporan ke kampanye
- `/admin/withdrawal/{id}/approve` - Setujui withdrawal
- `/admin/user/{id}/verify` - Verifikasi user fundraiser

### Fundraiser Routes (Prefix: `/fundraiser`)
- `/fundraiser/dashboard` - Dashboard fundraiser
- `/fundraiser/campaigns` - Manajemen kampanye
- `/fundraiser/withdraw` - Request penarikan dana
- `/fundraiser/withdrawals` - Riwayat withdrawal

### Donatur Routes (Prefix: `/user`)
- `/user/dashboard` - Dashboard donatur
- `/user/history` - Riwayat donasi

## Middleware

### Authentication Middleware
- `auth` - User harus login
- `verified` - Email user harus terverifikasi

### Role Middleware
- `role:admin` - Hanya admin
- `role:fundraiser` - Hanya fundraiser
- `role:donatur` - Hanya donatur

## Validasi & Security

### CSRF Protection
Semua form menggunakan `@csrf` token untuk mencegah CSRF attack

### File Upload
- Validasi tipe file (jpeg, png, jpg, gif)
- Maksimal ukuran file: 2 MB
- File disimpan di `storage/app/public`

### Input Validation
Semua input divalidasi menggunakan Laravel Validation Rules

## Status & Enum Values

### Status Laporan
- `pending` - Menunggu verifikasi
- `verified` - Diverifikasi
- `rejected` - Ditolak
- `converted_to_campaign` - Dikonversi ke kampanye

### Status Kampanye
- `active` - Aktif
- `completed` - Selesai
- `cancelled` - Dibatalkan

### Status Transaksi
- `pending` - Menunggu pembayaran
- `success` - Berhasil
- `failed` - Gagal

### Status Withdrawal
- `pending` - Menunggu persetujuan
- `approved` - Disetujui
- `rejected` - Ditolak

## Kategori

### Kategori Laporan
- `bencana` - Bencana Alam
- `kesehatan` - Kesehatan
- `infrastruktur` - Infrastruktur
- `sosial` - Sosial

### Kategori Kampanye
- `bencana` - Bencana Alam
- `kesehatan` - Kesehatan
- `pendidikan` - Pendidikan
- `sosial` - Sosial
- `lainnya` - Lainnya

### Tingkat Keparahan (Severity)
- `ringan` - Ringan
- `sedang` - Sedang
- `berat` - Berat
- `darurat` - Darurat

## Catatan Pengembangan

### Fitur yang Belum Diimplementasikan
1. **Payment Gateway Integration** - Saat ini menggunakan simulasi pembayaran
2. **Email Notification** - Notifikasi email untuk verifikasi, donasi, dll
3. **Real-time Updates** - WebSocket untuk update real-time
4. **Advanced Analytics** - Dashboard analytics yang lebih detail
5. **Export Data** - Export laporan ke PDF/Excel

### Improvement yang Direncanakan
1. Integrasi dengan payment gateway (Midtrans, Xendit, dll)
2. Sistem notifikasi email dan push notification
3. Dashboard analytics dengan grafik dan chart
4. Fitur komentar dan update kampanye
5. Sistem rating dan review untuk fundraiser
6. Multi-language support

## Kontak & Support
Untuk pertanyaan atau bantuan, silakan hubungi tim development.

---

**Terakhir diupdate**: 21 Januari 2026
