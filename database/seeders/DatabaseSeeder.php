<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed weather_conditions
        DB::table('weather_conditions')->insert([
            ['weather_type' => 'Hot', 'description' => 'Cuaca panas dengan suhu tinggi'],
            ['weather_type' => 'Cold', 'description' => 'Cuaca dingin dengan suhu rendah'],
            ['weather_type' => 'Humid', 'description' => 'Cuaca dengan kelembapan tinggi'],
            ['weather_type' => 'Dry', 'description' => 'Cuaca dengan kelembapan rendah'],
        ]);

        // 2. Seed skin_types
        DB::table('skin_types')->insert([
            ['skin_type' => 'Oily', 'description' => 'Kulit berminyak'],
            ['skin_type' => 'Dry', 'description' => 'Kulit kering'],
            ['skin_type' => 'Combination', 'description' => 'Kulit kombinasi'],
            ['skin_type' => 'Sensitive', 'description' => 'Kulit sensitif'],
        ]);

        // 3. Seed skin_conditions
        DB::table('skin_conditions')->insert([
            ['condition_type' => 'Acne', 'description' => 'Kulit berjerawat'],
            ['condition_type' => 'Dryness', 'description' => 'Kulit kering dan bersisik'],
            ['condition_type' => 'Dullness', 'description' => 'Kulit kusam'],
            ['condition_type' => 'Enlarged Pores', 'description' => 'Pori-pori besar'],
            ['condition_type' => 'Sensitivity', 'description' => 'Kulit sensitif'],
        ]);

        // 4. Seed products
        DB::table('products')->insert([
            ['product_name' => 'Hydrating Gel', 'product_type' => 'Moisturizer', 'key_ingredients' => 'Hyaluronic Acid, Glycerin', 'description' => 'Gel ringan yang memberikan hidrasi intens'],
            ['product_name' => 'Clay Mask', 'product_type' => 'Mask', 'key_ingredients' => 'Bentonite Clay', 'description' => 'Masker untuk mengontrol minyak'],
            ['product_name' => 'Sunscreen SPF 50', 'product_type' => 'Sunscreen', 'key_ingredients' => 'Zinc Oxide, Titanium Dioxide', 'description' => 'Melindungi kulit dari sinar UV'],
            ['product_name' => 'Vitamin C Serum', 'product_type' => 'Serum', 'key_ingredients' => 'Vitamin C, Hyaluronic Acid', 'description' => 'Serum untuk mencerahkan kulit'],
            ['product_name' => 'Exfoliating Scrub', 'product_type' => 'Exfoliator', 'key_ingredients' => 'Salicylic Acid, Jojoba Beads', 'description' => 'Scrub untuk mengangkat sel kulit mati'],
            ['product_name' => 'Moisturizing Cream', 'product_type' => 'Moisturizer', 'key_ingredients' => 'Ceramide, Squalane', 'description' => 'Krim pelembap yang cocok untuk kulit kering'],
            ['product_name' => 'Oil-Free Lotion', 'product_type' => 'Moisturizer', 'key_ingredients' => 'Niacinamide, Zinc', 'description' => 'Lotion ringan untuk kulit berminyak'],
        ]);

        // 5. Seed recommendations
        DB::table('recommendations')->insert([
            [
                'weather_condition_id' => 1,
                'skin_type_id' => 1,
                'skin_condition_id' => 1,
                'recommended_product_ids' => '1,2,3,4'
            ],
            [
                'weather_condition_id' => 2,
                'skin_type_id' => 2,
                'skin_condition_id' => 2,
                'recommended_product_ids' => '6,5,3'
            ],
            [
                'weather_condition_id' => 3,
                'skin_type_id' => 3,
                'skin_condition_id' => 4,
                'recommended_product_ids' => '2,4,1'
            ],
            [
                'weather_condition_id' => 4,
                'skin_type_id' => 4,
                'skin_condition_id' => 5,
                'recommended_product_ids' => '6,3,1'
            ],
        ]);
    }
}
