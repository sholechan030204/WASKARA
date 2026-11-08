<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetectionSession extends Model
{
    protected $fillable = [
        'user_id',
        'source_type',
        'source_name',
        'status',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function detections()
    {
        return $this->hasMany(
            Detection::class,
            'detection_session_id'
        );
    }
}