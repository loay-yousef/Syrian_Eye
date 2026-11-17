<?php

namespace App\Http\Controllers;

use App\Models\WarCrimeReport;
use App\Http\Requests\StoreWarCrimeReportRequest;
use App\Services\EvidenceStorage;
use Illuminate\Support\Str;

class WarCrimeReportController extends Controller
{
    public function __construct(private readonly EvidenceStorage $evidenceStorage)
    {
    }

    public function store(StoreWarCrimeReportRequest $request)
    {
        $trackingCode = $this->generateTrackingCode();

        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $file = $request->file('evidence_file');
            $filePath = $this->evidenceStorage->store($file, 'reports/war-crimes');
        }

        $report = WarCrimeReport::create([
            'tracking_code' => $trackingCode,
            'suspect_name' => $request->suspect_name,
            'suspect_rank' => $request->suspect_rank,
            'suspect_description' => $request->suspect_description,
            'affiliation' => $request->affiliation,
            'crime_types' => json_decode($request->crime_types, true),
            'crime_details' => $request->crime_details,
            'victims' => $request->victims,
            'governorate' => $request->governorate,
            'exact_location' => $request->exact_location,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'crime_date' => $request->crime_date,
            'crime_time' => $request->crime_time,
            'evidence_file' => $filePath,
            'evidence_description' => $request->evidence_description,
            'has_photos' => $request->has_photos == '1',
            'has_videos' => $request->has_videos == '1',
            'has_audio' => $request->has_audio == '1',
            'has_medical_reports' => $request->has_medical_reports == '1',
            'has_autopsy_reports' => $request->has_autopsy_reports == '1',
            'has_direct_witnesses' => $request->has_direct_witnesses == '1',
            'has_indirect_witnesses' => $request->has_indirect_witnesses == '1',
            'needs_protection' => $request->needs_protection == '1',
            'importance' => $request->importance,
            'target_organizations' => json_decode($request->target_organizations, true),
        ]);

        return response()->json([
            'success' => true,
            'tracking_code' => $trackingCode,
            'message' => 'تم توثيق الجريمة بنجاح. احفظ الرقم التوثيقي.'
        ]);
    }

    private function generateTrackingCode()
    {
        do {
            $year = date('Y');
            $code = 'WAR-CRIME-' . $year . '-' . strtoupper(Str::random(6));
        } while (WarCrimeReport::where('tracking_code', $code)->exists());

        return $code;
    }
}