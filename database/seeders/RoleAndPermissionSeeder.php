<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create the roles
        $bannedRole = Role::create(['name' => 'Banned']);
        $userRole = Role::create(['name' => 'User']);
        $adminRole = Role::create(['name' => 'Admin']);
        $ownerRole = Role::create(['name' => 'Owner']);

        //create the permissions
        Permission::create(['name' => 'access-admin-dashboard']);
        Permission::create(['name' => 'access-owner-dashboard']);
        Permission::create(['name' => 'generate-alpha-keys']);
        Permission::create(['name' => 'ban-user']);
        Permission::create(['name' => 'change-user-role']);
        Permission::create(['name' => 'cant-play']);

        //assign permissions to roles
        $bannedRole->givePermissionTo([
            'cant-play'
        ]);

        $adminRole->givePermissionTo([
            'access-admin-dashboard',
            'generate-alpha-keys',
            'ban-user',
            'change-user-role'
        ]);

        $ownerRole->givePermissionTo([
            'access-admin-dashboard',
            'access-owner-dashboard',
            'generate-alpha-keys',
            'ban-user',
            'change-user-role'
        ]);
    }
}
