<?php

namespace Database\Seeders;

use App\Models\SkinType;
use Illuminate\Database\Seeder;

class SkinTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['api_id' => 0, 'name' => 'dry', 'description' => 'Kulit terasa kering dan kurang lembap.'],
            ['api_id' => 1, 'name' => 'normal', 'description' => 'Kulit seimbang, tidak terlalu kering atau berminyak.'],
            ['api_id' => 2, 'name' => 'oily', 'description' => 'Kulit cenderung berminyak dan mudah berjerawat.'],
        ];

        $allowedApiIds = collect($items)->pluck('api_id')->all();

        SkinType::whereNotIn('api_id', $allowedApiIds)->delete();

        foreach ($items as $item) {
            SkinType::updateOrCreate(['api_id' => $item['api_id']], $item);
        }
    }
}
