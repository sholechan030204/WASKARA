<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'detection_id',
        'violation_type',
        'confidence',
        'evidence_image',
        'location',
        'status',
        'occurred_at',
    ];

    protected $casts = [
        'confidence' => 'float',
        'occurred_at' => 'datetime',
    ];

    /**
     * Deteksi YOLOv11 yang menghasilkan pelanggaran.
     */
    public function detection(): BelongsTo
    {
        return $this->belongsTo(Detection::class);
    }
}