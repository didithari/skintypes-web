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
        'c1_kandungan',
        'c2_iritatif',
        'c3_harga',
        'c4_tekstur',
        'link_produk',
    ];

    protected function casts(): array
    {
        return [
            'c1_kandungan' => 'integer',
            'c2_iritatif'  => 'integer',
            'c3_harga'     => 'integer',
            'price'        => 'integer',
        ];
    }

    /**
     * Auto-calculate c3_harga from price on save.
     */
    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            $product->c3_harga = static::priceToRange($product->price);
        });
    }

    /**
     * Convert price (Rupiah) to C3 range value.
     * 1 = < 50.000, 2 = 50.000-100.000, 3 = 100.000-150.000, 4 = > 150.000
     */
    public static function priceToRange(?int $price): int
    {
        if ($price === null || $price < 50000) {
            return 1;
        } elseif ($price <= 100000) {
            return 2;
        } elseif ($price <= 150000) {
            return 3;
        }
        return 4;
    }

    /**
     * Label deskriptif untuk nilai C1 (Kandungan Aktif).
     */
    public function getC1LabelAttribute(): string
    {
        return match ($this->c1_kandungan) {
            1 => 'Rendah',
            2 => 'Sedang',
            3 => 'Tinggi',
            4 => 'Sangat Tinggi',
            default => '-',
        };
    }

    /**
     * Label deskriptif untuk nilai C2 (Kandungan Iritatif).
     */
    public function getC2LabelAttribute(): string
    {
        return match ($this->c2_iritatif) {
            1 => 'Rendah',
            2 => 'Sedang',
            3 => 'Tinggi',
            default => '-',
        };
    }

    /**
     * Label deskriptif untuk nilai C3 (Range Harga).
     */
    public function getC3LabelAttribute(): string
    {
        return match ($this->c3_harga) {
            1 => '< Rp 50.000',
            2 => 'Rp 50.000 - 100.000',
            3 => 'Rp 100.000 - 150.000',
            4 => '> Rp 150.000',
            default => '-',
        };
    }

    public function skinType(): BelongsTo
    {
        return $this->belongsTo(SkinType::class);
    }
}
