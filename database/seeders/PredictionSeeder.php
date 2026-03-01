<?php

namespace Database\Seeders;

use App\Models\Prediction;
use App\Models\SkinType;
use Illuminate\Database\Seeder;

class PredictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skinTypes = SkinType::all();

        if ($skinTypes->isEmpty()) {
            return;
        }

        Prediction::truncate();

        for ($index = 1; $index <= 40; $index++) {
            $skinType = $skinTypes->random();

            Prediction::create([
                'skin_type_id' => $skinType->id,
                'image_path' => 'skins/sample-' . $index . '.jpg',
                'confidence' => mt_rand(7000, 9900) / 10000,
                'predicted_at' => now()->subHours(mt_rand(1, 168)),
            ]);
        }
    }
}
