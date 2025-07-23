<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Role::firstOrCreate(['name' => 'customer']);

        for ($i = 1; $i <= 10; $i++) {
            \App\Models\User::factory()->create([
                'name' => "Customer $i",
                'email' => "customer$i@yopmail.com",
                'password' => bcrypt('password'),
                'profile_picture' => "https://placehold.co/600x400/000000/FFFFFF/png?text=C$i",
            ])->assignRole($customer);
        }
    }
}
