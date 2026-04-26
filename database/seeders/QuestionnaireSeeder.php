<?php

namespace Database\Seeders;

use App\Models\Prediction;
use App\Models\Questionnaire;
use Illuminate\Database\Seeder;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Questionnaire::truncate();

        $predictions = Prediction::all();

        foreach ($predictions as $prediction) {
            $matchStatus = collect(['iya', 'tidak', 'tidak_tahu'])->random();

            Questionnaire::create([
                'result_id' => $prediction->id,
                'q1_is_smooth' => (bool) random_int(0, 1),
                'q2_rating' => random_int(1, 5),
                'q3_match_status' => $matchStatus,
                'expected_skin' => $matchStatus === 'tidak' ? collect(['berminyak', 'kering', 'normal', 'kombinasi'])->random() : null,
                'q4_has_used_recommended_product' => (bool) random_int(0, 1),
                'q5_ingredient_info_clear' => (bool) random_int(0, 1),
                'q6_helpful_for_new_product' => (bool) random_int(0, 1),
                'q7_would_click_buy_button' => (bool) random_int(0, 1),
                'consent' => true,
                'submitted_at' => now()->subMinutes(random_int(1, 10080)),
            ]);
        }
    }
}
