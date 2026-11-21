# دليل تهيئة بيئة تطوير To-Do List Application

## المتطلبات الأساسية

لتنفيذ مشروع To-Do List باستخدام Laravel، تحتاج إلى تثبيت الأدوات التالية:

### 1. تثبيت XAMPP (لـ MySQL وApache)
1. قم بتحميل XAMPP من الموقع الرسمي: https://www.apachefriends.org/
2. قم بتثبيته مع جميع المكونات الافتراضية
3. ابدأ خدمة MySQL من لوحة تحكم XAMPP

### 2. تثبيت Composer (مدير حزم PHP)
1. قم بتحميل Composer من: https://getcomposer.org/download/
2. قم بتثبيته على نظام Windows
3. تحقق من التثبيت باستخدام الأمر: `composer --version`

### 3. تثبيت Git
1. قم بتحميل Git من: https://git-scm.com/download/win
2. قم بتثبيته مع الخيارات الافتراضية
3. تحقق من التثبيت باستخدام الأمر: `git --version`

## خطوات تهيئة المشروع

بعد تثبيت المتطلبات الأساسية، اتبع الخطوات التالية:

### الخطوة 1: إنشاء قاعدة البيانات
1. افتح phpMyAdmin من XAMPP (http://localhost/phpmyadmin)
2. أنشئ قاعدة بيانات جديدة باسم `todo_app`
3. أو استخدم سطر الأوامر:
   ```bash
   mysql -u root -p
   CREATE DATABASE todo_app;
   ```

### الخطوة 2: إنشاء مشروع Laravel
```bash
composer create-project --prefer-dist laravel/laravel laravel-app
cd laravel-app
```

### الخطوة 3: تهيئة ملف البيئة
```bash
cp .env.example .env
# قم بتعديل ملف .env بإعدادات MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=todo_app
# DB_USERNAME=root
# DB_PASSWORD= (اتركه فارغاً إذا لم يكن هناك كلمة مرور)
```

### الخطوة 4: توليد مفتاح التطبيق
```bash
php artisan key:generate
```

### الخطوة 5: تهيئة Git
```bash
git init
git add .
git commit -m "feat: Initial setup - Laravel project, MySQL, Git"
git checkout -b 002-todo-app-mvp
```

## التحقق من الإعداد

اختبر الإعداد باستخدام:
```bash
php artisan serve
```
ثم افتح المتصفح على http://localhost:8000

إذا ظهرت صفحة ترحيب Laravel، فإن الإعداد ناجح.

## المهام التالية

بعد تهيئة البيئة، يمكنك متابعة تنفيذ المهام من ملف `specs\002-todo-app-mvp\tasks.md` بدءاً من المرحلة الثانية (Phase 2).