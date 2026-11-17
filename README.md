<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## تشغيل المشروع

المشروع عبارة عن واجهة HTML داخل `public/` وواجهة API في Laravel لحفظ أربعة أنواع من البلاغات: الأسلحة، جرائم الحرب، الأنفاق، والمخدرات.

### المتطلبات

- PHP 8.2 أو أحدث
- Composer
- SQLite محليًا، أو MySQL عبر XAMPP
- FFmpeg/`ffprobe` للتحقق من مدة ملفات الفيديو

على Windows يمكن تثبيت FFmpeg بالأمر التالي:

```powershell
winget install --id Gyan.FFmpeg.Shared --source winget
```

بعد التثبيت افتح طرفية جديدة وتأكد من أن الأمر `ffprobe -version` يعمل. إذا كان الملف التنفيذي في مسار مختلف، حدّث `FFPROBE_PATH` في `.env`.

### الإعداد المحلي

```powershell
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve --host=127.0.0.1 --port=8000
```

افتح بعدها `http://127.0.0.1:8000`. إذا استخدمت MySQL، حدّث قيم `DB_*` في `.env` وشغّل MySQL قبل تنفيذ الترحيلات.

### لوحة الإدارة والتحليل

لوحة الإحصائيات متاحة على `http://127.0.0.1:8000/admin/login`، ولا يمكن الوصول إليها دون حساب يحمل `is_admin=true`. أنشئ حساب المدير من الطرفية؛ سيطلب الأمر كلمة المرور بشكل مخفي:

```powershell
php artisan admin:create admin@example.com --name="System Administrator"
```

تعرض اللوحة إجمالي البلاغات، توزيعها حسب النوع والمحافظة، الاتجاه الشهري، وأنواع جرائم الحرب. الحسابات المجمعة تُحسب داخل Laravel من قاعدة البيانات، ولا تحتاج Python. يمكن إضافة Python لاحقًا للتحليل التنبؤي أو تصنيف النصوص، عبر خدمة منفصلة لا تُخلط مع مسار حفظ البلاغات.

لإضافة بيانات تجريبية إلى لوحة الإحصائيات:

```powershell
php artisan db:seed --class=DemoDataSeeder --force
```

هذا Seeder مخصص للبيئة التجريبية فقط، ولا تضفه إلى `DatabaseSeeder` في بيئة الإنتاج.

### الاختبارات

```powershell
php artisan test
```

### نقاط API

- `POST /api/reports/weapons`
- `POST /api/reports/war-crimes`
- `POST /api/reports/tunnels`
- `POST /api/reports/drugs`

رفع الأدلة يتم إلى تخزين خاص، ولا ينبغي نشر ملفات `storage/app/private` مباشرة. حد الطلبات على نقاط البلاغات هو 10 طلبات لكل دقيقة.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
