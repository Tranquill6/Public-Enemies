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
        $adminRole = Role::findByName('Admin');
        $ownerRole = Role::findByName('Owner');

        //create the permissions
        Permission::create(['name' => 'access-admin-cities']);

        //assign permissions to roles

        $adminRole->givePermissionTo([
            'access-admin-cities'
        ]);

        $ownerRole->givePermissionTo([
            'access-admin-cities'
        ]);
    }
}
