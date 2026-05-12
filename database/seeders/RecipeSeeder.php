<?php
namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = [

            // ── Yeast Breads ──────────────────────────────────────────────────────

            [
                'name'           => 'Pandesal',
                'category'       => 'Yeast Bread',
                'description'    => 'Filipino breakfast bread rolls dusted with breadcrumbs. Soft inside with a lightly crisp crust.',
                'yield_quantity' => 24,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Bread Flour',       500,  'g',   true],
                    ['Instant Dry Yeast',   7,  'g',   true],
                    ['White Sugar',        60,  'g',   true],
                    ['Iodized Salt',       10,  'g',   true],
                    ['Skim Milk Powder',   30,  'g',   false],
                    ['Fresh Eggs',          2,  'pcs', true],
                    ['Unsalted Butter',    60,  'g',   true],
                ],
            ],

            [
                'name'           => 'Ensaymada',
                'category'       => 'Yeast Bread',
                'description'    => 'Soft and buttery Filipino coiled bread topped with grated cheese and sugar. A panaderia staple.',
                'yield_quantity' => 12,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Bread Flour',          500, 'g',   true],
                    ['Active Dry Yeast',       7, 'g',   true],
                    ['White Sugar',          120, 'g',   true],
                    ['Iodized Salt',           8, 'g',   true],
                    ['Fresh Eggs',             4, 'pcs', true],
                    ['Unsalted Butter',      160, 'g',   true],
                    ['Evaporated Milk',      120, 'ml',  true],
                    ['Cheese Block (Cheddar)', 80, 'g',  true],
                    ['Powdered Sugar',        50, 'g',   true],
                ],
            ],

            [
                'name'           => 'Spanish Bread',
                'category'       => 'Yeast Bread',
                'description'    => 'Rolled Filipino bread with a sweet buttered breadcrumb filling. Unique to Philippine bakeries.',
                'yield_quantity' => 20,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Bread Flour',      500, 'g',   true],
                    ['Instant Dry Yeast',  7, 'g',   true],
                    ['White Sugar',       80, 'g',   true],
                    ['Iodized Salt',      10, 'g',   true],
                    ['Fresh Eggs',         2, 'pcs', true],
                    ['Unsalted Butter',  100, 'g',   true],
                    ['Fresh Whole Milk', 120, 'ml',  true],
                    ['Brown Sugar',       80, 'g',   true],
                ],
            ],

            [
                'name'           => 'Cheese Bread',
                'category'       => 'Yeast Bread',
                'description'    => 'Soft bread rolls stuffed with melted cheddar cheese. A Filipino bakery bestseller.',
                'yield_quantity' => 16,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Bread Flour',           500, 'g',   true],
                    ['Instant Dry Yeast',       7, 'g',   true],
                    ['White Sugar',            60, 'g',   true],
                    ['Iodized Salt',           10, 'g',   true],
                    ['Fresh Eggs',              2, 'pcs', true],
                    ['Unsalted Butter',        80, 'g',   true],
                    ['Fresh Whole Milk',      150, 'ml',  true],
                    ['Cheese Block (Cheddar)', 200, 'g',  true],
                ],
            ],

            [
                'name'           => 'Ube Pandesal',
                'category'       => 'Yeast Bread',
                'description'    => 'Purple yam pandesal filled with melted cheese. Popular modern twist on the classic pandesal.',
                'yield_quantity' => 16,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Bread Flour',      500, 'g',   true],
                    ['Instant Dry Yeast',  7, 'g',   true],
                    ['White Sugar',       80, 'g',   true],
                    ['Iodized Salt',       8, 'g',   true],
                    ['Fresh Eggs',         2, 'pcs', true],
                    ['Unsalted Butter',   80, 'g',   true],
                    ['Fresh Whole Milk', 120, 'ml',  true],
                    ['Ube Halaya',       200, 'g',   true],
                    ['Ube Flavoring',     10, 'ml',  false],
                    ['Cream Cheese',     100, 'g',   false],
                ],
            ],

            [
                'name'           => 'Pan de Coco',
                'category'       => 'Yeast Bread',
                'description'    => 'Sweet bread rolls filled with sweetened desiccated coconut. A classic panaderia favorite.',
                'yield_quantity' => 20,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Bread Flour',        500, 'g',   true],
                    ['Instant Dry Yeast',    7, 'g',   true],
                    ['White Sugar',         80, 'g',   true],
                    ['Iodized Salt',         8, 'g',   true],
                    ['Fresh Eggs',           2, 'pcs', true],
                    ['Margarine',           60, 'g',   true],
                    ['Fresh Whole Milk',   120, 'ml',  true],
                    ['Desiccated Coconut', 200, 'g',   true],
                    ['Brown Sugar',        100, 'g',   true],
                ],
            ],

            [
                'name'           => 'Monay',
                'category'       => 'Yeast Bread',
                'description'    => 'Dense, slightly sweet Filipino bread with a signature center slit. Best eaten with coffee.',
                'yield_quantity' => 20,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['All-Purpose Flour', 500, 'g',   true],
                    ['Active Dry Yeast',    7, 'g',   true],
                    ['White Sugar',        60, 'g',   true],
                    ['Iodized Salt',       10, 'g',   true],
                    ['Skim Milk Powder',   30, 'g',   false],
                    ['Fresh Eggs',          2, 'pcs', true],
                    ['Unsalted Butter',    60, 'g',   true],
                ],
            ],

            [
                'name'           => 'Putok (Star Bread)',
                'category'       => 'Yeast Bread',
                'description'    => 'Hard-crusted Filipino bread rolls that "explode" on top, creating a star shape. Slightly sweet.',
                'yield_quantity' => 20,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Bread Flour',       500, 'g',   true],
                    ['Instant Dry Yeast',   7, 'g',   true],
                    ['White Sugar',       100, 'g',   true],
                    ['Iodized Salt',       10, 'g',   true],
                    ['Skim Milk Powder',   60, 'g',   true],
                    ['Fresh Eggs',          2, 'pcs', true],
                    ['Unsalted Butter',    30, 'g',   false],
                ],
            ],

            [
                'name'           => 'Ube Ensaymada',
                'category'       => 'Yeast Bread',
                'description'    => 'Purple yam ensaymada topped with cream cheese frosting. A modern Filipino bakery bestseller.',
                'yield_quantity' => 12,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Bread Flour',      500, 'g',   true],
                    ['Active Dry Yeast',   7, 'g',   true],
                    ['White Sugar',      100, 'g',   true],
                    ['Iodized Salt',       8, 'g',   true],
                    ['Fresh Eggs',         4, 'pcs', true],
                    ['Unsalted Butter',  150, 'g',   true],
                    ['Evaporated Milk',  120, 'ml',  true],
                    ['Ube Halaya',       150, 'g',   true],
                    ['Ube Flavoring',     10, 'ml',  false],
                    ['Cream Cheese',     100, 'g',   true],
                    ['Powdered Sugar',    50, 'g',   true],
                ],
            ],

            [
                'name'           => 'Macapuno Bread',
                'category'       => 'Yeast Bread',
                'description'    => 'Soft bread rolls filled with sweet macapuno (coconut sport) strings.',
                'yield_quantity' => 16,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Bread Flour',       500, 'g',   true],
                    ['Instant Dry Yeast',   7, 'g',   true],
                    ['White Sugar',        80, 'g',   true],
                    ['Iodized Salt',        8, 'g',   true],
                    ['Fresh Eggs',          2, 'pcs', true],
                    ['Margarine',          60, 'g',   true],
                    ['Fresh Whole Milk',  120, 'ml',  true],
                    ['Macapuno Strings',  200, 'g',   true],
                    ['White Sugar',        60, 'g',   true],
                ],
            ],

            // ── Cakes & Pastries ──────────────────────────────────────────────────

            [
                'name'           => 'Mamon',
                'category'       => 'Cake & Pastry',
                'description'    => 'Ultra-soft Filipino chiffon sponge cake topped with butter and grated cheese. A classic merienda.',
                'yield_quantity' => 12,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Cake Flour',            200, 'g',   true],
                    ['White Sugar',           150, 'g',   true],
                    ['Fresh Eggs',              6, 'pcs', true],
                    ['Unsalted Butter',        80, 'g',   true],
                    ['Skim Milk Powder',        30, 'g',  false],
                    ['Baking Powder',            5, 'g',  true],
                    ['Cream of Tartar',          2, 'g',  true],
                    ['Vanilla Extract',          5, 'ml', false],
                    ['Cheese Block (Cheddar)',   50, 'g',  true],
                ],
            ],

            [
                'name'           => 'Chocolate Cake',
                'category'       => 'Cake & Pastry',
                'description'    => 'Rich Filipino-style chocolate cake, moist with cocoa and frosted with chocolate ganache.',
                'yield_quantity' => 16,
                'yield_unit'     => 'slices',
                'ingredients'    => [
                    ['All-Purpose Flour', 250, 'g',   true],
                    ['Cocoa Powder',       60, 'g',   true],
                    ['White Sugar',       300, 'g',   true],
                    ['Baking Powder',      10, 'g',   true],
                    ['Baking Soda',         5, 'g',   true],
                    ['Fresh Eggs',          3, 'pcs', true],
                    ['Vegetable Oil',      120, 'ml', true],
                    ['Fresh Whole Milk',   240, 'ml', true],
                    ['Vanilla Extract',      5, 'ml', false],
                    ['Dark Chocolate Chips', 100, 'g', false],
                ],
            ],

            [
                'name'           => 'Brownies',
                'category'       => 'Cake & Pastry',
                'description'    => 'Fudgy Filipino-style brownies loaded with dark chocolate chips and walnuts.',
                'yield_quantity' => 16,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['All-Purpose Flour',   150, 'g',   true],
                    ['Cocoa Powder',         80, 'g',   true],
                    ['White Sugar',         250, 'g',   true],
                    ['Unsalted Butter',     180, 'g',   true],
                    ['Fresh Eggs',            3, 'pcs', true],
                    ['Dark Chocolate Chips', 100, 'g',  true],
                    ['Vanilla Extract',       5, 'ml',  false],
                    ['Walnuts (Halves)',      80, 'g',   false],
                ],
            ],

            [
                'name'           => 'Polvoron',
                'category'       => 'Cake & Pastry',
                'description'    => 'Filipino crumbly shortbread made from toasted flour, powdered milk, sugar, and butter.',
                'yield_quantity' => 30,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['All-Purpose Flour', 200, 'g', true],
                    ['Skim Milk Powder',  100, 'g', true],
                    ['Powdered Sugar',    100, 'g', true],
                    ['Unsalted Butter',   120, 'g', true],
                    ['Vanilla Extract',     5, 'ml', false],
                ],
            ],

            [
                'name'           => 'Hopia',
                'category'       => 'Cake & Pastry',
                'description'    => 'Filipino-Chinese flaky pastry filled with sweetened mung bean or ube paste.',
                'yield_quantity' => 20,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['All-Purpose Flour', 300, 'g',  true],
                    ['Shortening',        120, 'g',  true],
                    ['White Sugar',        50, 'g',  true],
                    ['Vegetable Oil',      60, 'ml', true],
                    ['Ube Halaya',        300, 'g',  true],
                ],
            ],

            // ── Cookies ───────────────────────────────────────────────────────────

            [
                'name'           => 'Oatmeal Raisin Cookies',
                'category'       => 'Cookie',
                'description'    => 'Chewy oatmeal cookies loaded with raisins. A popular Filipino bakery cookie.',
                'yield_quantity' => 24,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Rolled Oats',      200, 'g',   true],
                    ['All-Purpose Flour', 150, 'g',  true],
                    ['Unsalted Butter',  150, 'g',   true],
                    ['Brown Sugar',      100, 'g',   true],
                    ['White Sugar',       50, 'g',   true],
                    ['Fresh Eggs',         2, 'pcs', true],
                    ['Baking Soda',        5, 'g',   true],
                    ['Vanilla Extract',    5, 'ml',  false],
                    ['Raisins',          100, 'g',   true],
                    ['Iodized Salt',       3, 'g',   false],
                ],
            ],

            [
                'name'           => 'Gingersnap Cookies',
                'category'       => 'Cookie',
                'description'    => 'Crispy spiced cookies with ginger, cinnamon, and molasses. Filipino panaderia staple.',
                'yield_quantity' => 30,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['All-Purpose Flour', 300, 'g',   true],
                    ['Ginger Powder',      10, 'g',   true],
                    ['Cinnamon Powder',     5, 'g',   true],
                    ['Baking Soda',         5, 'g',   true],
                    ['Iodized Salt',        3, 'g',   false],
                    ['Unsalted Butter',   150, 'g',   true],
                    ['Brown Sugar',       150, 'g',   true],
                    ['Molasses',           60, 'ml',  true],
                    ['Fresh Eggs',          1, 'pcs', true],
                ],
            ],

            [
                'name'           => 'Chocolate Chip Cookies',
                'category'       => 'Cookie',
                'description'    => 'Classic chewy cookies loaded with chocolate chips. Always a crowd pleaser.',
                'yield_quantity' => 24,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['All-Purpose Flour',    250, 'g',   true],
                    ['Baking Soda',            5, 'g',   true],
                    ['Iodized Salt',            3, 'g',   false],
                    ['Unsalted Butter',       170, 'g',   true],
                    ['White Sugar',            75, 'g',   true],
                    ['Brown Sugar',           150, 'g',   true],
                    ['Fresh Eggs',              2, 'pcs', true],
                    ['Vanilla Extract',         5, 'ml',  false],
                    ['Dark Chocolate Chips',  200, 'g',   true],
                ],
            ],

            // ── Kakanin (Filipino Rice Cakes) ─────────────────────────────────────

            [
                'name'           => 'Puto',
                'category'       => 'Kakanin',
                'description'    => 'Fluffy Filipino steamed rice cake, often served with salted egg or cheese on top.',
                'yield_quantity' => 24,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['Rice Flour',       300, 'g',   true],
                    ['White Sugar',      150, 'g',   true],
                    ['Baking Powder',     10, 'g',   true],
                    ['Fresh Whole Milk', 240, 'ml',  true],
                    ['Fresh Eggs',         2, 'pcs', true],
                    ['Unsalted Butter',   30, 'g',   false],
                    ['Cheese Block (Cheddar)', 50, 'g', false],
                ],
            ],

            [
                'name'           => 'Kutsinta',
                'category'       => 'Kakanin',
                'description'    => 'Brown steamed rice cake with a chewy jelly-like texture. Served with grated coconut.',
                'yield_quantity' => 24,
                'yield_unit'     => 'pieces',
                'ingredients'    => [
                    ['All-Purpose Flour', 100, 'g',  true],
                    ['Tapioca Starch',     50, 'g',  true],
                    ['Brown Sugar',       200, 'g',  true],
                    ['Baking Soda',         5, 'g',  true],
                    ['Desiccated Coconut', 100, 'g', false],
                ],
            ],

        ];

        foreach ($recipes as $data) {
            $recipe = Recipe::create([
                'name'           => $data['name'],
                'category'       => $data['category'],
                'description'    => $data['description'],
                'yield_quantity' => $data['yield_quantity'],
                'yield_unit'     => $data['yield_unit'],
            ]);

            foreach ($data['ingredients'] as [$name, $qty, $unit, $critical]) {
                RecipeIngredient::create([
                    'recipe_id'       => $recipe->id,
                    'ingredient_name' => $name,
                    'quantity'        => $qty,
                    'unit'            => $unit,
                    'is_critical'     => $critical,
                ]);
            }
        }
    }
}
