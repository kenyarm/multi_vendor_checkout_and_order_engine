<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorAndProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'Tech Store',
                'email' => 'techstore@yopmail.com',
                'phone' => '123-456-7890',
                'address' => '123 Tech Lane, Silicon Valley, CA',
                'website' => 'https://techstore.example.com',
                'logo' => '',
                'description' => 'Your one-stop shop for all tech gadgets.',
            ],
            [
                'name' => 'Gadget Hub',
                'email' => 'gadgethub@yopmail.com',
                'phone' => '987-654-3210',
                'address' => '456 Gadget Street, Tech City, TX',
                'website' => 'https://gadgethub.example.com',
                'logo' => '',
                'description' => 'Latest gadgets and accessories at unbeatable prices.',
            ],
            [
                'name' => 'Smart Home Solutions',
                'email' => 'smarthome@yopmail.com',
                'phone' => '555-123-4567',
                'address' => '789 Smart Ave, Home City, FL',
                'website' => 'https://smarthome.example.com',
                'logo' => '',
                'description' => 'Innovative smart home products for modern living.',
            ],
        ];

        foreach ($vendors as $vendorData) {
            $vendor = \App\Models\Vendor::create($vendorData);
            for ($i = 0; $i < 5; $i++) {
                $vendor->products()->create([
                    'name' => "Sample Product {$i} for {$vendor->name}",
                    'vendor_id' => $vendor->id,
                    'price' => rand(10, 100),
                    'stock' => rand(1, 5),
                    'description' => 'This is a sample product.',
                ]);
            }
        }
    }
}
