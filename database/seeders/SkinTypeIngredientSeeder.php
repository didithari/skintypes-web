<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SkinType;
use App\Models\SkinTypeIngredient;

class SkinTypeIngredientSeeder extends Seeder
{
    public function run(): void
    {
        $skinTypes = SkinType::all();
        if ($skinTypes->isEmpty()) return;

        SkinTypeIngredient::truncate();

        $ingredients = [
            'normal' => [
                'good' => [
                    ['name' => 'Hyaluronic Acid', 'description' => 'Menjaga kelembapan alami kulit tanpa membuatnya berminyak.'],
                    ['name' => 'Niacinamide', 'description' => 'Mencerahkan dan menjaga elastisitas kulit.'],
                    ['name' => 'Vitamin C', 'description' => 'Antioksidan untuk melindungi kulit dari radikal bebas.']
                ],
                'bad' => [
                    ['name' => 'Alkohol Denat', 'description' => 'Bisa membuat kulit kering jika digunakan terlalu sering.'],
                    ['name' => 'Parfum Sintetis', 'description' => 'Bisa menyebabkan iritasi ringan.']
                ]
            ],
            'dry' => [
                'good' => [
                    ['name' => 'Ceramides', 'description' => 'Memperbaiki skin barrier dan mengunci kelembapan.'],
                    ['name' => 'Glycerin', 'description' => 'Menarik air ke dalam kulit agar tetap terhidrasi.'],
                    ['name' => 'Squalane', 'description' => 'Minyak ringan yang melembapkan tanpa menyumbat pori.']
                ],
                'bad' => [
                    ['name' => 'Salicylic Acid (Kadar Tinggi)', 'description' => 'Dapat membuat kulit semakin kering dan mengelupas.'],
                    ['name' => 'Fragrance', 'description' => 'Seringkali menyebabkan iritasi pada kulit kering.']
                ]
            ],
            'oily' => [
                'good' => [
                    ['name' => 'Salicylic Acid (BHA)', 'description' => 'Membersihkan pori-pori secara mendalam dan mengurangi minyak.'],
                    ['name' => 'Niacinamide', 'description' => 'Mengontrol produksi sebum dan menyamarkan pori.'],
                    ['name' => 'Clay / Kaolin', 'description' => 'Menyerap minyak berlebih di wajah.']
                ],
                'bad' => [
                    ['name' => 'Mineral Oil', 'description' => 'Dapat menyumbat pori-pori dan memicu jerawat.'],
                    ['name' => 'Coconut Oil', 'description' => 'Sangat comedogenic untuk kulit berminyak.']
                ]
            ]
        ];

        foreach ($skinTypes as $skinType) {
            $typeKey = strtolower($skinType->name);
            
            if (isset($ingredients[$typeKey])) {
                foreach ($ingredients[$typeKey]['good'] as $ing) {
                    SkinTypeIngredient::create([
                        'skin_type_id' => $skinType->id,
                        'type' => 'good',
                        'name' => $ing['name'],
                        'description' => $ing['description']
                    ]);
                }
                foreach ($ingredients[$typeKey]['bad'] as $ing) {
                    SkinTypeIngredient::create([
                        'skin_type_id' => $skinType->id,
                        'type' => 'bad',
                        'name' => $ing['name'],
                        'description' => $ing['description']
                    ]);
                }
            }
        }
    }
}
