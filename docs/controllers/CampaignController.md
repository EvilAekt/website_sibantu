# Dokumentasi CampaignController

## Deskripsi
Controller untuk mengelola kampanye penggalangan dana publik, termasuk menampilkan daftar, detail, dan proses donasi.

## File Location
`app/Http/Controllers/CampaignController.php`

---

## Methods

### `index(Request $request)`
**Deskripsi**: Menampilkan daftar semua kampanye aktif dengan fitur filter dan sorting

**Parameters**:
- `$request` (Request) - Request object berisi parameter filter dan sorting

**Return**: `\Illuminate\View\View`

**Filter yang Tersedia**:
1. **Search** (`search`): Pencarian berdasarkan judul kampanye
2. **Category** (`category`): Filter berdasarkan kategori (bencana, kesehatan, pendidikan, sosial, lainnya)
3. **Sort** (`sort`): Pengurutan kampanye
   - `newest`: Terbaru (default)
   - `oldest`: Terlama
   - `target_asc`: Target dana terkecil
   - `target_desc`: Target dana terbesar

**Proses**:
1. Membuat query dasar untuk kampanye dengan status 'active' dan `is_verified` = true
2. Jika ada parameter `search`, filter berdasarkan judul kampanye
3. Jika ada parameter `category` (dan bukan 'all'), filter berdasarkan kategori
4. Terapkan sorting berdasarkan parameter `sort`:
   - `oldest`: Urutkan dari yang terlama
   - `target_asc`: Urutkan dari target dana terkecil
   - `target_desc`: Urutkan dari target dana terbesar
   - Default: Urutkan dari yang terbaru
5. Pagination 12 item per halaman dengan query string

**View**: `resources/views/campaigns/index.blade.php`

**Route**: `GET /campaigns`

---

### `show($slug)`
**Deskripsi**: Menampilkan detail kampanye dan daftar donatur

**Parameters**:
- `$slug` (string) - Slug URL kampanye

**Return**: `\Illuminate\View\View`

**Proses**:
1. Mencari kampanye berdasarkan slug dengan status 'active'
2. Jika tidak ditemukan, throw 404 error
3. Mengambil 10 donatur terbaru yang berhasil melakukan donasi
4. Tampilkan view detail kampanye dengan data kampanye dan donatur

**View**: `resources/views/campaigns/show.blade.php`

**Route**: `GET /campaigns/{slug}`

---

### `donate($slug)`
**Deskripsi**: Menampilkan halaman form donasi untuk kampanye tertentu

**Parameters**:
- `$slug` (string) - Slug URL kampanye

**Return**: `\Illuminate\View\View`

**Proses**:
1. Mencari kampanye berdasarkan slug dengan status 'active'
2. Jika tidak ditemukan, throw 404 error
3. Tampilkan form donasi

**View**: `resources/views/campaigns/donate.blade.php`

**Route**: `GET /campaigns/{slug}/donate`

---

### `storeDonation(Request $request, $slug)`
**Deskripsi**: Memproses donasi yang dilakukan oleh user

**Parameters**:
- `$request` (Request) - Request object berisi data donasi
- `$slug` (string) - Slug URL kampanye

**Validation**:
- `amount`: required, numeric, minimal 10000 (Rp 10.000)
- `payment_method`: required, string

**Return**: Redirect ke halaman sukses donasi

**Proses**:
1. Mencari kampanye berdasarkan slug dengan status 'active'
2. Validasi input dari request
3. Membuat transaksi baru dengan data:
   - `campaign_id`: ID kampanye
   - `user_id`: ID user yang sedang login
   - `amount`: Jumlah donasi
   - `payment_method`: Metode pembayaran yang dipilih
   - `status`: 'success' (simulasi pembayaran langsung berhasil)
   - `transaction_code`: Kode transaksi unik (format: TRX-XXXXXXXXXX)
4. Update `collected_amount` kampanye dengan menambahkan jumlah donasi
5. Simpan perubahan kampanye
6. Redirect ke halaman sukses dengan ID transaksi

**Route**: `POST /campaigns/{slug}/donate`

**Middleware**: `auth` (user harus login)

**Catatan**:
- Saat ini menggunakan simulasi pembayaran (langsung sukses)
- Belum ada integrasi dengan payment gateway
- Minimal donasi adalah Rp 10.000

---

### `success($id)`
**Deskripsi**: Menampilkan halaman konfirmasi donasi berhasil

**Parameters**:
- `$id` (int) - ID transaksi

**Return**: `\Illuminate\View\View`

**Proses**:
1. Mencari transaksi berdasarkan ID dengan relasi kampanye
2. Jika tidak ditemukan, throw 404 error
3. Tampilkan halaman sukses dengan detail transaksi

**View**: `resources/views/donations/success.blade.php`

**Route**: `GET /donations/success/{id}`

**Middleware**: `auth` (user harus login)

---

## Middleware
- **Public Routes** (tidak perlu login):
  - `index()`: Daftar kampanye
  - `show()`: Detail kampanye
  - `donate()`: Form donasi
  
- **Protected Routes** (perlu login):
  - `storeDonation()`: Proses donasi
  - `success()`: Halaman sukses

## Dependencies
- `App\Models\Campaign`
- `App\Models\Transaction`
- `Illuminate\Http\Request`

## Kategori Kampanye
- `bencana`: Bencana Alam
- `kesehatan`: Kesehatan
- `pendidikan`: Pendidikan
- `sosial`: Sosial
- `lainnya`: Lainnya

## Status Kampanye
- `active`: Kampanye aktif dan dapat menerima donasi
- `completed`: Kampanye selesai (target tercapai atau deadline lewat)
- `cancelled`: Kampanye dibatalkan

## Metode Pembayaran
Saat ini sistem mendukung berbagai metode pembayaran (simulasi):
- Bank Transfer
- E-Wallet (GoPay, OVO, Dana, dll)
- Credit/Debit Card
- Virtual Account

**Catatan**: Integrasi payment gateway belum diimplementasikan, semua transaksi langsung berstatus 'success'

## Alur Donasi

```
1. User membuka halaman kampanye (/campaigns/{slug})
2. User klik "Donasi Sekarang"
3. User diarahkan ke form donasi (/campaigns/{slug}/donate)
4. User mengisi jumlah donasi dan memilih metode pembayaran
5. User klik "Lanjutkan Pembayaran"
6. Sistem membuat transaksi dengan status 'success' (simulasi)
7. Sistem update collected_amount kampanye
8. User diarahkan ke halaman sukses (/donations/success/{id})
```

## Perhitungan Progress Kampanye

Progress kampanye dihitung dengan rumus:
```
progress = (collected_amount / target_amount) * 100
```

Progress maksimal yang ditampilkan adalah 100% meskipun donasi melebihi target.
