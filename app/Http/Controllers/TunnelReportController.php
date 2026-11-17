<?php

namespace App\Http\Controllers;

use App\Models\TunnelReport;
use App\Http\Requests\StoreTunnelReportRequest;
use App\Services\EvidenceStorage;
use Illuminate\Support\Str;

class TunnelReportController extends Controller
{
    public function __construct(private readonly EvidenceStorage $evidenceStorage)
    {
    }

    public function store(StoreTunnelReportRequest $request)
    {
        $trackingCode = $this->generateTrackingCode();

        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $file = $request->file('evidence_file');
            $filePath = $this->evidenceStorage->store($file, 'reports/tunnels');
        }

        $report = TunnelReport::create([
            'tracking_code' => $trackingCode,
            'governorate' => $request->governorate,
            'exact_location' => $request->exact_location,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'location_type' => $request->location_type,
            'evidence_file' => $filePath,
            'evidence_description' => $request->evidence_description,
            'length' => $request->length,
            'width' => $request->width,
            'depth' => $request->depth,
            'entrances' => $request->entrances,
            'construction_type' => $request->construction_type,
            'purpose' => $request->purpose,
            'has_continuous_movement' => $request->has_continuous_movement == '1',
            'has_equipment_transport' => $request->has_equipment_transport == '1',
            'has_armed_guard' => $request->has_armed_guard == '1',
            'has_vehicle_traffic' => $request->has_vehicle_traffic == '1',
            'has_machinery_sounds' => $request->has_machinery_sounds == '1',
            'capacity' => $request->capacity,
            'has_cameras' => $request->has_cameras == '1',
            'has_towers' => $request->has_towers == '1',
            'has_patrols' => $request->has_patrols == '1',
            'has_mines' => $request->has_mines == '1',
            'has_barbed_wire' => $request->has_barbed_wire == '1',
            'has_concrete_barriers' => $request->has_concrete_barriers == '1',
            'has_alarm_systems' => $request->has_alarm_systems == '1',
            'has_generators' => $request->has_generators == '1',
            'has_ventilation' => $request->has_ventilation == '1',
            'security_level' => $request->security_level,
            'discovery_date' => $request->discovery_date,
            'activity_time' => $request->activity_time,
            'duration' => $request->duration,
        ]);

        return response()->json([
            'success' => true,
            'tracking_code' => $trackingCode,
            'message' => 'تم إرسال بلاغ الأنفاق بنجاح.'
        ]);
    }

    private function generateTrackingCode()
    {
        do {
            $code = 'TNL-GEO-' . strtoupper(Str::random(6));
        } while (TunnelReport::where('tracking_code', $code)->exists());

        return $code;
    }
}