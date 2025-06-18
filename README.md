# مشروع Fursati

هذا المشروع هو تطبيق ويب لإدارة وعرض الوظائف للمستخدمين الباحثين عن عمل، تم تنفيذه ضمن مساق التدريب الميداني.

## المزايا الرئيسية

* عرض قائمة الوظائف مع تفاصيل مثل: المسمى الوظيفي، الشركة، الراتب، سنوات الخبرة، وغيرها.
* نظام بحث متقدم مع خيارات فلترة (بحث بالكلمة المفتاحية، الدولة، مجال العمل).
* صفحة تفاصيل الوظيفة مع عرض كامل للمعلومات والمهارات المطلوبة.
* إمكانية حفظ الوظائف كمفضّلة (Bookmarks) بعد تسجيل الدخول.
* نظام التقديم على الوظائف عبر رفع ملفات أو فيديو (API متكامل).
* إعدادات للمستخدم تشمل:
  * إعدادات التنبيهات
  * عرض الأسئلة المتكررة (FAQs)
  * سياسات الخصوصية
  * نموذج المساعدة والتغذية الراجعة (Help & Feedback)
* صفحة الملف الشخصي للمستخدم وتسجيل الخروج.

## التقنيات المستخدمة

* **Backend**: Laravel 10
* **Frontend**: Blade + Tailwind CSS + Alpine.js
* **قاعدة البيانات**: MySQL
* **إدارة الحزم**: Composer, NPM/Vite
* **توثيق API**: Postman Collection (ملف `TestApp.postman_collection.json`)

## المتطلبات الأساسية

* PHP 8.1 أو أعلى
* Composer
* Node.js & NPM
* MySQL

## خطوات التثبيت والتشغيل

1. استنساخ المستودع:

   ```bash
   git clone https://github.com/username/fursati-web.git
   cd fursati-web
   ```

2. تثبيت الاعتمادات:

   ```bash
   composer install
   npm install
   ```

3. إعداد ملف البيئة:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   عدّل القيم في `.env`:

   ```ini
   APP_NAME=Fursati
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=fursati
   DB_USERNAME=root
   DB_PASSWORD=

   API_BASE_URL=http://127.0.0.1:8000
   ```

4. إنشاء الجداول وتشغيل الـ Seeders:

   ```bash
   php artisan migrate:fresh --seed
   ```

5. تشغيل الخادم المحلي:

   ```bash
   php artisan serve
   npm run dev
   ```

6. افتح المتصفح وزر: `http://127.0.0.1:8000`

## هيكلية المستودع

```plaintext
├── app/
│   ├── Http/Controllers/         # تحكم في المنطق والـ API
│   ├── Models/                   # نماذج البيانات (Job, Company،...)
│   └── ...
├── database/
│   ├── migrations/              # ملفات التهيئة للمخططات
│   └── seeders/                  # تعبئة البيانات الوهمية (Factories + Seeders)
├── resources/views/              # قوالب Blade للواجهات
├── routes/
│   ├── web.php                  # مسارات الويب
│   └── api.php                  # مسارات الـ API
├── public/                       # الأصول العامة (CSS, JS, Images)
├── .env.example
├── composer.json
├── package.json
└── README.md                    # هذا الملف
```
