<?php

namespace App\Http\Controllers;

use App\Models\WarCrimeReport;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $tables = [
            'الأسلحة' => 'weapon_reports',
            'جرائم الحرب' => 'war_crime_reports',
            'الأنفاق والمقرات' => 'tunnel_reports',
            'المخدرات' => 'drug_reports',
        ];
        $byType = collect($tables)->mapWithKeys(fn (string $table, string $label): array => [$label => DB::table($table)->count()]);
        $combined = $this->combinedQuery(array_values($tables));
        $byGovernorate = $combined->select('governorate')->selectRaw('COUNT(*) as total')->groupBy('governorate')->orderByDesc('total')->pluck('total', 'governorate');
        $monthExpression = DB::connection()->getDriverName() === 'mysql'
            ? "DATE_FORMAT(created_at, '%Y-%m')"
            : "strftime('%Y-%m', created_at)";
        $byMonth = $this->combinedQuery(array_values($tables))
            ->selectRaw("{$monthExpression} as month, COUNT(*) as total")
            ->whereNotNull('created_at')
            ->groupByRaw($monthExpression)
            ->orderBy('month')
            ->pluck('total', 'month');

        $crimeTypes = WarCrimeReport::query()
            ->get(['crime_types'])
            ->flatMap(fn (WarCrimeReport $report): array => is_array($report->crime_types) ? $report->crime_types : [])
            ->countBy()
            ->sortDesc();

        return view('admin.dashboard', [
            'totalReports' => $byType->sum(),
            'byType' => $byType,
            'byGovernorate' => $byGovernorate,
            'byMonth' => $byMonth,
            'crimeTypes' => $crimeTypes,
        ]);
    }

    private function combinedQuery(array $tables)
    {
        $union = null;

        foreach ($tables as $table) {
            $part = DB::table($table)->select(['governorate', 'created_at']);
            $union = $union ? $union->unionAll($part) : $part;
        }

        return DB::query()->fromSub($union, 'reports');
    }
}
