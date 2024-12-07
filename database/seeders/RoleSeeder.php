<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::create([
            'roleName' => 'Administrator',
            'createdBy' => 'superadmin'
        ]);

        Roles::create([
            'roleName' => 'Area Manager',
            'createdBy' => 'superadmin'
        ]);

        Roles::create([
            'roleName' => 'Commertial Head',
            'createdBy' => 'superadmin'
        ]);

        Roles::create([
            'roleName' => 'Commertial Team',
            'createdBy' => 'superadmin'
        ]);

        Roles::create([
            'roleName' => 'Store User',
            'createdBy' => 'superadmin'
        ]);
    }
}
