<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        // User::factory(10)->create();
        $pass = Hash::make('12345678');

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => $pass
        ]);
        $admin->assignRole('super_admin');

        $manager = User::create([
            'name' => 'Manager',
            'username' => 'manager',
            'email' => 'manager@example.com',
            'password' => $pass
        ]);
        $manager->assignRole('manager');

        $user2 = User::create([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user2@example.com',
            'password' => $pass
        ]);
        $user2->assignRole('user');
    }
}
