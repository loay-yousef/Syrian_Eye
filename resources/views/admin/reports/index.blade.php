<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إدارة البلاغات</title>
    <style>
        :root { font-family: Cairo, Tahoma, sans-serif; color: #e8f0f3; background: #101820; }
        * { box-sizing: border-box; } body { margin: 0; }
        header { padding: 18px clamp(16px, 5vw, 72px); border-bottom: 1px solid #28434d; background: #14232c; }
        header a { color: #57d2b4; text-decoration: none; } main { width: min(1200px, calc(100% - 32px)); margin: 26px auto; }
        .toolbar, .table-wrap { background: #162631; border: 1px solid #28434d; border-radius: 10px; padding: 16px; }
        .toolbar { display: flex; flex-wrap: wrap; gap: 10px; align-items: end; margin-bottom: 18px; }
        label { display: grid; gap: 5px; color: #bfd1d7; } select, button { padding: 9px; border-radius: 5px; border: 1px solid #3b5a65; background: #0e1a21; color: #fff; }
        button, .export { background: #57d2b4; color: #06241d; cursor: pointer; text-decoration: none; } table { width: 100%; border-collapse: collapse; } th, td { padding: 12px 8px; border-bottom: 1px solid #28434d; text-align: right; } th { color: #57d2b4; }
        a { color: #78a9e8; } .status { color: #e6b35a; } .pagination { margin-top: 16px; display: flex; gap: 12px; }
        @media (max-width: 700px) { .table-wrap { overflow-x: auto; } table { min-width: 700px; } }
    </style>
</head>
<body>
<header><a href="{{ route('admin.dashboard') }}">لوحة الإحصائيات</a> <span> / إدارة البلاغات</span></header>
<main>
    <form class="toolbar" method="get">
        <label>النوع<select name="type"><option value="">كل الأنواع</option>@foreach ($types as $key => $label)<option value="{{ $key }}" @selected($selectedType === $key)>{{ $label }}</option>@endforeach</select></label>
        <label>الحالة<select name="status"><option value="">كل الحالات</option>@foreach ($statuses as $status)<option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>@endforeach</select></label>
        <label>المحافظة<select name="governorate"><option value="">كل المحافظات</option>@foreach ($governorates as $governorate)<option value="{{ $governorate }}" @selected($selectedGovernorate === $governorate)>{{ $governorate }}</option>@endforeach</select></label>
        <button type="submit">تصفية</button>
        <a class="export" href="{{ route('admin.reports.export', request()->query()) }}">تصدير CSV</a>
    </form>
    <div class="table-wrap">
        <table>
            <thead><tr><th>النوع</th><th>رمز التتبع</th><th>المحافظة</th><th>الحالة</th><th>التاريخ</th><th></th></tr></thead>
            <tbody>
            @forelse ($reports as $report)
                <tr>
                    <td>{{ $types[$report->report_type] ?? $report->report_type }}</td>
                    <td>{{ $report->tracking_code }}</td>
                    <td>{{ $report->governorate }}</td>
                    <td class="status">{{ $report->status }}</td>
                    <td>{{ $report->created_at }}</td>
                    <td><a href="{{ route('admin.reports.show', [$report->report_type, $report->id]) }}">عرض</a></td>
                </tr>
            @empty
                <tr><td colspan="6">لا توجد بلاغات مطابقة.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $reports->links() }}</div>
    </div>
</main>
</body>
</html>
