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
                'status_kehadiran' => 'Hybrid',
            ],
            [
                'name' => 'PT Bank Mandiri (Persero) Tbk',
                'status_kehadiran' => 'Hybrid',
            ],
        ];

        Instansi::insert($instansis);
    }
}
