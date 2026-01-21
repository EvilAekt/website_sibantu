# Dokumentasi FundraiserController

## Deskripsi
Controller untuk mengelola fungsi fundraiser termasuk dashboard, manajemen kampanye, dan penarikan dana.

## File Location
`app/Http/Controllers/FundraiserController.php`

---

## Methods

### `dashboard()`
**Deskripsi**: Menampilkan dashboard fundraiser dengan statistik kampanye

**Return**: `\Illuminate\View\View`

**Data yang Ditampilkan**:
- Daftar kampanye yang dimiliki fundraiser
- Total dana terkumpul dari semua kampanye
- Saldo yang tersedia untuk ditarik
- Statistik kampanye (aktif, selesai, pending)

**View**: `resources/views/fundraiser/dashboard.blade.php`

**Route**: `GET /fundraiser/dashboard`

---

### `create()`
**Deskripsi**: Menampilkan form untuk membuat kampanye baru

**Return**: `\Illuminate\View\View`

**View**: `resources/views/fundraiser/campaigns/create.blade.php`

**Route**: `GET /fundraiser/campaigns/create`

**Catatan**: Hanya fundraiser yang sudah diverifikasi yang dapat membuat kampanye

---

### `store(Request $request)`
**Deskripsi**: Menyimpan kampanye baru ke database

**Parameters**:
- `$request` (Request) - Request object berisi data kampanye

**Validation**:
- `title`: required, string, maksimal 255 karakter
- `category`: required, string
- `description`: required, string
- `target_amount`: required, numeric, minimal 100000 (Rp 100.000)
- `deadline`: required, date, harus setelah hari ini
- `image_url`: optional, image (jpeg, png, jpg, gif), maksimal 2048 KB

**Return**: Redirect ke dashboard fundraiser dengan pesan sukses

**Proses**:
1. Validasi input
2. Upload gambar jika ada
3. Buat kampanye dengan status 'pending' (menunggu verifikasi admin)
4. Generate slug unik dari judul
5. Redirect dengan pesan sukses

**Route**: `POST /fundraiser/campaigns`

---

### `edit($id)`
**Deskripsi**: Menampilkan form edit kampanye

**Parameters**:
- `$id` (int) - ID kampanye yang akan diedit

**Return**: `\Illuminate\View\View`

**View**: `resources/views/fundraiser/campaigns/edit.blade.php`

**Route**: `GET /fundraiser/campaigns/{id}/edit`

**Catatan**: Fundraiser hanya dapat mengedit kampanye miliknya sendiri

---

### `update(Request $request, $id)`
**Deskripsi**: Update data kampanye

**Parameters**:
- `$request` (Request) - Request object berisi data kampanye
- `$id` (int) - ID kampanye yang akan diupdate

**Validation**: Sama seperti `store()` method

**Return**: Redirect ke dashboard dengan pesan sukses

**Route**: `PUT /fundraiser/campaigns/{id}`

---

### `destroy($id)`
**Deskripsi**: Menghapus kampanye

**Parameters**:
- `$id` (int) - ID kampanye yang akan dihapus

**Return**: Redirect ke dashboard dengan pesan sukses

**Proses**:
1. Cek apakah kampanye milik fundraiser yang sedang login
2. Cek apakah kampanye sudah menerima donasi
3. Jika sudah ada donasi, tidak dapat dihapus
4. Hapus gambar dari storage
5. Hapus kampanye dari database

**Route**: `DELETE /fundraiser/campaigns/{id}`

---

### `withdraw(Request $request)`
**Deskripsi**: Membuat permintaan penarikan dana

**Parameters**:
- `$request` (Request) - Request object berisi data withdrawal

**Validation**:
- `amount`: required, numeric, minimal 50000 (Rp 50.000)
- `bank_name`: required, string
- `account_number`: required, string
- `account_name`: required, string

**Return**: Redirect kembali dengan pesan sukses atau error

**Proses**:
1. Validasi input
2. Cek saldo fundraiser
3. Jika saldo tidak cukup, return error
4. Buat withdrawal request dengan status 'pending'
5. Kurangi saldo fundraiser (lock balance)
6. Redirect dengan pesan sukses

**Route**: `POST /fundraiser/withdraw`

**Catatan**: 
- Minimal penarikan Rp 50.000
- Saldo akan di-lock sampai withdrawal disetujui admin

---

### `withdrawals()`
**Deskripsi**: Menampilkan riwayat penarikan dana

**Return**: `\Illuminate\View\View`

**Data yang Ditampilkan**:
- Daftar semua withdrawal request fundraiser
- Status setiap withdrawal (pending, approved, rejected)
- Detail bank account

**View**: `resources/views/fundraiser/withdrawals.blade.php`

**Route**: `GET /fundraiser/withdrawals`

---

## Middleware
- `auth`: User harus login
- `verified`: Email harus terverifikasi
- `role:fundraiser`: User harus memiliki role fundraiser

## Aturan Bisnis

### Pembuatan Kampanye
- Fundraiser harus sudah diverifikasi oleh admin
- Minimal target dana: Rp 100.000
- Deadline harus di masa depan
- Kampanye baru berstatus 'pending' sampai diverifikasi admin

### Penarikan Dana
- Minimal penarikan: Rp 50.000
- Saldo harus mencukupi
- Withdrawal berstatus 'pending' sampai disetujui admin
- Saldo akan di-lock saat withdrawal dibuat

### Edit/Hapus Kampanye
- Hanya dapat mengedit/hapus kampanye milik sendiri
- Kampanye yang sudah menerima donasi tidak dapat dihapus
- Update kampanye tidak memerlukan verifikasi ulang

## Dependencies
- `App\Models\Campaign`
- `App\Models\Withdrawal`
- `App\Models\Transaction`
- `Illuminate\Http\Request`
