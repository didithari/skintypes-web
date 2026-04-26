<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Questionnaire extends Model
{
    use HasFactory;

    protected $table = 'questionnaires';

    protected $fillable = [
        'result_id',
        'q1_is_smooth',
        'q2_rating',
        'q3_match_status',
        'expected_skin',
        'q4_has_used_recommended_product',
        'q5_ingredient_info_clear',
        'q6_helpful_for_new_product',
        'q7_would_click_buy_button',
        'consent',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'q1_is_smooth' => 'boolean',
            'q2_rating' => 'integer',
            'q4_has_used_recommended_product' => 'boolean',
            'q5_ingredient_info_clear' => 'boolean',
            'q6_helpful_for_new_product' => 'boolean',
            'q7_would_click_buy_button' => 'boolean',
            'consent' => 'boolean',
            'submitted_at' => 'datetime',
        ];
    }

    public function prediction(): BelongsTo
    {
        return $this->belongsTo(Prediction::class, 'result_id');
    }
}