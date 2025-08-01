<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari role administrator
        $adminRole = Role::where('name', 'administrator')->first();

        // Buat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@sistempala.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'role_id' => $adminRole->id,
        ]);
    }
}
