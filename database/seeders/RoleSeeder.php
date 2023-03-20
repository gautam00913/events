<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'evenementiel'
        ]);
        Role::create([
            'name' => 'admin'
        ]);
        $role = Role::create([
            'name' => 'user'
        ]);
    }
}
