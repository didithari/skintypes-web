<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'skin_type_id',
        'name',
        'brand',
        'description',
        'price',
        'image_url',
    ];

    public function skinType(): BelongsTo
    {
        return $this->belongsTo(SkinType::class);
    }
}
