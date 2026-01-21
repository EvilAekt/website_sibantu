# Dokumentasi AdminController

## Deskripsi
Controller untuk mengelola semua fungsi admin termasuk dashboard, manajemen laporan, penarikan dana, dan verifikasi pengguna.

## File Location
`app/Http/Controllers/AdminController.php`

---

## Methods

### `dashboard()`
**Deskripsi**: Menampilkan dashboard admin dengan statistik dan overview sistem

**Return**: `\Illuminate\View\View`

**Fungsi**:
- Menghitung total donasi yang berhasil
- Menghitung jumlah pengguna aktif
- Menghitung laporan yang menunggu verifikasi
- Menghitung kampanye aktif yang terverifikasi
- Mengambil daftar withdrawal pending
- Mengambil daftar pengguna fundraiser yang belum diverifikasi
- Mengambil 10 transaksi terbaru

**View**: `resources/views/admin/dashboard.blade.php`

---

### `reports()`
**Deskripsi**: Menampilkan halaman daftar semua laporan dengan pagination

**Return**: `\Illuminate\View\View`

**Fungsi**:
- Mengambil semua laporan diurutkan dari yang terbaru
- Pagination 10 item per halaman

**View**: `resources/views/admin/reports/index.blade.php`

---

### `verifyReport($id)`
**Deskripsi**: Memverifikasi/menerima laporan tanpa mengkonversinya ke kampanye

**Parameters**:
- `$id` (int) - ID laporan yang akan diverifikasi

**Return**: Redirect kembali dengan pesan sukses

**Proses**:
1. Mencari laporan berdasarkan ID
2. Mengubah status laporan menjadi 'verified'
3. Menyimpan perubahan
4. Redirect kembali dengan pesan "Report verified."

**Route**: `POST /admin/report/{id}/verify`

---

### `rejectReport($id)`
**Deskripsi**: Menolak laporan yang tidak valid

**Parameters**:
- `$id` (int) - ID laporan yang akan ditolak

**Return**: Redirect kembali dengan pesan sukses

**Proses**:
1. Mencari laporan berdasarkan ID
2. Mengubah status laporan menjadi 'rejected'
3. Menyimpan perubahan
4. Redirect kembali dengan pesan "Report rejected."

**Route**: `POST /admin/report/{id}/reject`

---

### `convertToCampaign(Request $request, $id)`
**Deskripsi**: Mengkonversi laporan menjadi kampanye penggalangan dana

**Parameters**:
- `$request` (Request) - Request object berisi data kampanye
- `$id` (int) - ID laporan yang akan dikonversi

**Validation**:
- `target_amount`: required, numeric, minimal 10000
- `deadline`: required, date, harus setelah hari ini
- `title`: required, string, maksimal 255 karakter

**Return**: Redirect ke admin dashboard dengan pesan sukses

**Proses**:
1. Mencari laporan berdasarkan ID
2. Validasi input dari request
3. Membuat kampanye baru dengan data:
   - `fundraiser_id`: ID user pembuat laporan
   - `report_id`: ID laporan yang dikonversi
   - `title`: Judul kampanye (bisa diubah dari judul laporan)
   - `slug`: URL-friendly slug dari judul
   - `description`: Deskripsi dari laporan
   - `target_amount`: Target dana yang ingin dikumpulkan
   - `deadline`: Batas waktu kampanye
   - `is_verified`: true (otomatis terverifikasi karena dibuat admin)
   - `status`: 'active'
4. Mengubah status laporan menjadi 'converted_to_campaign'
5. Jika user pembuat laporan memiliki role 'donatur', upgrade menjadi 'fundraiser'
6. Redirect ke dashboard dengan pesan sukses

**Route**: `POST /admin/report/{id}/convert`

**Catatan**: 
- Kampanye yang dibuat otomatis terverifikasi karena dibuat oleh admin
- User pembuat laporan otomatis menjadi fundraiser untuk kampanye tersebut

---

### `approveWithdrawal($id)`
**Deskripsi**: Menyetujui permintaan penarikan dana dari fundraiser

**Parameters**:
- `$id` (int) - ID withdrawal yang akan disetujui

**Return**: Redirect kembali dengan pesan sukses atau error

**Proses**:
1. Mencari withdrawal berdasarkan ID
2. Cek apakah status masih 'pending'
   - Jika sudah diproses, redirect dengan error
3. Mengubah status withdrawal menjadi 'approved'
4. Menyimpan perubahan
5. Redirect kembali dengan pesan "Withdrawal approved."

**Route**: `POST /admin/withdrawal/{id}/approve`

**Catatan**:
- Saat ini hanya mengubah status, belum ada integrasi dengan payment gateway
- Logika transfer dana masih dalam bentuk mock/simulasi

---

### `verifyUser($id)`
**Deskripsi**: Memverifikasi pengguna fundraiser yang mendaftar

**Parameters**:
- `$id` (int) - ID user yang akan diverifikasi

**Return**: Redirect kembali dengan pesan sukses

**Proses**:
1. Mencari user berdasarkan ID
2. Mengubah `is_verified` menjadi true
3. Menambahkan catatan verifikasi dengan timestamp
4. Menyimpan perubahan
5. Redirect kembali dengan pesan "User verified successfully."

**Route**: `POST /admin/user/{id}/verify`

**Catatan**:
- Hanya fundraiser yang perlu diverifikasi
- Setelah diverifikasi, fundraiser dapat membuat kampanye

---

## Middleware
- `auth`: User harus login
- `verified`: Email user harus terverifikasi
- `role:admin`: User harus memiliki role 'admin'

## Dependencies
- `App\Models\Campaign`
- `App\Models\Report`
- `App\Models\Transaction`
- `App\Models\User`
- `App\Models\Withdrawal`
- `Illuminate\Http\Request`
- `Illuminate\Support\Str`
