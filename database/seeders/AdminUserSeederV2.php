<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\admin\user;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeederV2 extends Seeder
{
    public function run()
    {
        // Buat atau ambil role admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Buat user baru dengan role admin
        $adminUser = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // Sesuaikan dengan password yang kamu inginkan
        ]);

        // Assign role admin ke user yang baru dibuat
        $adminUser->assignRole($adminRole);
    }
}
