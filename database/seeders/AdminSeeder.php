<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);

        for ($i = 1; $i <= 10; $i++) {
            \App\Models\User::factory()->create([
                'name' => "Admin $i",
                'email' => "admin$i@yopmail.com",
                'password' => bcrypt('password'),
                'profile_picture' => "https://placehold.co/600x400/000000/FFFFFF/png?text=A$i",
            ])->assignRole($admin);
        }
    }
}
