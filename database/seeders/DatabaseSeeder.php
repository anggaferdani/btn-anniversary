<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Zoom;
use App\Models\Instansi;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@btn.com',
                'password' => bcrypt('adminbtn123*'),
                'role' => 1,
            ],
            [
                'name' => 'Receptionist',
                'email' => 'receptionist@btn.com',
                'password' => bcrypt('receptionistbtn123*'),
                'role' => 2,
            ],
            [
                'name' => 'Tenant',
                'email' => 'tenant@btn.com',
                'password' => bcrypt('tenantbtn123*'),
                'role' => 3,
            ],
        ];

        User::insert($users);

        $zooms = [
            [
                'link' => null,
            ],
        ];

        Zoom::insert($zooms);

        // $faker = Faker::create();

        // for ($i = 1; $i <= 100; $i++) {
        //     $qrcode = 'B' . str_pad($i, 3, '0', STR_PAD_LEFT);
        //     $token = bin2hex(random_bytes(6));

        //     Participant::create([
        //         'qrcode' => $qrcode,
        //         'token' => $token,
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->safeEmail,
        //         'phone_number' => $faker->phoneNumber,
        //         'verification' => 1,
        //         'attendance' => 2,
        //     ]);
        // }

        $instansis = [
            [
                'name' => 'PT Bank Mandiri (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Bank Negara Indonesia (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Bank Rakyat Indonesia (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Bank Syariah Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pertamina (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pertamina Patra Niaga',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Perusahaan Listrik Negara (Indonesia Power)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Perusahaan Listrik Negara (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Telekomunikasi Indonesia (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Telekomunikasi Selular',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'Perum BULOG',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Aviasi Pariwisata Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Bank Tabungan Negara (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 50,
            ],
            [
                'name' => 'PT Kharisma Pemasaran Bersama Nusantara',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Mineral Industri Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pelabuhan Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Perkebunan Nusantara III (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Perusahaan Gas Negara Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Perusahaan Pengelola Aset',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pupuk Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pupuk Indonesia Pangan',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Semen Indonesia (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Sinergi Gula Nusantara',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'Perum Percetakan Uang Republik Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'Perum Perhutani',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Adhi Karya (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Angkasa Pura Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT ASDP Indonesia Ferry (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Asuransi Jasa Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Asuransi Jiwa Taspen',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Asuransi Jiwasraya (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Bahana Pembinaan Usaha Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Bio Farma (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Biro Klasifikasi Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Danareksa (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Hutama Karya (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Jasa Marga (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Kereta Api Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Kimia Farma Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Krakatau Steel (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Len Industri (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT LEN Railway Systems',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pegadaian',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pelayaran Nasional Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pembangunan Perumahan (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pos Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Rajawali Nusantara Indonesia (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Rekayasa Industri',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Taspen (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Waskita Beton Precast Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Waskita Karya (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Waskita Toll Road',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Wijaya Karya (Persero) Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'Perum Lembaga Penyelenggara Pelayanan Navigasi Penerbangan Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'Perum Perumnas',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'Perusahaan Umum Damri',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Asabri (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Asuransi Asei Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Asuransi Kredit Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Brantas Abipraya (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Dahana',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Djakarta Lloyd (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Indofarma Tbk',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Jaminan Kredit Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Jasa Raharja',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Kawasan Berikat Nusantara',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Permodalan Nasional Madani',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Perusahaan Perdagangan Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pindad',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Reasuransi Indonesia Utama (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Sucofindo',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Surveyor Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'Perum Lembaga Kantor Berita Nasional Antara',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'Perum Percetakan Negara Republik Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Amarta Karya (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Berdikari',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Energy Management Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Indra Karya (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Jakarta Industrial Estate Pulogadung',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Kliring Berjangka Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Kliring Perdagangan Berjangka Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Nindya Karya',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pengembangan Armada Niaga Nasional (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Perikanan Indonesia',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Produksi Film Negara (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Sang Hyang Seri',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Virama Karya (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Yodya Karya (Persero)',
                'status_kehadiran' => 'hybrid',
                'max_participant' => 3,
            ],
            [
                'name' => 'PT Pupuk Kalimantan Timur',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Pupuk Sriwidjaja Palembang',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Semen Gresik',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Semen Padang',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT TIMAH Tbk',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Indonesia Asahan Aluminium',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT LPP Agro Nusantara',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Perkebunan Nusantara I',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Perkebunan Nusantara IV',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Petrokimia Gresik',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Pupuk Iskandar Muda',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Pupuk Kujang Cikampek',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Aneka Tambang Tbk',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Bukit Asam Tbk',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Semen Tonasa',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'Perum Jasa Tirta II',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Hotel Indonesia Natour',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Industri Kereta Api (Persero)',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT PAL Indonesia',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Pengembangan Pariwisata Indonesia',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Surabaya Industrial Estate Rungkut',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'Perum Jasa Tirta I',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Garam',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Industri Kapal Indonesia (Persero)',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Kawasan Industri Makassar',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Kawasan Industri Medan',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT Kawasan Industri Wijayakusuma',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
            [
                'name' => 'PT TWC Borobudur, Prambanan dan Ratu Boko',
                'status_kehadiran' => 'online',
                'max_participant' => 0,
            ],
        ];

        Instansi::insert($instansis);
    }
}
