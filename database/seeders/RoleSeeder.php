<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'administrator', 'display_name' => 'Administrator'],
            ['name' => 'petani', 'display_name' => 'Petani'],
            ['name' => 'pedagang', 'display_name' => 'Pedagang'],
            ['name' => 'eksportir', 'display_name' => 'Eksportir'],
            ['name' => 'government', 'display_name' => 'Government'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
