<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\WeaponReport;
use App\Http\Requests\StoreWeaponReportRequest;
use App\Services\EvidenceStorage;
use Illuminate\Support\Str;

class WeaponReportController extends Controller
{
    public function __construct(private readonly EvidenceStorage $evidenceStorage)
    {
    }

    public function store(StoreWeaponReportRequest $request)
    {
        // 1. توليد رمز تتبع فريد
        $trackingCode = $this->generateTrackingCode('WPN');

        // 2. رفع الملف (إن وُجد)
        $filePath = null;
        if ($request->hasFile('evidenceFile')) {
            $file = $request->file('evidenceFile');
            $filePath = $this->evidenceStorage->store($file, 'reports/weapons');
        }

        // 3. حفظ البلاغ
        $report = WeaponReport::create([
            'tracking_code' => $trackingCode,
            'governorate' => $request->governorate,
            'exact_location' => $request->exactLocation,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'weapon_type' => $request->weaponType,
            'activity' => $request->activity,
            'description' => $request->description,
            'event_date' => $request->date,
            'event_time' => $request->time,
            'is_ongoing' => $request->is_ongoing,
            'evidence_description' => $request->evidenceDescription,
            'evidence_file' => $filePath,
        ]);

        return response()->json([
            'success' => true,
            'tracking_code' => $trackingCode,
            'message' => 'تم إرسال البلاغ بنجاح. احفظ الرمز في مكان آمن.'
        ]);
    }

    private function generateTrackingCode($prefix)
    {
        do {
            $code = $prefix . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        } while (WeaponReport::where('tracking_code', $code)->exists());

        return $code;
    }
}