<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // permission dashboard
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'dashboard.statistics', 'guard_name' => 'api']);
        Permission::create(['name' => 'dashboard.chart', 'guard_name' => 'api']);

        // permission inbound
        Permission::create(['name' => 'inbound.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'inbound.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'inbound.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'inbound.delete', 'guard_name' => 'api']);

        // permission storage
        Permission::create(['name' => 'storage.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'storage.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'storage.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'storage.delete', 'guard_name' => 'api']);

        // permission outbound
        Permission::create(['name' => 'outbound.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'outbound.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'outbound.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'outbound.delete', 'guard_name' => 'api']);

        // permission users
        Permission::create(['name' => 'users.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'users.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'users.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'users.delete', 'guard_name' => 'api']);

        // permission roles
        Permission::create(['name' => 'roles.index', 'guard_name' => 'api']);
        Permission::create(['name' => 'roles.create', 'guard_name' => 'api']);
        Permission::create(['name' => 'roles.edit', 'guard_name' => 'api']);
        Permission::create(['name' => 'roles.delete', 'guard_name' => 'api']);

        // permission permissions
        Permission::create(['name' => 'permissions.index', 'guard_name' => 'api']);

    }
}
