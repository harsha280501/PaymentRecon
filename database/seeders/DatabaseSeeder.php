<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        $this->call([
            RoleSeeder::class
        ]);

        // creating the Users -> admin
        User::create(
            [
                'roleUID' => "1",
                'name' => "Admin",
                'email' => "administrator@abfrl.com",
                "password" => bcrypt('root@123'),
                'createdBy' => 'superadmin',
            ],
        );
        // creating the Users -> Area Manager
        User::create(
            [
                'roleUID' => "2",
                'name' => "Manager",
                'email' => "area.manager@abfrl.com",
                "password" => bcrypt('root@123'),
                'createdBy' => 'superadmin',
            ],
        );
        // creating the Users -> Commertial head
        User::create(
            [
                'roleUID' => "3",
                'name' => "Head",
                'email' => "commertial.head@abfrl.com",
                "password" => bcrypt('root@123'),
                'createdBy' => 'superadmin',
            ],
        );
        // creating the Users -> Commertial team
        User::create(
            [
                'roleUID' => "4",
                'name' => "Team",
                'email' => "commertial.team@abfrl.com",
                "password" => bcrypt('root@123'),
                'createdBy' => 'superadmin',
            ],
        );
        // creating the Users -> store User
        User::create(
            [
                'roleUID' => "5",
                'name' => "User",
                'email' => "store.user@abfrl.com",
                "password" => bcrypt('root@123'),
                'createdBy' => 'superadmin',
            ],
        );
    }
}
