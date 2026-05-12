<?php
namespace Database\Seeders;

use App\Models\BakerInventory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\VendorProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@bakersgoods.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        // Vendor 1
        $vendor1 = User::create([
            'name' => 'Cebu Baking Supplies',
            'email' => 'vendor1@bakersgoods.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'is_verified' => true,
        ]);
        $profile1 = VendorProfile::create([
            'user_id' => $vendor1->id,
            'store_name' => 'Cebu Baking Supplies Co.',
            'address' => 'Colon St, Cebu City',
            'contact_number' => '0917-123-4567',
            'description' => 'Wholesale baking ingredients since 1995.',
            'is_verified' => true,
        ]);

        $items1 = [
            ['All-Purpose Flour', 'Flour', 65.00, 100, 'kg'],
            ['White Sugar', 'Sugar', 75.00, 80, 'kg'],
            ['Brown Sugar', 'Sugar', 90.00, 50, 'kg'],
            ['Active Dry Yeast', 'Yeast', 250.00, 30, 'kg'],
            ['Iodized Salt', 'Salt', 25.00, 60, 'kg'],
            ['Unsalted Butter', 'Dairy', 320.00, 40, 'kg'],
            ['Fresh Eggs', 'Dairy', 8.00, 500, 'pcs'],
        ];
        foreach ($items1 as $i) Product::create([
            'vendor_profile_id' => $profile1->id,
            'name' => $i[0], 'category' => $i[1],
            'price' => $i[2], 'stock_quantity' => $i[3], 'unit' => $i[4],
        ]);

        // Vendor 2
        $vendor2 = User::create([
            'name' => 'Mango Bakery Mart',
            'email' => 'vendor2@bakersgoods.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'is_verified' => true,
        ]);
        $profile2 = VendorProfile::create([
            'user_id' => $vendor2->id,
            'store_name' => 'Mango Bakery Mart',
            'address' => 'Mango Ave, Cebu City',
            'contact_number' => '0922-987-6543',
            'is_verified' => true,
        ]);
        $items2 = [
            ['Cocoa Powder', 'Specialty', 380.00, 20, 'kg'],
            ['Cheese Block', 'Dairy', 280.00, 25, 'kg'],
            ['Fresh Milk', 'Dairy', 95.00, 60, 'L'],
            ['Cinnamon Powder', 'Spice', 450.00, 10, 'kg'],
            ['Bread Flour', 'Flour', 72.00, 90, 'kg'],
        ];
        foreach ($items2 as $i) Product::create([
            'vendor_profile_id' => $profile2->id,
            'name' => $i[0], 'category' => $i[1],
            'price' => $i[2], 'stock_quantity' => $i[3], 'unit' => $i[4],
        ]);

        // Baker
        $baker = User::create([
            'name' => 'Sample Bakery',
            'email' => 'baker@bakersgoods.com',
            'password' => Hash::make('password'),
            'role' => 'baker',
            'is_verified' => true,
        ]);

        // Baker's inventory
        $inv = [
            ['Flour', 25, 'kg', 5],
            ['Sugar', 10, 'kg', 3],
            ['Yeast', 1.5, 'kg', 0.5],
            ['Salt', 4, 'kg', 1],
            ['Butter', 6, 'kg', 2],
            ['Eggs', 80, 'pcs', 30],
            ['Milk', 8, 'L', 2],
            ['Cheese', 2, 'kg', 0.5],
        ];
        foreach ($inv as $i) BakerInventory::create([
            'user_id' => $baker->id,
            'ingredient_name' => $i[0], 'quantity' => $i[1],
            'unit' => $i[2], 'reorder_level' => $i[3],
        ]);

        // 14 days of sample sales
        $products = ['Pandesal' => 5, 'Ensaymada' => 25, 'Spanish Bread' => 10, 'Cheese Bread' => 15];
        foreach (range(13, 0) as $d) {
            foreach ($products as $name => $price) {
                $qty = rand(20, 80);
                Sale::create([
                    'user_id' => $baker->id,
                    'product_name' => $name,
                    'quantity_sold' => $qty,
                    'unit_price' => $price,
                    'total' => $qty * $price,
                    'sale_date' => now()->subDays($d),
                ]);
            }
        }
    }
}