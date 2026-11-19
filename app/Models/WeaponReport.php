<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponReport extends Model
{
    protected $guarded=['id'];

    protected $casts = [
        'is_ongoing' => 'boolean',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'reviewed_at' => 'datetime',
    ];
    
    /** @use HasFactory<\Database\Factories\WeaponReportFactory> */
    use HasFactory;
}
