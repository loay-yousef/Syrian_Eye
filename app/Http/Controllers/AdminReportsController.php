<?php

namespace App\Http\Controllers;

use App\Models\DrugReport;
use App\Models\TunnelReport;
use App\Models\WarCrimeReport;
use App\Models\WeaponReport;
use App\Services\AdminAuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportsController extends Controller
{
    private const STATUSES = ['new', 'reviewing', 'confirmed', 'closed', 'rejected'];

    private const TYPES = [
        'weapons' => [WeaponReport::class, 'الأسلحة', 'weapon_reports'],
        'war-crimes' => [WarCrimeReport::class, 'جرائم الحرب', 'war_crime_reports'],
        'tunnels' => [TunnelReport::class, 'الأنفاق والمقرات', 'tunnel_reports'],
        'drugs' => [DrugReport::class, 'المخدرات', 'drug_reports'],
    ];

    public function index(Request $request): View
    {
        $type = $request->string('type')->toString();
        $status = $request->string('status')->toString();
        $governorate = $request->string('governorate')->toString();

        $reports = $this->combinedQuery($type)
            ->when(in_array($status, self::STATUSES, true), fn ($query) => $query->where('status', $status))
            ->when($governorate !== '', fn ($query) => $query->where('governorate', $governorate))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.reports.index', [
            'reports' => $reports,
            'types' => collect(self::TYPES)->mapWithKeys(fn (array $definition, string $key): array => [$key => $definition[1]]),
            'statuses' => self::STATUSES,
            'governorates' => $this->governorates(),
            'selectedType' => $type,
            'selectedStatus' => $status,
            'selectedGovernorate' => $governorate,
        ]);
    }

    public function show(string $type, int $id): View
    {
        [$modelClass, $label] = $this->typeDefinition($type);
        $report = $modelClass::query()->findOrFail($id);

        return view('admin.reports.show', [
            'report' => $report,
            'type' => $type,
            'typeLabel' => $label,
            'statuses' => self::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, string $type, int $id, AdminAuditLogger $auditLogger)
    {
        [$modelClass, $label] = $this->typeDefinition($type);
        $report = $modelClass::query()->findOrFail($id);
        $data = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);
        $previousStatus = $report->status;

        $report->forceFill([
            'status' => $data['status'],
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ])->save();

        $auditLogger->record('status_updated', $type, $report->id, [
            'previous_status' => $previousStatus,
            'new_status' => $data['status'],
        ]);

        return redirect()
            ->route('admin.reports.show', [$type, $report->id])
            ->with('success', "تم تحديث حالة بلاغ {$label}.");
    }

    public function export(Request $request): StreamedResponse
    {
        $type = $request->string('type')->toString();
        $status = $request->string('status')->toString();
        $query = $this->combinedQuery($type)
            ->when(in_array($status, self::STATUSES, true), fn ($builder) => $builder->where('status', $status))
            ->orderByDesc('created_at');

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['type', 'tracking_code', 'governorate', 'status', 'created_at']);

            $query->chunk(500, function ($reports) use ($handle): void {
                foreach ($reports as $report) {
                    fputcsv($handle, [
                        $report->report_type,
                        $report->tracking_code,
                        $report->governorate,
                        $report->status,
                        $report->created_at,
                    ]);
                }
            });

            fclose($handle);
        }, 'reports-'.now()->format('Y-m-d-His').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function combinedQuery(string $type)
    {
        $definitions = $type !== '' && isset(self::TYPES[$type])
            ? [$type => self::TYPES[$type]]
            : self::TYPES;
        $union = null;

        foreach ($definitions as $key => $definition) {
            $part = DB::table($definition[2])
                ->select(['id', 'tracking_code', 'governorate', 'status', 'created_at'])
                ->selectRaw('? as report_type', [$key]);
            $union = $union ? $union->unionAll($part) : $part;
        }

        return DB::query()->fromSub($union, 'reports');
    }

    private function typeDefinition(string $type): array
    {
        abort_unless(isset(self::TYPES[$type]), 404);

        return self::TYPES[$type];
    }

    private function governorates()
    {
        return collect(self::TYPES)
            ->flatMap(fn (array $definition) => DB::table($definition[2])->pluck('governorate'))
            ->filter()
            ->unique()
            ->sort()
            ->values();
    }
}
