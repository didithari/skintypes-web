<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinPrediction extends Model
{
    use HasFactory;

    protected $table = 'skin_predictions';

    protected $fillable = [
        'image_path',
        'prediction',
        'result_label'
    ];
}
