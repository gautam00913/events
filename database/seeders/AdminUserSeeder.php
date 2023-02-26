<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Gautier DJOSSOU',
            'email' => 'gaautierdjossou@gmail.com',
            'password' => Hash::make('admin@admin'),
            'role_id' => 2
        ]);
        User::create([
            'name' => 'E-events',
            'email' => 'e-events@alwaysdata.net',
            'password' => Hash::make('admin@admin'),
            'role_id' => 2
        ]);
    }
}
