<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Profile;
use App\Models\Experience;
use Illuminate\Database\Seeder;
use App\Models\WhyTradersChooseUs;

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
    }
}
