<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prediction extends Model
{
    use HasFactory;

    protected $table = 'predictions';

    protected $fillable = [
        'skin_type_id',
        'image_path',
        'confidence',
        'predicted_at',
    ];

    protected function casts(): array
    {
        return [
            'predicted_at' => 'datetime',
            'confidence' => 'decimal:4',
        ];
    }

    public function skinType(): BelongsTo
    {
        return $this->belongsTo(SkinType::class);
    }
}
