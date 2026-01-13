<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Report;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@sibantu.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        // 2. Fundraisers (Verified)
        $fundraiser1 = User::create([
            'name' => 'Yayasan Peduli Kasih',
            'email' => 'yayasan@peduli.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'is_verified' => true,
            'wallet_balance' => 15000000,
        ]);

        $fundraiser2 = User::create([
            'name' => 'Komunitas Badai Pasti Berlalu',
            'email' => 'komunitas@badaipasti.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'is_verified' => true,
            'wallet_balance' => 5000000,
        ]);

        // 3. Fundraiser (Unverified)
        User::create([
            'name' => 'Mahasiswa Peduli Bencana',
            'email' => 'mahasiswa@peduli.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'is_verified' => false,
        ]);

        // 4. Donaturs
        $donaturs = [];
        for ($i = 1; $i <= 5; $i++) {
            $donaturs[] = User::create([
                'name' => 'Donatur Baik ' . $i,
                'email' => "donatur{$i}@gmail.com",
                'password' => Hash::make('password'),
                'role' => 'donatur',
            ]);
        }

        // 5. Campaigns
        $campaigns = [
            [
                'title' => 'Bantu Korban Banjir Bandang Demak',
                'description' => 'Ribuan warga kehilangan tempat tinggal akibat banjir bandang yang menerjang wilayah Demak. Anak-anak dan lansia membutuhkan selimut, makanan, dan obat-obatan segera. Mari bantu mereka bangkit kembali dengan donasi Anda.',
                'target_amount' => 500000000, // 500 Juta
                'collected_amount' => 125000000,
                'deadline' => now()->addDays(30),
                'status' => 'active',
                'fundraiser_id' => $fundraiser1->id,
                'category' => 'bencana_alam',
                'slug' => 'bantu-korban-banjir-demak',
                'is_verified' => true,
            ],
            [
                'title' => 'Renovasi Sekolah Dasar di Pelosok NTT',
                'description' => 'Satu-satunya sekolah di desa ini rusak parah. Atap bocor dan dinding retak membahayakan siswa. Anak-anak harus berjalan 5km hanya untuk belajar di tempat yang tidak layak. Kita bisa mengubah masa depan pendidikan mereka.',
                'target_amount' => 200000000, // 200 Juta
                'collected_amount' => 180000000,
                'deadline' => now()->addDays(15),
                'status' => 'active',
                'fundraiser_id' => $fundraiser1->id,
                'category' => 'pendidikan',
                'slug' => 'renovasi-sekolah-ntt',
                'is_verified' => true,
            ],
            [
                'title' => 'Bantuan Medis Balita Gizi Buruk',
                'description' => 'Adik kecil Rizky (2 tahun) mengalami gizi buruk akut dan komplikasi paru-paru. Orang tuanya buruh tani tidak mampu membiayai pengobatan intensif di RS Kota. Bantuan Anda adalah harapan hidup baginya.',
                'target_amount' => 50000000, // 50 Juta
                'collected_amount' => 45000000,
                'deadline' => now()->addDays(5),
                'status' => 'active',
                'fundraiser_id' => $fundraiser2->id,
                'category' => 'kesehatan',
                'slug' => 'bantuan-medis-gizi-buruk',
                'is_verified' => true,
            ],
            [
                'title' => 'Darurat Gempa Cianjur: Butuh Tenda & Makanan',
                'description' => 'Gempa susulan masih terus terjadi. Warga terpaksa tidur di luar rumah tanpa perlindungan memadai dari hujan dan angin malam. Prioritas saat ini adalah tenda peleton, selimut tebal, dan dapur umum.',
                'target_amount' => 1000000000, // 1 Milyar
                'collected_amount' => 0,
                'deadline' => now()->addDays(60),
                'status' => 'pending', // Pending verification
                'fundraiser_id' => $fundraiser2->id,
                'category' => 'bencana_alam',
                'slug' => 'darurat-gempa-cianjur',
                'is_verified' => false,
            ],
            [
                'title' => 'Beasiswa Anak Yatim Berprestasi',
                'description' => 'Program beasiswa penuh untuk 50 anak yatim piatu berprestasi yang terancam putus sekolah karena biaya. Mencakup SPP, seragam, dan buku hingga lulus SMA.',
                'target_amount' => 150000000,
                'collected_amount' => 25000000,
                'deadline' => now()->addDays(90),
                'status' => 'active',
                'fundraiser_id' => $fundraiser1->id,
                'category' => 'pendidikan',
                'slug' => 'beasiswa-anak-yatim',
                'is_verified' => true,
            ],
            [
                'title' => 'Operasi Jantung Adik Sarah',
                'description' => 'Sarah didiagnosa kelainan jantung bawaan sejak lahir. Dokter menyarankan operasi segera sebelum usianya 5 tahun. Mari patungan untuk senyum Sarah kembali.',
                'target_amount' => 300000000,
                'collected_amount' => 10000000,
                'deadline' => now()->addDays(40),
                'status' => 'active',
                'fundraiser_id' => $fundraiser2->id,
                'category' => 'kesehatan',
                'slug' => 'operasi-jantung-sarah',
                'is_verified' => true,
            ],
            [
                'title' => 'Sedekah Makanan Jumat Berkah',
                'description' => 'Berbagi 500 nasi boks setiap hari Jumat untuk kaum dhuafa, pemulung, dan pekerja jalanan di sekitar Jakarta Pusat. Sedekahmu, senyum mereka.',
                'target_amount' => 10000000,
                'collected_amount' => 8500000,
                'deadline' => now()->addDays(7),
                'status' => 'active',
                'fundraiser_id' => $fundraiser1->id,
                'category' => 'sosial',
                'slug' => 'sedekah-jumat-berkah',
                'is_verified' => true,
            ],
            [
                'title' => 'Pembangunan Sumur Wakaf Desa Kekeringan',
                'description' => 'Desa Karangmojo mengalami krisis air bersih setiap kemarau. Warga harus berjalan 3km untuk ambil air keruh. Wakaf sumur bor ini akan mengalirkan air bersih untuk 300 KK selamanya.',
                'target_amount' => 75000000,
                'collected_amount' => 75000000,
                'deadline' => now()->subDays(1), // Sudah selesai
                'status' => 'completed',
                'fundraiser_id' => $fundraiser2->id,
                'category' => 'infrastruktur',
                'slug' => 'sumur-wakaf-desa-kekeringan',
                'is_verified' => true,
            ],
            [
                'title' => 'Bantuan Modal Usaha Janda Lansia',
                'description' => 'Memberikan modal usaha kecil (warung kelontong/jajanan) untuk 20 janda lansia agar bisa mandiri secara ekonomi di usia senja mereka.',
                'target_amount' => 40000000,
                'collected_amount' => 12000000,
                'deadline' => now()->addDays(20),
                'status' => 'active',
                'fundraiser_id' => $fundraiser1->id,
                'category' => 'sosial',
                'slug' => 'modal-usaha-janda-lansia',
                'is_verified' => true,
            ],
            [
                'title' => 'Ambulans Gratis untuk Dhuafa',
                'description' => 'Pengadaan 1 unit armada ambulans gratis yang siap siaga 24 jam melayani pengantaran pasien dhuafa ke rumah sakit tanpa dipungut biaya sepeserpun.',
                'target_amount' => 250000000,
                'collected_amount' => 200000000,
                'deadline' => now()->addDays(10),
                'status' => 'active',
                'fundraiser_id' => $fundraiser1->id,
                'category' => 'kesehatan',
                'slug' => 'ambulans-gratis-dhuafa',
                'is_verified' => true,
            ]
        ];

        foreach ($campaigns as $campData) {
            Campaign::create($campData);
        }

        $allCampaigns = Campaign::all();

        // 6. Transactions (Donations)
        // Make existing fundraisers also donate purely for stats simulation
        $dummyUsers = array_merge($donaturs, [$fundraiser1, $fundraiser2, $admin]);

        foreach ($dummyUsers as $user) {
            // Each user makes random donations
            $donationCount = rand(2, 5);

            for ($k = 0; $k < $donationCount; $k++) {
                $camp = $allCampaigns->random();
                // Random status: mostly success (80%), some pending (20%)
                $status = (rand(1, 10) > 2) ? 'success' : 'pending';
                $amount = rand(10, 500) * 1000; // 10k to 500k

                // Don't donate to own campaign if fundraiser (conceptually fine, but let's keep it simple)
                if ($user->role === 'fundraiser' && $camp->fundraiser_id === $user->id)
                    continue;

                Transaction::create([
                    'transaction_code' => 'TRX-' . strtoupper(Str::random(10)),
                    'user_id' => $user->id,
                    'campaign_id' => $camp->id,
                    'amount' => $amount,
                    'status' => $status,
                    'payment_method' => 'qris',
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);

                if ($status === 'success') {
                    $camp->increment('collected_amount', $amount);

                    // Update fundraiser wallet
                    // Note: This matches the Controller logic where donation increases fundraiser wallet
                    $fundraiser = User::find($camp->fundraiser_id);
                    if ($fundraiser) {
                        $fundraiser->increment('wallet_balance', $amount);
                    }
                }
            }
        }

        // 7. Reports
        Report::create([
            'user_id' => $donaturs[0]->id,
            'title' => 'Jembatan Putus di Desa Sukamaju',
            'description' => 'Jembatan penghubung antar desa putus total akibat banjir semalam. Warga terisolasi.',
            'location' => 'Desa Sukamaju, Kec. Cilawu',
            'status' => 'pending',
            'severity' => 'berat',
            'category' => 'infrastruktur',
            'created_at' => now()->subDays(2),
        ]);

        Report::create([
            'user_id' => $donaturs[1]->id,
            'title' => 'Kekeringan Parah di Gunung Kidul',
            'description' => 'Sudah 3 bulan tidak hujan, warga beli air tangki mahal.',
            'location' => 'Gunung Kidul, DIY',
            'status' => 'verified',
            'severity' => 'sedang',
            'category' => 'bencana_alam',
            'created_at' => now()->subDays(5),
        ]);

        Report::create([
            'user_id' => $donaturs[2]->id,
            'title' => 'Lumpur Lapindo Meluap Lagi',
            'description' => 'Tanggul penahan lumpur retak, warga sekitar mulai waspada.',
            'location' => 'Sidoarjo, Jawa Timur',
            'status' => 'rejected',
            'severity' => 'ringan',
            'category' => 'bencana_alam',
            'created_at' => now()->subDays(10),
        ]);
    }
}
