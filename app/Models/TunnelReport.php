<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TunnelReport extends Model
{
    protected $fillable = [
        'tracking_code',
        'governorate',
        'exact_location',
        'lat',
        'lng',
        'location_type',
        'evidence_file',
        'evidence_description',
        'length',
        'width',
        'depth',
        'entrances',
        'construction_type',
        'purpose',
        'has_continuous_movement',
        'has_equipment_transport',
        'has_armed_guard',
        'has_vehicle_traffic',
        'has_machinery_sounds',
        'capacity',
        'has_cameras',
        'has_towers',
        'has_patrols',
        'has_mines',
        'has_barbed_wire',
        'has_concrete_barriers',
        'has_alarm_systems',
        'has_generators',
        'has_ventilation',
        'security_level',
        'discovery_date',
        'activity_time',
        'duration',
    ];

    protected $casts = [
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'depth' => 'decimal:2',
        'has_continuous_movement' => 'boolean',
        'has_equipment_transport' => 'boolean',
        'has_armed_guard' => 'boolean',
        'has_vehicle_traffic' => 'boolean',
        'has_machinery_sounds' => 'boolean',
        'has_cameras' => 'boolean',
        'has_towers' => 'boolean',
        'has_patrols' => 'boolean',
        'has_mines' => 'boolean',
        'has_barbed_wire' => 'boolean',
        'has_concrete_barriers' => 'boolean',
        'has_alarm_systems' => 'boolean',
        'has_generators' => 'boolean',
        'has_ventilation' => 'boolean',
    ];
}