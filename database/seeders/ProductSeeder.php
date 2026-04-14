<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\SkinType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['skin' => 'oily', 'name' => 'Oil Control Cleanser', 'brand' => 'PureSkin', 'price' => 89000, 'description' => 'Deep pore cleansing with BHA for acne-prone oily skin'],
            ['skin' => 'oily', 'name' => 'Niacinamide Serum 10%', 'brand' => 'DermaLab', 'price' => 125000, 'description' => 'Controls sebum and minimizes pores'],
            ['skin' => 'dry', 'name' => 'Hydrating Facial Wash', 'brand' => 'Moisture+', 'price' => 78000, 'description' => 'Gentle cleanser with hyaluronic acid'],
            ['skin' => 'dry', 'name' => 'Ceramide Barrier Cream', 'brand' => 'SkinShield', 'price' => 145000, 'description' => 'Intensive moisturizing cream for dry skin'],
            ['skin' => 'normal', 'name' => 'Daily Gentle Cleanser', 'brand' => 'EverySkin', 'price' => 67000, 'description' => 'pH-balanced formula for daily use'],
            ['skin' => 'normal', 'name' => 'SPF 50 Daily Sunscreen', 'brand' => 'SunGuard', 'price' => 92000, 'description' => 'Broad spectrum UV protection'],
        ];

        foreach ($products as $item) {
            $skinType = SkinType::where('name', $item['skin'])->first();

            if (!$skinType) {
                continue;
            }

            Product::updateOrCreate(
                ['name' => $item['name'], 'skin_type_id' => $skinType->id],
                [
                    'brand' => $item['brand'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                ]
            );
        }
    }
}
