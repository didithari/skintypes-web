<?php

namespace App\Services;

use Illuminate\Support\Collection;

/**
 * Simple Additive Weighting (SAW) Decision Support Service.
 *
 * Criteria:
 *   C1 - Kandungan aktif  (Benefit, weight 0.40)
 *   C2 - Kandungan iritatif (Cost,   weight 0.25)
 *   C3 - Harga             (Cost,   weight 0.25)
 *   C4 - Tekstur           (Benefit, weight 0.10)
 */
class SawService
{
    /**
     * Bobot kriteria (W).
     */
    protected array $weights = [
        'c1' => 0.40,
        'c2' => 0.25,
        'c3' => 0.25,
        'c4' => 0.10,
    ];

    /**
     * Mapping tekstur ke nilai numerik untuk perhitungan benefit.
     * Semakin tinggi = semakin baik (gel paling cocok untuk kulit berminyak, cream untuk kering).
     * Mapping ini menjadi kontekstual per skin type — tetapi untuk SAW sederhana,
     * kita gunakan skala umum: gel=3, foam=2, cream=1.
     */
    protected array $teksturMap = [
        'gel'   => 3,
        'foam'  => 2,
        'cream' => 1,
    ];

    /**
     * Main SAW calculation: takes a collection of products and returns them
     * ranked with their SAW details.
     *
     * @param  \Illuminate\Support\Collection  $products  Must have c1_kandungan, c2_iritatif, c3_harga, c4_tekstur
     * @return \Illuminate\Support\Collection  Products ranked by SAW score (V), each with saw_details appended.
     */
    public function rank(Collection $products): Collection
    {
        if ($products->isEmpty()) {
            return $products;
        }

        // Step 1: Build decision matrix
        $matrix = $products->map(fn ($p) => [
            'id'  => $p->id,
            'c1'  => (int) $p->c1_kandungan,
            'c2'  => (int) $p->c2_iritatif,
            'c3'  => (int) $p->c3_harga,
            'c4'  => $this->teksturMap[$p->c4_tekstur] ?? 2,
        ]);

        // Step 2: Find max and min per criterion
        $maxC1 = $matrix->max('c1');
        $maxC4 = $matrix->max('c4');
        $minC2 = $matrix->min('c2');
        $minC3 = $matrix->min('c3');

        // Prevent division by zero
        $maxC1 = $maxC1 ?: 1;
        $maxC4 = $maxC4 ?: 1;

        // Step 3: Normalize (R) and calculate preference value (V)
        $scores = [];
        foreach ($matrix as $row) {
            $r1 = $row['c1'] / $maxC1;                           // Benefit
            $r2 = ($row['c2'] > 0) ? $minC2 / $row['c2'] : 1;   // Cost
            $r3 = ($row['c3'] > 0) ? $minC3 / $row['c3'] : 1;   // Cost
            $r4 = $row['c4'] / $maxC4;                           // Benefit

            $v = ($this->weights['c1'] * $r1)
               + ($this->weights['c2'] * $r2)
               + ($this->weights['c3'] * $r3)
               + ($this->weights['c4'] * $r4);

            $scores[$row['id']] = [
                'r1' => round($r1, 4),
                'r2' => round($r2, 4),
                'r3' => round($r3, 4),
                'r4' => round($r4, 4),
                'v'  => round($v, 4),
            ];
        }

        // Step 4: Sort by V descending, attach details, add rank
        return $products
            ->map(function ($product) use ($scores) {
                $product->saw_details = $scores[$product->id] ?? null;
                return $product;
            })
            ->sortByDesc(fn ($p) => $p->saw_details['v'] ?? 0)
            ->values()
            ->map(function ($product, $index) {
                $product->saw_rank = $index + 1;
                return $product;
            });
    }

    /**
     * Get the weight configuration.
     */
    public function getWeights(): array
    {
        return $this->weights;
    }
}
