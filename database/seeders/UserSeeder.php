<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin Default
        User::create([
            'name' => 'Admin Logistik',
            'email' => 'admin@adlogistics.com',
            'phone' => '081200000001',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        //Driver Default
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'driver@adlogistics.com',
            'phone' => '081200000002',
            'password' => Hash::make('driver123'),
            'role' => 'driver',
        ]);
    }
}
