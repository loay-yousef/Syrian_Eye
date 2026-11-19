<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarCrimeReport extends Model
{
    protected $fillable = [
        'tracking_code',
        'suspect_name',
        'suspect_rank',
        'suspect_description',
        'affiliation',
        'crime_types',
        'crime_details',
        'victims',
        'governorate',
        'exact_location',
        'lat',
        'lng',
        'crime_date',
        'crime_time',
        'evidence_file',
        'evidence_description',
        'has_photos',
        'has_videos',
        'has_audio',
        'has_medical_reports',
        'has_autopsy_reports',
        'has_direct_witnesses',
        'has_indirect_witnesses',
        'needs_protection',
        'importance',
        'target_organizations',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'crime_types' => 'array',
        'target_organizations' => 'array',
        'has_photos' => 'boolean',
        'has_videos' => 'boolean',
        'has_audio' => 'boolean',
        'has_medical_reports' => 'boolean',
        'has_autopsy_reports' => 'boolean',
        'has_direct_witnesses' => 'boolean',
        'has_indirect_witnesses' => 'boolean',
        'needs_protection' => 'boolean',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'reviewed_at' => 'datetime',
    ];
}