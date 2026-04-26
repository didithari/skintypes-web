<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinTypeIngredient extends Model
{
    use HasFactory;

    protected $fillable = ['skin_type_id', 'type', 'name', 'description'];

    public function skinType()
    {
        return $this->belongsTo(SkinType::class);
    }
}
