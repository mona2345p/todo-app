# دليل تهيئة بيئة تطوير To-Do List Application

## المتطلبات الأساسية

- XAMPP (Apache + MySQL) أو خدمة MySQL متاحة محلياً
- PHP 8.3 أو أحدث مع إضافات PDO والـ SQLite اختيارياً للاختبارات
- Composer و Git

## هيكل المشروع

تطبيق Laravel واحد موجود مباشرة في جذر المستودع `todo-app/`. لا يوجد تطبيق فرعي `laravel-app/`.

## خطوات التهيئة

### 1. تشغيل MySQL وإنشاء قواعد البيانات

```bash
mysql -u root -p
CREATE DATABASE IF NOT EXISTS todo_app;
CREATE DATABASE IF NOT EXISTS todo_app_test;
```

لا تقم بتشغيل `migrate:fresh` على قاعدة بيانات التطوير `todo_app`.

### 2. تثبيت التبعيات

```bash
composer install
```

### 3. ملف البيئة

```bash
copy .env.example .env
php artisan key:generate
```

اضبط في `.env` أسماء المتغيرات التالية فقط حسب بيئتك (لا تشارك قيم `.env`):

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app
DB_USERNAME=...
DB_PASSWORD=...
```

### 4. إنشاء جداول التطوير

```bash
php artisan migrate
```

### 5. تشغيل الاختبارات

مع MySQL متاح، يستخدم `phpunit.xml` قاعدة الاختبار المعزولة `todo_app_test`:

```bash
php artisan test
```

في بيئة لا تتوفر فيها خدمة MySQL، شغّل الاختبارات على قاعدة SQLite معزولة في الذاكرة:

```powershell
$env:DB_CONNECTION='sqlite'
$env:DB_DATABASE=':memory:'
php -d extension=pdo_sqlite vendor/bin/phpunit
```

### 6. تشغيل التطبيق

```bash
php artisan serve
```

ثم افتح http://localhost:8000/tasks

## المراجع

- `specs/002-todo-app-mvp/tasks.md`
- `specs/002-todo-app-mvp/spec.md`
- `.specify/memory/constitution.md`
