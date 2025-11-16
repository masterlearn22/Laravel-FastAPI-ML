<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MammalsPrediction extends Model
{
    // Sesuaikan dengan nama tabel di migration
    protected $table = 'mammal_predictions';

    protected $fillable = [
        'image_path',
        'label',
        'confidence',
        'top5_labels',
        'top5_probs',
    ];

    protected $casts = [
        'top5_labels' => 'array',
        'top5_probs'  => 'array',
    ];
}
