-- ==========================================
-- CHEAT SHEET: MANUAL DATA ENTRY VIA SQL
-- ==========================================
-- Gunakan perintah-perintah ini di phpMyAdmin, DBeaver, atau Terminal MySQL
-- untuk memasukkan data secara manual tanpa lewat website.

-- 1. INSERT USER (FUNDRAISER)
-- Role: 'admin', 'fundraiser', 'donatur'
-- Password default 'password' (bcrypt hash): $2y$12$K.g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2
INSERT INTO users (name, email, password, role, is_verified, wallet_balance, created_at, updated_at)
VALUES 
('Yayasan Maju Bersama', 'yayasan@maju.com', '$2y$12$K.g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2', 'fundraiser', 1, 0, NOW(), NOW());

-- 2. INSERT CAMPAIGN (DAFTAR BANTUAN)
-- Pastikan 'fundraiser_id' sesuai dengan ID user yang ada di tabel users.
-- Kategori: 'bencana_alam', 'kesehatan', 'pendidikan', 'sosial', 'infrastruktur', 'kemanusiaan'
INSERT INTO campaigns (
    fundraiser_id, 
    title, 
    slug, 
    description, 
    category,
    target_amount, 
    collected_amount, 
    deadline, 
    image_url, 
    is_verified, 
    status, 
    created_at, 
    updated_at
) VALUES (
    2, -- Ganti dengan ID Fundraiser yang valid
    'Bantuan Banjir Kota X', -- Judul
    'bantuan-banjir-kota-x', -- Slug (harus unik, ganti spasi dengan -)
    'Deskripsi lengkap kejadian bencana dan kebutuhan...', -- Deskripsi
    'bencana_alam', -- Kategori
    100000000, -- Target (Rp 100 Juta)
    0, -- Terkumpul (Awal 0)
    '2026-12-31', -- Deadline (YYYY-MM-DD)
    'campaigns/placeholder.jpg', -- Path gambar (bisa pakai link luar juga kalau codingannya support, tapi defaultnya path lokal)
    1, -- is_verified (1 = Sudah Verifikasi)
    'active', -- Status ('active', 'pending', 'completed')
    NOW(), 
    NOW()
);

-- 3. INSERT REPORT (LAPORAN BENCANA)
-- Status: 'pending', 'verified', 'rejected'
-- Severity: 'ringan', 'sedang', 'berat'
INSERT INTO reports (
    user_id,
    title,
    description,
    location,
    severity,
    category,
    status,
    image_proof,
    created_at,
    updated_at
) VALUES (
    3, -- ID Pelapor (User biasa/Donatur)
    'Tanah Longsor di Desa Y',
    'Tebing setinggi 5 meter longsor menutupi jalan utama warga.',
    'Desa Y, Kecamatan Z',
    'berat',
    'bencana_alam',
    'pending',
    'reports/proof.jpg', -- Bukti foto
    NOW(),
    NOW()
);

-- 4. INSERT DONATUR (USER)
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES ('Budi Dermawan', 'budi@gmail.com', '$2y$12$K.g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2/g/2', 'donatur', NOW(), NOW());

-- 4. INSERT TRANSAKSI (DONASI MANUAL)
-- Pastikan user_id dan campaign_id valid
INSERT INTO transactions (
    transaction_code,
    user_id,
    campaign_id,
    amount,
    status,
    payment_method,
    created_at,
    updated_at
) VALUES (
    'TRX-MANUAL-001', -- Kode Transaksi Unik
    3, -- ID Donatur
    1, -- ID Campaign
    500000, -- Jumlah Donasi
    'success', -- Status ('pending', 'success', 'failed')
    'manual_transfer', -- Metode Pembayaran
    NOW(),
    NOW()
);

-- UPDATE SALDO KAMPANYE (PENTING JIKA INSERT TRANSAKSI MANUAL!)
-- Kalau insert transaksi manual, jangan lupa update collected_amount di tabel campaigns
UPDATE campaigns 
SET collected_amount = collected_amount + 500000 
WHERE id = 1;
