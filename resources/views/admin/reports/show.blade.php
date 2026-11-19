<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تفاصيل البلاغ</title>
    <style>
        :root { font-family: Cairo, Tahoma, sans-serif; color: #e8f0f3; background: #101820; }
        * { box-sizing: border-box; } body { margin: 0; } main { width: min(900px, calc(100% - 32px)); margin: 30px auto; }
        .panel { padding: 22px; background: #162631; border: 1px solid #28434d; border-radius: 10px; } h1 { margin-top: 0; }
        dl { display: grid; grid-template-columns: 180px 1fr; gap: 12px; } dt { color: #57d2b4; } dd { margin: 0; white-space: pre-wrap; word-break: break-word; }
        select, button { padding: 10px; border-radius: 5px; border: 1px solid #3b5a65; background: #0e1a21; color: #fff; } button { background: #57d2b4; color: #06241d; cursor: pointer; }
        a { color: #78a9e8; } .success { padding: 10px; background: #1d493d; margin-bottom: 15px; }
        @media (max-width: 600px) { dl { grid-template-columns: 1fr; gap: 5px; } dd { margin-bottom: 10px; } }
    </style>
</head>
<body>
<main>
    <p><a href="{{ route('admin.reports.index') }}">العودة إلى قائمة البلاغات</a></p>
    <section class="panel">
        <h1>{{ $typeLabel }}</h1>
        @if (session('success'))<div class="success">{{ session('success') }}</div>@endif
        <dl>
            <dt>رمز التتبع</dt><dd>{{ $report->tracking_code }}</dd>
            <dt>المحافظة</dt><dd>{{ $report->governorate }}</dd>
            <dt>الموقع</dt><dd>{{ $report->exact_location }}</dd>
            <dt>تاريخ الإنشاء</dt><dd>{{ $report->created_at }}</dd>
            <dt>الحالة الحالية</dt><dd>{{ $report->status }}</dd>
        </dl>
        <hr>
        <form method="post" action="{{ route('admin.reports.status', [$type, $report->id]) }}">
            @csrf
            @method('PATCH')
            <label for="status">تحديث الحالة</label>
            <select id="status" name="status">@foreach ($statuses as $status)<option value="{{ $status }}" @selected($report->status === $status)>{{ $status }}</option>@endforeach</select>
            <button type="submit">حفظ الحالة</button>
        </form>
    </section>
</main>
</body>
</html>
