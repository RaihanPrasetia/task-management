<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'user']);
    }
}
