<?php

namespace App\Http\Controllers;

use App\Models\DrugReport;
use App\Http\Requests\StoreDrugReportRequest;
use App\Services\EvidenceStorage;

class DrugReportController extends Controller
{
    public function __construct(private readonly EvidenceStorage $evidenceStorage)
    {
    }

    public function store(StoreDrugReportRequest $request)
    {
        $trackingCode = $this->generateTrackingCode();

        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $file = $request->file('evidence_file');
            $filePath = $this->evidenceStorage->store($file, 'reports/drugs');
        }

        $report = DrugReport::create([
            'tracking_code' => $trackingCode,
            'governorate' => $request->governorate,
            'exact_location' => $request->exact_location,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'evidence_file' => $filePath,
            'evidence_description' => $request->evidence_description,
            'drug_type' => $request->drug_type,
            'activity_type' => $request->activity_type,
            'scale' => $request->scale,
            'description' => $request->description,
            'has_plated_cars' => $request->has_plated_cars == '1',
            'has_armed_guard' => $request->has_armed_guard == '1',
            'has_chemical_smells' => $request->has_chemical_smells == '1',
            'has_night_activity' => $request->has_night_activity == '1',
            'frequency' => $request->frequency,
            'threat_level' => $request->threat_level,
            'impact' => $request->impact,
        ]);

        return response()->json([
            'success' => true,
            'tracking_code' => $trackingCode,
            'message' => 'تم إرسال بلاغ المخدرات بنجاح.'
        ]);
    }

    private function generateTrackingCode()
    {
        do {
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            $code = 'DRG-' . 
                   $chars[random_int(0, strlen($chars)-1)] .
                   $chars[random_int(0, strlen($chars)-1)] .
                   $chars[random_int(0, strlen($chars)-1)] . '-' .
                   $chars[random_int(0, strlen($chars)-1)] .
                   $chars[random_int(0, strlen($chars)-1)] .
                   $chars[random_int(0, strlen($chars)-1)];
        } while (DrugReport::where('tracking_code', $code)->exists());

        return $code;
    }
}
