<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkinType extends Model
{
    use HasFactory;

    public const API_ID_TO_NAME = [
        0 => 'dry',
        1 => 'normal',
        2 => 'oily',
    ];

    protected $table = 'skin_types';

    protected $fillable = [
        'api_id',
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'api_id' => 'integer',
        ];
    }

    public static function normalizeName(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $normalized = strtolower(trim($value));

        return match ($normalized) {
            'dry', 'dry skin' => 'dry',
            'normal', 'normal skin' => 'normal',
            'oily', 'oily skin' => 'oily',
            default => null,
        };
    }

    public static function apiIdFromName(?string $value): ?int
    {
        $normalized = static::normalizeName($value);

        if ($normalized === null) {
            return null;
        }

        return array_search($normalized, static::API_ID_TO_NAME, true);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function predictions(): HasMany
    {
        return $this->hasMany(Prediction::class);
    }
}
