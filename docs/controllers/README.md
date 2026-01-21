# Daftar Dokumentasi Controllers

Dokumentasi lengkap untuk semua controller dalam aplikasi SiBantu.

## Controllers Utama

### 1. [AdminController](AdminController.md)
**Fungsi**: Manajemen admin, laporan, withdrawal, dan verifikasi user

**Methods**:
- `dashboard()` - Dashboard admin dengan statistik
- `reports()` - Daftar semua laporan
- `verifyReport($id)` - Verifikasi/terima laporan
- `rejectReport($id)` - Tolak laporan
- `convertToCampaign($request, $id)` - Konversi laporan ke kampanye
- `approveWithdrawal($id)` - Setujui penarikan dana
- `verifyUser($id)` - Verifikasi user fundraiser

**Route Prefix**: `/admin`

---

### 2. [LaporanController](LaporanController.md)
**Fungsi**: Manajemen laporan bencana

**Methods**:
- `index($request)` - Daftar laporan dengan filter
- `create()` - Form buat laporan
- `store($request)` - Simpan laporan baru
- `show($id)` - Detail laporan
- `destroy($id)` - Hapus laporan

**Route Prefix**: `/laporan`

---

### 3. [CampaignController](CampaignController.md)
**Fungsi**: Manajemen kampanye penggalangan dana dan donasi

**Methods**:
- `index($request)` - Daftar kampanye dengan filter
- `show($slug)` - Detail kampanye
- `donate($slug)` - Form donasi
- `storeDonation($request, $slug)` - Proses donasi
- `success($id)` - Halaman konfirmasi donasi

**Route Prefix**: `/campaigns`

---

### 4. [FundraiserController](FundraiserController.md)
**Fungsi**: Manajemen fundraiser, kampanye, dan penarikan dana

**Methods**:
- `dashboard()` - Dashboard fundraiser
- `create()` - Form buat kampanye
- `store($request)` - Simpan kampanye baru
- `edit($id)` - Form edit kampanye
- `update($request, $id)` - Update kampanye
- `destroy($id)` - Hapus kampanye
- `withdraw($request)` - Request penarikan dana
- `withdrawals()` - Riwayat withdrawal

**Route Prefix**: `/fundraiser`

---

## Controllers Pendukung

### AuthController
**Fungsi**: Autentikasi custom (login, register, logout)

**Methods**:
- `showLogin()` - Tampilkan form login
- `login($request)` - Proses login
- `showRegister()` - Tampilkan form registrasi
- `register($request)` - Proses registrasi
- `logout()` - Logout user

---

### DonaturController
**Fungsi**: Dashboard dan riwayat donasi untuk donatur

**Methods**:
- `dashboard()` - Dashboard donatur
- `history()` - Riwayat donasi

**Route Prefix**: `/user`

---

### TransactionController
**Fungsi**: Manajemen transaksi dan simulasi pembayaran

**Methods**:
- `store($request, $slug)` - Buat transaksi baru
- `simulation($code)` - Simulasi pembayaran
- `callback($code)` - Callback dari payment gateway

---

### ProfileController
**Fungsi**: Manajemen profil user

**Methods**:
- `edit()` - Form edit profil
- `update($request)` - Update profil
- `destroy($request)` - Hapus akun

**Route Prefix**: `/profile`

---

### PageController
**Fungsi**: Halaman statis (tentang, FAQ, kebijakan, dll)

**Methods**:
- `caraMelapor()` - Halaman cara melapor
- `syaratKetentuan()` - Syarat dan ketentuan
- `kebijakanPrivasi()` - Kebijakan privasi
- `faq()` - Frequently Asked Questions

---

## Struktur Folder Controllers

```
app/Http/Controllers/
├── Auth/                          # Laravel Breeze Auth Controllers
│   ├── AuthenticatedSessionController.php
│   ├── RegisteredUserController.php
│   └── ...
├── AdminController.php            # ⭐ Admin management
├── AuthController.php             # Custom authentication
├── CampaignController.php         # ⭐ Campaign & donation
├── CampaignUpdateController.php   # Campaign updates
├── Controller.php                 # Base controller
├── DonaturController.php          # Donatur dashboard
├── FundraiserController.php       # ⭐ Fundraiser management
├── LaporanController.php          # ⭐ Report management
├── PageController.php             # Static pages
├── ProfileController.php          # User profile
└── TransactionController.php      # Transaction handling
```

⭐ = Controller utama dengan dokumentasi lengkap

---

## Middleware yang Digunakan

### Authentication
- `auth` - User harus login
- `verified` - Email harus terverifikasi

### Role-Based Access
- `role:admin` - Hanya admin
- `role:fundraiser` - Hanya fundraiser
- `role:donatur` - Hanya donatur

---

## Konvensi Penamaan

### Method Names
- `index()` - Menampilkan daftar
- `create()` - Form untuk membuat data baru
- `store()` - Menyimpan data baru
- `show()` - Menampilkan detail
- `edit()` - Form untuk edit data
- `update()` - Update data
- `destroy()` - Hapus data

### Route Names
Format: `{prefix}.{action}`

Contoh:
- `admin.dashboard`
- `admin.report.verify`
- `campaigns.index`
- `fundraiser.withdraw`

---

## Return Types

### View
```php
return view('folder.file', compact('data'));
```

### Redirect
```php
return redirect()->route('route.name')->with('success', 'Message');
return redirect()->back()->with('error', 'Message');
```

### JSON (untuk API)
```php
return response()->json(['data' => $data]);
```

---

**Terakhir diupdate**: 21 Januari 2026
