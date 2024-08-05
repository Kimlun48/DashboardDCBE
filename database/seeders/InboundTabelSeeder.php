<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\admin\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InboundTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regularUser = User::create([
            'name'      => 'inbound',
            'email'     => 'inbound@gmail.com',
            'password'  => bcrypt('password')
        ]);
        
        // Dapatkan semua izin
        $permissions = Permission::all();
        
        // Dapatkan atau buat peran user
        $userRole = Role::firstOrCreate(['name' => 'inbound']);
        
        // Tetapkan semua izin ke peran user
        $userRole->syncPermissions($permissions);
        
        // Tetapkan peran user ke pengguna user
        $regularUser->assignRole($userRole);
    }
}
