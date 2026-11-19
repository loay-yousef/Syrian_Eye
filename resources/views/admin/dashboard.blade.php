<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>الإحصائيات | العين السورية</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <style>
        :root { font-family: Cairo, Tahoma, sans-serif; color: #e8f0f3; background: #101820; }
        * { box-sizing: border-box; }
        body { margin: 0; }
        header { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 18px clamp(16px, 5vw, 72px); border-bottom: 1px solid #28434d; background: #14232c; }
        header h1 { margin: 0; font-size: clamp(1.1rem, 3vw, 1.7rem); }
        button { border: 0; border-radius: 6px; padding: 9px 14px; cursor: pointer; }
        .logout { background: #d76666; color: #260a0a; }
        main { width: min(1240px, calc(100% - 32px)); margin: 28px auto 60px; }
        .summary { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 18px; }
        .metric, .panel { border: 1px solid #28434d; border-radius: 10px; background: #162631; }
        .metric { padding: 18px; }
        .metric strong { display: block; margin-top: 8px; font-size: 2rem; color: #57d2b4; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .panel { padding: 18px; min-height: 340px; }
        h2 { margin: 0 0 14px; font-size: 1.05rem; }
        canvas { max-height: 285px; }
        .notice { margin-bottom: 18px; padding: 12px 14px; border-right: 4px solid #57d2b4; color: #bfd1d7; background: #1a3039; }
        @media (max-width: 760px) { .summary, .grid { grid-template-columns: 1fr; } header { align-items: flex-start; flex-direction: column; } }
    </style>
</head>
<body>
<header>
    <h1>لوحة الإحصائيات والتحليل</h1>
    <div>
        <a href="{{ route('admin.reports.index') }}" style="color:#57d2b4; margin-left:12px;">إدارة البلاغات</a>
        <form method="post" action="{{ route('admin.logout') }}" style="display:inline">
            @csrf
            <button class="logout" type="submit">تسجيل الخروج</button>
        </form>
    </div>
</header>
<main>
    <div class="notice">تعرض هذه الصفحة مؤشرات مجمعة فقط. لا يتم عرض نصوص البلاغات أو الأدلة في لوحة الإحصائيات.</div>
    <section class="summary">
        <div class="metric">إجمالي البلاغات<strong>{{ $totalReports }}</strong></div>
        @foreach ($byType as $label => $count)
            <div class="metric">{{ $label }}<strong>{{ $count }}</strong></div>
        @endforeach
    </section>
    <section class="grid">
        <article class="panel"><h2>توزيع البلاغات حسب النوع</h2><canvas id="typeChart"></canvas></article>
        <article class="panel"><h2>المناطق الأكثر ورودًا في البلاغات</h2><canvas id="governorateChart"></canvas></article>
        <article class="panel"><h2>تطور عدد البلاغات شهريًا</h2><canvas id="monthChart"></canvas></article>
        <article class="panel"><h2>أنواع الجرائم الموثقة</h2><canvas id="crimeChart"></canvas></article>
    </section>
</main>
<script>
    const palette = ['#57d2b4', '#e6b35a', '#d76666', '#78a9e8', '#b48be8', '#e58aa8'];
    const charts = {
        type: { labels: @json($byType->keys()->values()), data: @json($byType->values()) },
        governorate: { labels: @json($byGovernorate->keys()->values()), data: @json($byGovernorate->values()) },
        month: { labels: @json($byMonth->keys()->values()), data: @json($byMonth->values()) },
        crime: { labels: @json($crimeTypes->keys()->values()), data: @json($crimeTypes->values()) }
    };
    new Chart(document.getElementById('typeChart'), { type: 'doughnut', data: { labels: charts.type.labels, datasets: [{ data: charts.type.data, backgroundColor: palette }] }, options: { plugins: { legend: { labels: { color: '#e8f0f3' } } } } });
    new Chart(document.getElementById('governorateChart'), { type: 'bar', data: { labels: charts.governorate.labels, datasets: [{ label: 'عدد البلاغات', data: charts.governorate.data, backgroundColor: '#57d2b4' }] }, options: { scales: { x: { ticks: { color: '#bfd1d7' } }, y: { ticks: { color: '#bfd1d7' }, beginAtZero: true } }, plugins: { legend: { display: false } } } });
    new Chart(document.getElementById('monthChart'), { type: 'line', data: { labels: charts.month.labels, datasets: [{ label: 'البلاغات', data: charts.month.data, borderColor: '#e6b35a', backgroundColor: '#e6b35a55', fill: true, tension: .3 }] }, options: { scales: { x: { ticks: { color: '#bfd1d7' } }, y: { ticks: { color: '#bfd1d7' }, beginAtZero: true } } } });
    new Chart(document.getElementById('crimeChart'), { type: 'bar', data: { labels: charts.crime.labels, datasets: [{ label: 'عدد الحالات', data: charts.crime.data, backgroundColor: '#78a9e8' }] }, options: { indexAxis: 'y', scales: { x: { ticks: { color: '#bfd1d7' }, beginAtZero: true }, y: { ticks: { color: '#bfd1d7' } } }, plugins: { legend: { display: false } } } });
</script>
</body>
</html>
