# Dokumentasi LaporanController

## Deskripsi
Controller untuk mengelola laporan bencana yang dibuat oleh pengguna, termasuk menampilkan daftar, membuat, menampilkan detail, dan menghapus laporan.

## File Location
`app/Http/Controllers/LaporanController.php`

---

## Methods

### `index(Request $request)`
**Deskripsi**: Menampilkan daftar semua laporan dengan fitur filter dan pencarian

**Parameters**:
- `$request` (Request) - Request object berisi parameter filter

**Return**: `\Illuminate\View\View`

**Filter yang Tersedia**:
1. **Search** (`search`): Pencarian berdasarkan judul atau lokasi laporan
2. **Category** (`category`): Filter berdasarkan kategori (bencana, kesehatan, infrastruktur, sosial)
3. **Severity** (`severity`): Filter berdasarkan tingkat keparahan (ringan, sedang, berat, darurat)
4. **Status** (`status`): Filter berdasarkan status (pending, verified, rejected)

**Proses**:
1. Membuat query dasar untuk mengambil laporan (diurutkan dari terbaru)
2. Jika ada parameter `search`, filter berdasarkan judul atau lokasi
3. Jika ada parameter `category` (dan bukan 'all'), filter berdasarkan kategori
4. Jika ada parameter `severity` (dan bukan 'all'), filter berdasarkan tingkat keparahan
5. Jika ada parameter `status` (dan bukan 'all'), filter berdasarkan status
6. Pagination 12 item per halaman dengan query string

**View**: `resources/views/laporan/index.blade.php`

**Route**: `GET /laporan`

---

### `create()`
**Deskripsi**: Menampilkan form untuk membuat laporan baru

**Return**: `\Illuminate\View\View`

**View**: `resources/views/laporan/create.blade.php`

**Route**: `GET /laporan/create`

---

### `store(Request $request)`
**Deskripsi**: Menyimpan laporan baru ke database

**Parameters**:
- `$request` (Request) - Request object berisi data laporan

**Validation**:
- `title`: required, string, maksimal 255 karakter
- `category`: required, string
- `severity`: required, string
- `location`: required, string, maksimal 255 karakter
- `description`: required, string
- `image_url`: required, image (jpeg, png, jpg, gif), maksimal 2048 KB (2 MB)

**Return**: Redirect ke halaman daftar laporan dengan pesan sukses

**Proses**:
1. Validasi input dari request
2. Jika ada file gambar yang diupload:
   - Simpan gambar ke folder `storage/app/public/reports`
   - Dapatkan path file
3. Buat laporan baru dengan data:
   - `user_id`: ID user yang sedang login
   - `title`: Judul laporan
   - `category`: Kategori laporan
   - `severity`: Tingkat keparahan
   - `location`: Lokasi kejadian
   - `description`: Deskripsi detail
   - `image_url`: Path gambar yang diupload
   - `status`: 'pending' (menunggu verifikasi admin)
4. Redirect ke `/laporan` dengan pesan "Laporan berhasil dikirim dan menunggu verifikasi."

**Route**: `POST /laporan`

**Catatan**:
- Gambar disimpan di `storage/app/public/reports`
- Untuk mengakses gambar, gunakan `asset('storage/' . $laporan->image_url)`
- Status awal selalu 'pending' dan perlu diverifikasi oleh admin

---

### `show($id)`
**Deskripsi**: Menampilkan detail laporan

**Parameters**:
- `$id` (int) - ID laporan yang akan ditampilkan

**Return**: `\Illuminate\View\View`

**Proses**:
1. Mencari laporan berdasarkan ID
2. Jika tidak ditemukan, throw 404 error
3. Tampilkan view detail laporan

**View**: `resources/views/laporan/show.blade.php`

**Route**: `GET /laporan/{id}`

---

### `destroy($id)`
**Deskripsi**: Menghapus laporan dari database

**Parameters**:
- `$id` (int) - ID laporan yang akan dihapus

**Return**: Redirect ke halaman daftar laporan dengan pesan sukses

**Proses**:
1. Mencari laporan berdasarkan ID
2. Jika laporan memiliki gambar:
   - Hapus file gambar dari storage
3. Hapus laporan dari database
4. Redirect ke `/laporan` dengan pesan "Laporan berhasil dihapus."

**Route**: `DELETE /laporan/{id}`

**Catatan**:
- Gambar juga akan dihapus dari storage untuk menghemat ruang
- Penghapusan bersifat permanent (hard delete)

---

## Middleware
- `auth`: User harus login untuk membuat, melihat detail, dan menghapus laporan
- `verified`: Email user harus terverifikasi

## Dependencies
- `App\Models\Report`
- `Illuminate\Http\Request`
- `Illuminate\Support\Facades\Storage`

## Kategori Laporan
- `bencana`: Bencana Alam
- `kesehatan`: Kesehatan
- `infrastruktur`: Infrastruktur
- `sosial`: Sosial

## Tingkat Keparahan (Severity)
- `ringan`: Ringan
- `sedang`: Sedang
- `berat`: Berat
- `darurat`: Darurat

## Status Laporan
- `pending`: Menunggu verifikasi admin
- `verified`: Diverifikasi/diterima oleh admin
- `rejected`: Ditolak oleh admin
- `converted_to_campaign`: Dikonversi menjadi kampanye penggalangan dana
