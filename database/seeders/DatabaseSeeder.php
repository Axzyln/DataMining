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
        // ── Admin ─────────────────────────────────────────────────────────────
        User::create([
            'name'        => 'System Admin',
            'email'       => 'admin@bakersgoods.com',
            'password'    => Hash::make('password'),
            'role'        => 'admin',
            'is_verified' => true,
        ]);

        // ── Vendors & Products ─────────────────────────────────────────────────
        $vendors = [
            [
                'user'    => ['name' => 'Cebu Baking Supplies', 'email' => 'vendor1@bakersgoods.com'],
                'profile' => [
                    'store_name'     => 'Cebu Baking Supplies Co.',
                    'address'        => 'Colon St, Cebu City',
                    'contact_number' => '0917-123-4567',
                    'description'    => 'Wholesale baking ingredients since 1995.',
                ],
                'products' => [
                    // [name, category, price, stock, unit, description]
                    ['All-Purpose Flour',    'Flour',     65.00,  200, 'kg',  'Versatile flour for breads, cakes, and pastries.'],
                    ['Bread Flour',          'Flour',     72.00,  150, 'kg',  'High-gluten flour ideal for yeast breads and rolls.'],
                    ['Cake Flour',           'Flour',     85.00,   80, 'kg',  'Low-protein flour for tender, fine-crumb cakes.'],
                    ['Whole Wheat Flour',    'Flour',     78.00,   60, 'kg',  'Stone-ground whole wheat for hearty baked goods.'],
                    ['Cornstarch',           'Flour',     55.00,   90, 'kg',  'For thickening and lighter cake texture.'],
                    ['White Sugar',          'Sugar',     75.00,  180, 'kg',  'Refined granulated sugar, general purpose.'],
                    ['Brown Sugar',          'Sugar',     90.00,  120, 'kg',  'Moist dark sugar with molasses flavor.'],
                    ['Powdered Sugar',       'Sugar',     95.00,   70, 'kg',  'Confectioner\'s sugar for frostings and dustings.'],
                    ['Muscovado Sugar',      'Sugar',    110.00,   40, 'kg',  'Unrefined cane sugar with rich molasses taste.'],
                    ['Active Dry Yeast',     'Leavening', 250.00,  50, 'kg',  'Classic yeast for breads and ensaymada.'],
                    ['Instant Dry Yeast',    'Leavening', 280.00,  40, 'kg',  'Fast-acting yeast, no proofing required.'],
                    ['Baking Powder',        'Leavening',  80.00, 100, 'kg',  'Double-acting baking powder for cakes and muffins.'],
                    ['Baking Soda',          'Leavening',  45.00,  80, 'kg',  'Sodium bicarbonate for quick breads and cookies.'],
                    ['Iodized Salt',         'Salt',       25.00, 120, 'kg',  'Fine iodized salt for baking.'],
                    ['Unsalted Butter',      'Dairy',     320.00,  60, 'kg',  'Premium unsalted butter for controlled salt content.'],
                    ['Salted Butter',        'Dairy',     300.00,  50, 'kg',  'Everyday salted butter for breads and pastries.'],
                    ['Fresh Eggs',           'Dairy',       8.00, 800, 'pcs', 'Large fresh eggs, graded A.'],
                    ['Fresh Whole Milk',     'Dairy',      95.00,  80,  'L',  'Fresh pasteurized whole milk.'],
                    ['Evaporated Milk',      'Dairy',      55.00, 100, 'can', '370ml can, for richer milk flavor.'],
                    ['Skim Milk Powder',     'Dairy',     180.00,  60, 'kg',  'Non-fat dry milk for extended shelf life baking.'],
                ],
            ],
            [
                'user'    => ['name' => 'Mango Bakery Mart', 'email' => 'vendor2@bakersgoods.com'],
                'profile' => [
                    'store_name'     => 'Mango Bakery Mart',
                    'address'        => 'Mango Ave, Cebu City',
                    'contact_number' => '0922-987-6543',
                    'description'    => 'Specialty ingredients and chocolate products.',
                ],
                'products' => [
                    ['Cocoa Powder',         'Chocolate',  380.00,  35, 'kg',  'Unsweetened Dutch-process cocoa powder.'],
                    ['Dark Chocolate Chips',  'Chocolate',  480.00,  25, 'kg',  '60% cacao dark chips for cookies and cakes.'],
                    ['White Chocolate Chips', 'Chocolate',  520.00,  20, 'kg',  'Sweet white chocolate morsels.'],
                    ['Milk Chocolate Block',  'Chocolate',  460.00,  15, 'kg',  'Creamy milk chocolate for ganache and coating.'],
                    ['Cocoa Butter',          'Chocolate',  650.00,  10, 'kg',  'Pure cocoa butter for tempering and confections.'],
                    ['Vanilla Extract',       'Flavoring',  350.00,  30,  'L',  'Pure vanilla extract, 100mL bottles.'],
                    ['Pandan Extract',        'Flavoring',  180.00,  25,  'L',  'Natural pandan leaf extract for local pastries.'],
                    ['Ube Flavoring',         'Flavoring',  160.00,  20,  'L',  'Purple yam flavoring and coloring concentrate.'],
                    ['Almond Extract',        'Flavoring',  420.00,  15,  'L',  'Pure almond extract for marzipan and pastries.'],
                    ['Lemon Extract',         'Flavoring',  300.00,  20,  'L',  'Bright lemon flavor for citrus bakes.'],
                    ['Cinnamon Powder',       'Spice',     450.00,  20, 'kg',  'Ground Ceylon cinnamon for rolls and fillings.'],
                    ['Nutmeg Powder',         'Spice',     600.00,  10, 'kg',  'Freshly ground nutmeg for spiced breads.'],
                    ['Ginger Powder',         'Spice',     380.00,  15, 'kg',  'Dried ground ginger for gingersnaps and cake.'],
                    ['Cardamom Powder',       'Spice',     750.00,   8, 'kg',  'Fragrant cardamom for Nordic-style pastries.'],
                    ['Cheese Block (Cheddar)', 'Dairy',    280.00,  30, 'kg',  'Sharp cheddar for cheese bread and toppings.'],
                    ['Cream Cheese',          'Dairy',     360.00,  25, 'kg',  'Full-fat cream cheese for cheesecakes and frosting.'],
                    ['All-Purpose Cream',     'Dairy',      65.00,  80, 'can', '250mL can for frostings and filling.'],
                    ['Condensed Milk',        'Dairy',      60.00,  90, 'can', '300mL sweetened condensed milk.'],
                ],
            ],
            [
                'user'    => ['name' => 'Golden Grain Trading', 'email' => 'vendor3@bakersgoods.com'],
                'profile' => [
                    'store_name'     => 'Golden Grain Trading',
                    'address'        => 'Mandaue City, Cebu',
                    'contact_number' => '0932-456-7890',
                    'description'    => 'Bulk fats, oils, nuts and dried fruits for commercial bakers.',
                ],
                'products' => [
                    ['Vegetable Oil',        'Fat & Oil',  85.00,  100,  'L',  'Refined vegetable oil for frying and baking.'],
                    ['Coconut Oil',          'Fat & Oil', 120.00,   60,  'L',  'Refined coconut oil, neutral flavor.'],
                    ['Shortening',           'Fat & Oil',  95.00,   80, 'kg',  'Hydrogenated shortening for flaky pastry.'],
                    ['Margarine',            'Fat & Oil',  75.00,   90, 'kg',  'Baking margarine for breads and cookies.'],
                    ['Cashews (Whole)',       'Nuts',      480.00,   30, 'kg',  'Premium whole cashews for toppings.'],
                    ['Almonds (Blanched)',    'Nuts',      550.00,   25, 'kg',  'Skinless blanched almonds.'],
                    ['Walnuts (Halves)',      'Nuts',      620.00,   20, 'kg',  'California walnut halves for brownies.'],
                    ['Peanuts (Roasted)',     'Nuts',      120.00,   50, 'kg',  'Roasted salted peanuts for pastries.'],
                    ['Sesame Seeds',         'Nuts',      190.00,   40, 'kg',  'White sesame seeds for bread toppings.'],
                    ['Raisins',              'Dried Fruit', 220.00, 45, 'kg',  'Sun-dried sultana raisins.'],
                    ['Dried Mango Strips',   'Dried Fruit', 350.00, 25, 'kg',  'Philippine dried mango, sweet and chewy.'],
                    ['Macapuno Strings',     'Dried Fruit', 180.00, 30, 'kg',  'Coconut sport (macapuno) in syrup.'],
                    ['Ube Halaya',           'Specialty',  140.00, 50, 'kg',  'Cooked purple yam jam for fillings.'],
                    ['Langka (Jackfruit)',   'Dried Fruit', 160.00, 20, 'kg',  'Preserved young jackfruit for local breads.'],
                    ['Rice Flour',           'Flour',       68.00,  70, 'kg',  'Fine rice flour for gluten-free and kakanin.'],
                    ['Tapioca Starch',       'Flour',       90.00,  40, 'kg',  'Cassava starch for chewy textures.'],
                    ['Honey (Raw)',          'Sugar',      280.00,  35,  'kg', 'Wildflower honey from local apiaries.'],
                    ['Molasses',             'Sugar',      110.00,  30,  'L',  'Blackstrap molasses for dark breads.'],
                ],
            ],
            [
                'user'    => ['name' => 'Pastry Pro Depot', 'email' => 'vendor4@bakersgoods.com'],
                'profile' => [
                    'store_name'     => 'Pastry Pro Depot',
                    'address'        => 'IT Park, Lahug, Cebu City',
                    'contact_number' => '0945-321-0987',
                    'description'    => 'Professional-grade specialty ingredients and decoration supplies.',
                ],
                'products' => [
                    ['Cream of Tartar',      'Specialty',  320.00,  20, 'kg',  'Stabilizer for meringue and whipped cream.'],
                    ['Gelatin Powder',       'Specialty',  180.00,  30, 'kg',  'Unflavored gelatin for mousses and glazes.'],
                    ['Agar-Agar Powder',     'Specialty',  150.00,  25, 'kg',  'Plant-based gelling agent for Filipino desserts.'],
                    ['Food Coloring Set',    'Specialty',  250.00,  40, 'set', 'Gel food colors, 12 assorted colors per set.'],
                    ['Edible Gold Dust',     'Specialty', 1200.00,  10, 'g',   'Luster dust for decorating premium pastries.'],
                    ['Fondant (White)',      'Specialty',  220.00,  50, 'kg',  'Ready-to-roll fondant for cake decorating.'],
                    ['Gum Paste',            'Specialty',  190.00,  30, 'kg',  'Sugar paste for making edible flowers.'],
                    ['Isomalt',              'Specialty',  380.00,  15, 'kg',  'Sugar substitute for glasswork and decorations.'],
                    ['Puff Pastry Sheets',   'Specialty',  130.00,  60, 'pack','Ready-made puff pastry, 500g per pack.'],
                    ['Filo Pastry Sheets',   'Specialty',  120.00,  50, 'pack','Thin phyllo dough sheets for baklava.'],
                    ['Heavy Whipping Cream', 'Dairy',      140.00,  50,  'L',  '35% fat whipping cream for chantilly and ganache.'],
                    ['Buttermilk',           'Dairy',       90.00,  30,  'L',  'Cultured buttermilk for red velvet and scones.'],
                    ['Rolled Oats',          'Flour',       88.00,  60, 'kg',  'Old-fashioned rolled oats for cookies and granola.'],
                    ['Almond Flour',         'Flour',      420.00,  25, 'kg',  'Blanched almond meal for macarons and tarts.'],
                    ['Desiccated Coconut',   'Specialty',  120.00,  50, 'kg',  'Finely shredded dried coconut.'],
                    ['Meringue Powder',      'Specialty',  280.00,  20, 'kg',  'For royal icing and stabilized meringue.'],
                ],
            ],
        ];

        foreach ($vendors as $v) {
            $user = User::create([
                'name'        => $v['user']['name'],
                'email'       => $v['user']['email'],
                'password'    => Hash::make('password'),
                'role'        => 'vendor',
                'is_verified' => true,
            ]);

            $profile = VendorProfile::create(array_merge($v['profile'], [
                'user_id'     => $user->id,
                'is_verified' => true,
            ]));

            foreach ($v['products'] as $p) {
                Product::create([
                    'vendor_profile_id' => $profile->id,
                    'name'              => $p[0],
                    'category'          => $p[1],
                    'price'             => $p[2],
                    'stock_quantity'    => $p[3],
                    'unit'              => $p[4],
                    'description'       => $p[5],
                    'is_available'      => true,
                ]);
            }
        }

        // ── Baker ──────────────────────────────────────────────────────────────
        $baker = User::create([
            'name'        => 'Sample Bakery',
            'email'       => 'baker@bakersgoods.com',
            'password'    => Hash::make('password'),
            'role'        => 'baker',
            'is_verified' => true,
        ]);

        $inv = [
            ['Flour',   25,   'kg',  5],
            ['Sugar',   10,   'kg',  3],
            ['Yeast',    1.5, 'kg',  0.5],
            ['Salt',     4,   'kg',  1],
            ['Butter',   6,   'kg',  2],
            ['Eggs',    80,   'pcs', 30],
            ['Milk',     8,   'L',   2],
            ['Cheese',   2,   'kg',  0.5],
        ];
        foreach ($inv as $i) {
            BakerInventory::create([
                'user_id'          => $baker->id,
                'ingredient_name'  => $i[0],
                'quantity'         => $i[1],
                'unit'             => $i[2],
                'reorder_level'    => $i[3],
            ]);
        }

        $products = ['Pandesal' => 5, 'Ensaymada' => 25, 'Spanish Bread' => 10, 'Cheese Bread' => 15];
        foreach (range(13, 0) as $d) {
            foreach ($products as $name => $price) {
                $qty = rand(20, 80);
                Sale::create([
                    'user_id'        => $baker->id,
                    'product_name'   => $name,
                    'quantity_sold'  => $qty,
                    'unit_price'     => $price,
                    'total'          => $qty * $price,
                    'sale_date'      => now()->subDays($d),
                ]);
            }
        }
    }
}
