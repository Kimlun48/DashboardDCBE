<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\admin\user;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
       // Buat izin dengan guard yang benar
       Permission::create(['name' => 'view ils', 'guard_name' => 'api']);

       // Buat peran dengan guard yang benar
       $role = Role::create(['name' => 'admin', 'guard_name' => 'api']);

       // Tambahkan izin ke peran
       $role->givePermissionTo('view ils');

       // Tambahkan peran ke pengguna
       $user = User::find(1); // Misalnya, pengguna dengan ID 1
       if ($user) {
           $user->assignRole('admin');
       }
   
    }
}
