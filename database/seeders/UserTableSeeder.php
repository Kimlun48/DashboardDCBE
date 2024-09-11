<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\admin\user;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $user = user::create([
        //     'name'      => 'admin',
        //     'email'     => 'admin@gmail.com',
        //     'password'  => bcrypt('password')
        // ]);

        // $permissions = Permission::all();

        // //get role admin
        // $role = Role::find(1);

        // //assign permission to role
        // $role->syncPermissions($permissions);

        // //assign role to user
        
        // $user->assignRole($role);

         // Buat pengguna admin
         $adminUser = User::create([
            'name'      => 'admin',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('admin123#')
        ]);

        // Buat pengguna user
        $regularUser = User::create([
            'name'      => 'inbound',
            'email'     => 'inbound@gmail.com',
            'password'  => bcrypt('inbound123#')
        ]);

        // Dapatkan semua izin
        $permissions = Permission::all();

        // Dapatkan atau buat peran admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Dapatkan atau buat peran user
        $userRole = Role::firstOrCreate(['name' => 'inbound']);

        // Berikan semua izin ke peran admin
        $adminRole->syncPermissions($permissions);

        // Tetapkan peran admin ke pengguna admin
        $adminUser->assignRole($adminRole);

        // Tetapkan peran user ke pengguna user
        $regularUser->assignRole($userRole);
    }
}
