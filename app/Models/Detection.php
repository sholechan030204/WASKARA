<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detection extends Model
{
    protected $fillable = [
        'detection_session_id',
        'class_name',
        'confidence',
        'x1',
        'y1',
        'x2',
        'y2',
        'image_path',
        'detected_at',
    ];
}