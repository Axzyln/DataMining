<?php

namespace Database\Seeders;

use App\Models\BakerInventory;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeds realistic inventory + sales for the demo baker account.
 * Ingredient names match the RecipeSeeder exactly so feasibility matching works.
 * Re-running is safe — clears existing data for that user first.
 *
 * Intentionally OUT OF STOCK: Unsalted Butter, Cream Cheese
 * → All butter-dependent recipes (Pandesal, Ensaymada, Monay, Mamon, Polvoron,
 *   Spanish Bread, Cheese Bread, Ube Pandesal, Brownies, all Cookies) = INFEASIBLE
 *
 * FEASIBLE with this inventory:
 *   Pan de Coco, Macapuno Bread, Hopia, Chocolate Cake, Puto, Kutsinta, Putok (Star Bread)
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $baker = User::where('role', 'baker')->orderBy('id')->first();

        if (!$baker) {
            $this->command->warn('No baker user found. Skipping DemoDataSeeder.');
            return;
        }

        $this->command->info("Seeding demo data for baker: {$baker->name} (id={$baker->id})");

        BakerInventory::where('user_id', $baker->id)->delete();
        Sale::where('user_id', $baker->id)->delete();

        // ── INVENTORY ────────────────────────────────────────────────────────────
        // Names match RecipeSeeder exactly. Unsalted Butter & Cream Cheese = 0.
        $inventory = [
            // Flours
            ['ingredient_name' => 'All-Purpose Flour',      'quantity' => 10,  'unit' => 'kg',    'reorder_level' => 3],
            ['ingredient_name' => 'Bread Flour',             'quantity' => 8,   'unit' => 'kg',    'reorder_level' => 2],
            ['ingredient_name' => 'Cake Flour',              'quantity' => 4,   'unit' => 'kg',    'reorder_level' => 1],
            ['ingredient_name' => 'Rice Flour',              'quantity' => 3,   'unit' => 'kg',    'reorder_level' => 1],

            // Sweeteners
            ['ingredient_name' => 'White Sugar',             'quantity' => 8,   'unit' => 'kg',    'reorder_level' => 2],
            ['ingredient_name' => 'Brown Sugar',             'quantity' => 3,   'unit' => 'kg',    'reorder_level' => 1],
            ['ingredient_name' => 'Powdered Sugar',          'quantity' => 2,   'unit' => 'kg',    'reorder_level' => 0.5],

            // Leavening
            ['ingredient_name' => 'Instant Dry Yeast',       'quantity' => 0.5, 'unit' => 'kg',    'reorder_level' => 0.1],
            ['ingredient_name' => 'Active Dry Yeast',        'quantity' => 0.3, 'unit' => 'kg',    'reorder_level' => 0.1],
            ['ingredient_name' => 'Baking Powder',           'quantity' => 0.3, 'unit' => 'kg',    'reorder_level' => 0.1],
            ['ingredient_name' => 'Baking Soda',             'quantity' => 0.2, 'unit' => 'kg',    'reorder_level' => 0.05],

            // Fats — Unsalted Butter deliberately OUT OF STOCK
            ['ingredient_name' => 'Unsalted Butter',         'quantity' => 0,   'unit' => 'kg',    'reorder_level' => 1],
            ['ingredient_name' => 'Margarine',               'quantity' => 2,   'unit' => 'kg',    'reorder_level' => 0.5],
            ['ingredient_name' => 'Vegetable Oil',           'quantity' => 3,   'unit' => 'liters','reorder_level' => 1],
            ['ingredient_name' => 'Shortening',              'quantity' => 1.5, 'unit' => 'kg',    'reorder_level' => 0.5],
            ['ingredient_name' => 'Pork Lard',               'quantity' => 0.5, 'unit' => 'kg',    'reorder_level' => 0.2],

            // Dairy
            ['ingredient_name' => 'Fresh Whole Milk',        'quantity' => 4,   'unit' => 'liters','reorder_level' => 1],
            ['ingredient_name' => 'Evaporated Milk',         'quantity' => 6,   'unit' => 'cans',  'reorder_level' => 2],
            ['ingredient_name' => 'Condensed Milk',          'quantity' => 4,   'unit' => 'cans',  'reorder_level' => 2],
            ['ingredient_name' => 'Skim Milk Powder',        'quantity' => 0.5, 'unit' => 'kg',    'reorder_level' => 0.1],
            ['ingredient_name' => 'Cheese Block (Cheddar)',  'quantity' => 0.8, 'unit' => 'kg',    'reorder_level' => 0.3],
            ['ingredient_name' => 'Cream Cheese',            'quantity' => 0,   'unit' => 'kg',    'reorder_level' => 0.2],

            // Eggs
            ['ingredient_name' => 'Fresh Eggs',              'quantity' => 60,  'unit' => 'pcs',   'reorder_level' => 12],

            // Seasoning
            ['ingredient_name' => 'Iodized Salt',            'quantity' => 1,   'unit' => 'kg',    'reorder_level' => 0.3],

            // Flavorings
            ['ingredient_name' => 'Vanilla Extract',         'quantity' => 0.2, 'unit' => 'liters','reorder_level' => 0.05],
            ['ingredient_name' => 'Ube Flavoring',           'quantity' => 0.1, 'unit' => 'liters','reorder_level' => 0.05],
            ['ingredient_name' => 'Pandan Extract',          'quantity' => 0.1, 'unit' => 'liters','reorder_level' => 0.05],

            // Fillings & Toppings
            ['ingredient_name' => 'Desiccated Coconut',      'quantity' => 1,   'unit' => 'kg',    'reorder_level' => 0.3],
            ['ingredient_name' => 'Macapuno Strings',        'quantity' => 0.5, 'unit' => 'kg',    'reorder_level' => 0.2],
            ['ingredient_name' => 'Ube Halaya',              'quantity' => 0.8, 'unit' => 'kg',    'reorder_level' => 0.2],
            ['ingredient_name' => 'Mung Bean Paste',         'quantity' => 0.5, 'unit' => 'kg',    'reorder_level' => 0.2],
            ['ingredient_name' => 'Cocoa Powder',            'quantity' => 0.4, 'unit' => 'kg',    'reorder_level' => 0.1],
            ['ingredient_name' => 'Dark Chocolate Chips',    'quantity' => 0.3, 'unit' => 'kg',    'reorder_level' => 0.1],
            ['ingredient_name' => 'Raisins',                 'quantity' => 0.3, 'unit' => 'kg',    'reorder_level' => 0.1],
            ['ingredient_name' => 'Rolled Oats',             'quantity' => 0.5, 'unit' => 'kg',    'reorder_level' => 0.1],
            ['ingredient_name' => 'Ginger Powder',           'quantity' => 0.1, 'unit' => 'kg',    'reorder_level' => 0.05],
            ['ingredient_name' => 'Cinnamon Powder',         'quantity' => 0.1, 'unit' => 'kg',    'reorder_level' => 0.05],
            ['ingredient_name' => 'Molasses',                'quantity' => 0.3, 'unit' => 'liters','reorder_level' => 0.05],
            ['ingredient_name' => 'Cream of Tartar',         'quantity' => 0.1, 'unit' => 'kg',    'reorder_level' => 0.02],
            ['ingredient_name' => 'Tapioca Starch',          'quantity' => 0.3, 'unit' => 'kg',    'reorder_level' => 0.1],
            ['ingredient_name' => 'Achuete Powder',          'quantity' => 0.1, 'unit' => 'kg',    'reorder_level' => 0.05],
            ['ingredient_name' => 'Lye Water',               'quantity' => 0.2, 'unit' => 'liters','reorder_level' => 0.05],
        ];

        foreach ($inventory as $item) {
            BakerInventory::create(array_merge($item, ['user_id' => $baker->id]));
        }

        $this->command->info('  ✓ Inventory seeded (' . count($inventory) . ' items; Unsalted Butter & Cream Cheese = 0)');

        // ── RECENT SALES — last 7 days ────────────────────────────────────────────
        // Product names match recipe names exactly. Includes butter-dependent products
        // (Ensaymada, Pandesal, etc.) which will still appear in sales history but
        // must NOT be recommended because their required ingredients are out of stock.
        $recentSales = [
            // Yeast bread — high volume, some feasible, some not
            ['product_name' => 'Pan de Coco',            'qty' => 80,  'price' => 4.00,  'daysAgo' => 1],
            ['product_name' => 'Pan de Coco',            'qty' => 65,  'price' => 4.00,  'daysAgo' => 3],
            ['product_name' => 'Macapuno Bread',         'qty' => 55,  'price' => 5.00,  'daysAgo' => 2],
            ['product_name' => 'Macapuno Bread',         'qty' => 48,  'price' => 5.00,  'daysAgo' => 5],
            ['product_name' => 'Putok (Star Bread)',     'qty' => 70,  'price' => 3.50,  'daysAgo' => 1],
            ['product_name' => 'Putok (Star Bread)',     'qty' => 60,  'price' => 3.50,  'daysAgo' => 4],

            // Butter-dependent — sold this week but must be excluded from recs
            ['product_name' => 'Pandesal',               'qty' => 240, 'price' => 2.50,  'daysAgo' => 1],
            ['product_name' => 'Pandesal',               'qty' => 210, 'price' => 2.50,  'daysAgo' => 2],
            ['product_name' => 'Pandesal',               'qty' => 195, 'price' => 2.50,  'daysAgo' => 3],
            ['product_name' => 'Ensaymada',              'qty' => 55,  'price' => 15.00, 'daysAgo' => 2],
            ['product_name' => 'Ensaymada',              'qty' => 40,  'price' => 15.00, 'daysAgo' => 5],
            ['product_name' => 'Spanish Bread',          'qty' => 90,  'price' => 5.00,  'daysAgo' => 2],
            ['product_name' => 'Cheese Bread',           'qty' => 75,  'price' => 8.00,  'daysAgo' => 3],

            // Cakes & pastries
            ['product_name' => 'Chocolate Cake',         'qty' => 12,  'price' => 350.00,'daysAgo' => 3],
            ['product_name' => 'Hopia',                  'qty' => 60,  'price' => 10.00, 'daysAgo' => 2],
            ['product_name' => 'Hopia',                  'qty' => 45,  'price' => 10.00, 'daysAgo' => 5],

            // Kakanin
            ['product_name' => 'Puto',                   'qty' => 80,  'price' => 4.00,  'daysAgo' => 1],
            ['product_name' => 'Puto',                   'qty' => 60,  'price' => 4.00,  'daysAgo' => 4],
            ['product_name' => 'Kutsinta',               'qty' => 60,  'price' => 4.00,  'daysAgo' => 3],
            ['product_name' => 'Kutsinta',               'qty' => 50,  'price' => 4.00,  'daysAgo' => 6],
        ];

        foreach ($recentSales as $s) {
            Sale::create([
                'user_id'       => $baker->id,
                'product_name'  => $s['product_name'],
                'quantity_sold' => $s['qty'],
                'unit_price'    => $s['price'],
                'total'         => $s['qty'] * $s['price'],
                'sale_date'     => now()->subDays($s['daysAgo'])->toDateString(),
            ]);
        }

        $this->command->info('  ✓ Recent sales seeded (' . count($recentSales) . ' records, last 7 days)');

        // ── OLD SALES — 8–30 days ago (excluded by 7-day filter) ─────────────────
        $oldSales = [
            ['product_name' => 'Pandesal',               'qty' => 500, 'price' => 2.50,  'daysAgo' => 10],
            ['product_name' => 'Ensaymada',              'qty' => 120, 'price' => 15.00, 'daysAgo' => 14],
            ['product_name' => 'Chocolate Cake',         'qty' => 30,  'price' => 350.00,'daysAgo' => 20],
            ['product_name' => 'Cheese Bread',           'qty' => 200, 'price' => 8.00,  'daysAgo' => 12],
            ['product_name' => 'Brownies',               'qty' => 60,  'price' => 25.00, 'daysAgo' => 18],
            ['product_name' => 'Pan de Coco',            'qty' => 180, 'price' => 4.00,  'daysAgo' => 15],
            ['product_name' => 'Hopia',                  'qty' => 100, 'price' => 10.00, 'daysAgo' => 22],
            ['product_name' => 'Puto',                   'qty' => 150, 'price' => 4.00,  'daysAgo' => 16],
        ];

        foreach ($oldSales as $s) {
            Sale::create([
                'user_id'       => $baker->id,
                'product_name'  => $s['product_name'],
                'quantity_sold' => $s['qty'],
                'unit_price'    => $s['price'],
                'total'         => $s['qty'] * $s['price'],
                'sale_date'     => now()->subDays($s['daysAgo'])->toDateString(),
            ]);
        }

        $this->command->info('  ✓ Old sales seeded (' . count($oldSales) . ' records, 8–30 days ago)');
        $this->command->info('');
        $this->command->info('Expected FEASIBLE: Pan de Coco, Macapuno Bread, Hopia, Chocolate Cake, Puto, Kutsinta, Putok (Star Bread)');
        $this->command->info('Expected INFEASIBLE: Everything needing Unsalted Butter (Pandesal, Ensaymada, Spanish Bread, Cheese Bread, Ube Pandesal, Monay, Mamon, Polvoron, Brownies, all Cookies) + Ube Ensaymada (Cream Cheese)');
    }
}
