<?php

namespace App\Http\Controllers;

use App\Models\DrugReport;
use App\Models\TunnelReport;
use App\Models\WarCrimeReport;
use App\Models\WeaponReport;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $sources = collect([
            ['label' => 'الأسلحة', 'items' => WeaponReport::query()->get(['governorate', 'created_at'])],
            ['label' => 'جرائم الحرب', 'items' => WarCrimeReport::query()->get(['governorate', 'created_at', 'crime_types'])],
            ['label' => 'الأنفاق والمقرات', 'items' => TunnelReport::query()->get(['governorate', 'created_at'])],
            ['label' => 'المخدرات', 'items' => DrugReport::query()->get(['governorate', 'created_at'])],
        ]);

        $allReports = $sources->flatMap(function (array $source): Collection {
            return $source['items']->map(fn ($report): array => [
                'type' => $source['label'],
                'governorate' => $report->governorate,
                'created_at' => $report->created_at,
            ]);
        });

        $byType = $sources->mapWithKeys(fn (array $source): array => [
            $source['label'] => $source['items']->count(),
        ]);

        $byGovernorate = $allReports->countBy('governorate')->sortDesc();
        $byMonth = $allReports
            ->filter(fn (array $report): bool => $report['created_at'] !== null)
            ->groupBy(fn (array $report): string => $report['created_at']->format('Y-m'))
            ->map->count()
            ->sortKeys();

        $crimeTypes = WarCrimeReport::query()
            ->get(['crime_types'])
            ->flatMap(fn (WarCrimeReport $report): array => is_array($report->crime_types) ? $report->crime_types : [])
            ->countBy()
            ->sortDesc();

        return view('admin.dashboard', [
            'totalReports' => $allReports->count(),
            'byType' => $byType,
            'byGovernorate' => $byGovernorate,
            'byMonth' => $byMonth,
            'crimeTypes' => $crimeTypes,
        ]);
    }
}
