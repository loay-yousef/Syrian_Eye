<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>دخول الإدارة | العين السورية</title>
    <style>
        :root { color-scheme: dark; font-family: Cairo, Tahoma, sans-serif; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; background: #101820; color: #eef4f7; }
        main { width: min(420px, calc(100% - 32px)); padding: 32px; border: 1px solid #2b4650; border-radius: 12px; background: #162631; box-shadow: 0 24px 70px #0005; }
        h1 { margin-top: 0; font-size: 1.5rem; }
        p { color: #a9bdc6; }
        label { display: block; margin: 18px 0 8px; }
        input { box-sizing: border-box; width: 100%; padding: 12px; border: 1px solid #3b5a65; border-radius: 6px; background: #0e1a21; color: #fff; }
        button { width: 100%; margin-top: 24px; padding: 12px; border: 0; border-radius: 6px; background: #36b39a; color: #06241d; font-weight: 700; cursor: pointer; }
        .error { padding: 10px; border-radius: 6px; background: #552c32; color: #ffd8dc; }
    </style>
</head>
<body>
<main>
    <h1>لوحة إدارة العين السورية</h1>
    <p>هذه الصفحة مخصصة لمدير النظام فقط.</p>
    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif
    <form method="post" action="{{ route('admin.login.store') }}">
        @csrf
        <label for="email">البريد الإلكتروني</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
        <label for="password">كلمة المرور</label>
        <input id="password" name="password" type="password" required>
        <button type="submit">دخول آمن</button>
    </form>
</main>
</body>
</html>
