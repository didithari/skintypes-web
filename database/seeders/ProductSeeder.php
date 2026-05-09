<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\SkinType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed face wash products with SAW criteria values.
     *
     * C1 (Kandungan Aktif)   : 1=Rendah, 2=Sedang, 3=Tinggi, 4=Sangat Tinggi  [Benefit]
     * C2 (Kandungan Iritatif): 1=Rendah, 2=Sedang, 3=Tinggi                    [Cost]
     * C3 (Harga)             : 1=<50rb, 2=50-100rb, 3=100-150rb, 4=>150rb      [Cost]
     * C4 (Tekstur)           : gel, foam, cream                                 [Benefit]
     */
    public function run(): void
    {
        $products = [
            // ── Kulit Berminyak (Oily) ──
            [
                'skin' => 'oily',
                'name' => 'Cetaphil Oily Skin Cleanser',
                'brand' => 'Cetaphil',
                'description' => 'Pembersih wajah tanpa sabun yang diformulasikan khusus untuk kulit berminyak, membersihkan tanpa menghilangkan kelembapan alami.',
                'price' => 125000,
                'c1_kandungan' => 3,
                'c2_iritatif' => 1,
                'c3_harga' => 3,
                'c4_tekstur' => 'gel',
                'link_produk' => 'https://www.tokopedia.com/search?q=cetaphil+oily+skin+cleanser',
            ],
            [
                'skin' => 'oily',
                'name' => 'Himalaya Purifying Neem Face Wash',
                'brand' => 'Himalaya',
                'description' => 'Mengandung Neem dan Turmeric yang membantu mengontrol minyak berlebih dan mencegah jerawat.',
                'price' => 35000,
                'c1_kandungan' => 3,
                'c2_iritatif' => 1,
                'c3_harga' => 1,
                'c4_tekstur' => 'gel',
                'link_produk' => 'https://www.tokopedia.com/search?q=himalaya+purifying+neem+face+wash',
            ],
            [
                'skin' => 'oily',
                'name' => 'Garnier Pure Active Matcha Deep Clean',
                'brand' => 'Garnier',
                'description' => 'Facial wash dengan kandungan Matcha dan Salicylic Acid untuk membersihkan pori dan mengontrol minyak.',
                'price' => 32000,
                'c1_kandungan' => 2,
                'c2_iritatif' => 2,
                'c3_harga' => 1,
                'c4_tekstur' => 'foam',
                'link_produk' => 'https://www.tokopedia.com/search?q=garnier+pure+active+matcha',
            ],
            [
                'skin' => 'oily',
                'name' => 'COSRX Low pH Good Morning Gel Cleanser',
                'brand' => 'COSRX',
                'description' => 'Gel cleanser dengan pH rendah dan BHA (Betaine Salicylate) untuk membersihkan kulit berminyak secara lembut.',
                'price' => 110000,
                'c1_kandungan' => 4,
                'c2_iritatif' => 1,
                'c3_harga' => 3,
                'c4_tekstur' => 'gel',
                'link_produk' => 'https://www.tokopedia.com/search?q=cosrx+low+ph+good+morning+gel+cleanser',
            ],
            [
                'skin' => 'oily',
                'name' => 'Pond\'s Pure Bright Facial Foam',
                'brand' => 'Pond\'s',
                'description' => 'Facial foam dengan Activated Carbon dan Niacinamide untuk mengangkat kotoran dan minyak berlebih.',
                'price' => 25000,
                'c1_kandungan' => 2,
                'c2_iritatif' => 3,
                'c3_harga' => 1,
                'c4_tekstur' => 'foam',
                'link_produk' => 'https://www.tokopedia.com/search?q=ponds+pure+bright+facial+foam',
            ],

            // ── Kulit Kering (Dry) ──
            [
                'skin' => 'dry',
                'name' => 'CeraVe Hydrating Facial Cleanser',
                'brand' => 'CeraVe',
                'description' => 'Pembersih wajah dengan 3 Essential Ceramides dan Hyaluronic Acid untuk membersihkan sekaligus melembapkan.',
                'price' => 195000,
                'c1_kandungan' => 4,
                'c2_iritatif' => 1,
                'c3_harga' => 4,
                'c4_tekstur' => 'cream',
                'link_produk' => 'https://www.tokopedia.com/search?q=cerave+hydrating+facial+cleanser',
            ],
            [
                'skin' => 'dry',
                'name' => 'Hada Labo Gokujyun Hydrating Face Wash',
                'brand' => 'Hada Labo',
                'description' => 'Mengandung Super Hyaluronic Acid untuk menjaga kelembapan kulit selama proses pembersihan.',
                'price' => 55000,
                'c1_kandungan' => 3,
                'c2_iritatif' => 1,
                'c3_harga' => 2,
                'c4_tekstur' => 'foam',
                'link_produk' => 'https://www.tokopedia.com/search?q=hada+labo+gokujyun+face+wash',
            ],
            [
                'skin' => 'dry',
                'name' => 'Cetaphil Gentle Skin Cleanser',
                'brand' => 'Cetaphil',
                'description' => 'Pembersih wajah lembut tanpa sabun, cocok untuk kulit kering dan sensitif. Formulasi non-comedogenic.',
                'price' => 130000,
                'c1_kandungan' => 3,
                'c2_iritatif' => 1,
                'c3_harga' => 3,
                'c4_tekstur' => 'cream',
                'link_produk' => 'https://www.tokopedia.com/search?q=cetaphil+gentle+skin+cleanser',
            ],
            [
                'skin' => 'dry',
                'name' => 'Simple Kind to Skin Moisturising Face Wash',
                'brand' => 'Simple',
                'description' => 'Face wash dengan Pro-Vitamin B5 dan Vitamin E, tanpa pewarna dan pewangi buatan.',
                'price' => 65000,
                'c1_kandungan' => 2,
                'c2_iritatif' => 1,
                'c3_harga' => 2,
                'c4_tekstur' => 'cream',
                'link_produk' => 'https://www.tokopedia.com/search?q=simple+moisturising+face+wash',
            ],
            [
                'skin' => 'dry',
                'name' => 'Nivea Milk Delights Face Wash Honey',
                'brand' => 'Nivea',
                'description' => 'Dengan kandungan susu dan madu untuk membersihkan dan melembapkan kulit kering.',
                'price' => 28000,
                'c1_kandungan' => 2,
                'c2_iritatif' => 2,
                'c3_harga' => 1,
                'c4_tekstur' => 'cream',
                'link_produk' => 'https://www.tokopedia.com/search?q=nivea+milk+delights+face+wash+honey',
            ],

            // ── Kulit Normal ──
            [
                'skin' => 'normal',
                'name' => 'Wardah Nature Daily Aloe Hydramild Facial Wash',
                'brand' => 'Wardah',
                'description' => 'Facial wash dengan Aloe Vera Extract dan Vitamin E untuk menjaga keseimbangan kulit normal.',
                'price' => 27000,
                'c1_kandungan' => 2,
                'c2_iritatif' => 1,
                'c3_harga' => 1,
                'c4_tekstur' => 'gel',
                'link_produk' => 'https://www.tokopedia.com/search?q=wardah+nature+daily+aloe+hydramild',
            ],
            [
                'skin' => 'normal',
                'name' => 'Innisfree Green Tea Foam Cleanser',
                'brand' => 'Innisfree',
                'description' => 'Pembersih wajah dengan ekstrak teh hijau Jeju yang kaya antioksidan untuk menjaga vitalitas kulit.',
                'price' => 135000,
                'c1_kandungan' => 3,
                'c2_iritatif' => 1,
                'c3_harga' => 3,
                'c4_tekstur' => 'foam',
                'link_produk' => 'https://www.tokopedia.com/search?q=innisfree+green+tea+foam+cleanser',
            ],
            [
                'skin' => 'normal',
                'name' => 'SENKA Perfect Whip',
                'brand' => 'Senka',
                'description' => 'Facial foam dengan Aqua-in-Pool technology dan White Cocoon Essence untuk kulit halus dan bersih.',
                'price' => 48000,
                'c1_kandungan' => 3,
                'c2_iritatif' => 2,
                'c3_harga' => 1,
                'c4_tekstur' => 'foam',
                'link_produk' => 'https://www.tokopedia.com/search?q=senka+perfect+whip',
            ],
            [
                'skin' => 'normal',
                'name' => 'Emina Bright Stuff Face Wash',
                'brand' => 'Emina',
                'description' => 'Pembersih wajah dengan Niacinamide dan Summer Plum untuk mencerahkan dan menjaga kelembapan kulit.',
                'price' => 18000,
                'c1_kandungan' => 2,
                'c2_iritatif' => 2,
                'c3_harga' => 1,
                'c4_tekstur' => 'foam',
                'link_produk' => 'https://www.tokopedia.com/search?q=emina+bright+stuff+face+wash',
            ],
            [
                'skin' => 'normal',
                'name' => 'Bioderma Sensibio Gel Moussant',
                'brand' => 'Bioderma',
                'description' => 'Gel pembersih lembut yang menghormati pH fisiologis kulit, ideal untuk kulit normal hingga sensitif.',
                'price' => 245000,
                'c1_kandungan' => 4,
                'c2_iritatif' => 1,
                'c3_harga' => 4,
                'c4_tekstur' => 'gel',
                'link_produk' => 'https://www.tokopedia.com/search?q=bioderma+sensibio+gel+moussant',
            ],
        ];

        foreach ($products as $item) {
            $skinType = SkinType::where('name', $item['skin'])->first();

            if (!$skinType) {
                continue;
            }

            Product::updateOrCreate(
                ['name' => $item['name'], 'skin_type_id' => $skinType->id],
                [
                    'brand'        => $item['brand'],
                    'description'  => $item['description'],
                    'price'        => $item['price'],
                    'c1_kandungan' => $item['c1_kandungan'],
                    'c2_iritatif'  => $item['c2_iritatif'],
                    'c3_harga'     => $item['c3_harga'],
                    'c4_tekstur'   => $item['c4_tekstur'],
                    'link_produk'  => $item['link_produk'],
                ]
            );
        }
    }
}
