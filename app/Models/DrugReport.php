<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugReport extends Model
{
    protected $fillable = [
        'tracking_code',
        'governorate',
        'exact_location',
        'lat',
        'lng',
        'evidence_file',
        'evidence_description',
        'drug_type',
        'activity_type',
        'scale',
        'description',
        'has_plated_cars',
        'has_armed_guard',
        'has_chemical_smells',
        'has_night_activity',
        'frequency',
        'threat_level',
        'impact',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'has_plated_cars' => 'boolean',
        'has_armed_guard' => 'boolean',
        'has_chemical_smells' => 'boolean',
        'has_night_activity' => 'boolean',
        'reviewed_at' => 'datetime',
    ];
}
