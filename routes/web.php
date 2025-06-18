<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
// عرض نموذج تسجيل الدخول
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');
// معالجة تسجيل الدخول
Route::post('/login', [AuthController::class, 'login']);

// عرض نموذج التسجيل
Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register');
// معالجة التسجيل
Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [JobController::class, 'index'])
    ->name('jobs.index');
//----------------------------------------
Route::get('/jobs', [JobController::class, 'index']);

Route::get('/jobs/{id}', [JobController::class, 'show'])
    ->name('jobs.show');

// Toggle bookmark
Route::post('/jobs/{id}/favorite', [FavoriteController::class, 'toggle'])
    ->name('jobs.favorite.toggle');

// قائمة الوظائف المحفوظة
Route::get('/bookmarks', [FavoriteController::class, 'index'])
    ->name('bookmarks.index');

// فتح نموذج التقديم (في هذه الحالة ليس مساراً مباشراً بل عرض Modal عبر JS)
// لكن نحتاج مسار استقبال الطلب الفعلي:
Route::post('/jobs/{id}/apply', [App\Http\Controllers\JobController::class, 'apply'])
    ->name('jobs.apply');

// عرض تفاصيل الشركة
Route::get('/companies/{id}', [CompanyController::class, 'show'])
    ->name('companies.show');

// صفحة Take Action
Route::get('/companies/{id}/action', [CompanyController::class, 'action'])
    ->name('companies.action');

Route::get('/settings', [SettingsController::class, 'index'])
    ->name('settings.index');
// قائمة الأسئلة المتكررة
Route::get('/settings/faqs', [SettingsController::class, 'faqs'])
    ->name('settings.faqs');

// تفاصيل سؤال محدد
Route::get('/settings/faqs/{id}', [SettingsController::class, 'faqDetail'])
    ->name('settings.faq.detail');

// صفحة السياسات (Privacy Policy)
Route::get('/settings/policies', [SettingsController::class, 'policies'])
    ->name('settings.policies');

// عرض نموذج Help & Feedback
Route::get('/settings/help', [SettingsController::class, 'help'])
    ->name('settings.help');

// معالجة إرسال النموذج
Route::post('/settings/help', [SettingsController::class, 'submitHelp'])
    ->name('settings.help.submit');

// عرض اختيار اللغة
Route::get('/settings/language', [SettingsController::class, 'language'])
    ->name('settings.language');
Route::post('/settings/language', [SettingsController::class, 'setLanguage'])
    ->name('settings.language.set');

// عرض إعدادات التنبيهات
Route::get('/settings/notifications', [SettingsController::class, 'notifications'])
    ->name('settings.notifications');
Route::post('/settings/notifications', [SettingsController::class, 'setNotifications'])
    ->name('settings.notifications.set');

// صفحة الملف الشخصي
Route::get('/profile', [ProfileController::class, 'show'])
    ->name('profile.show');

// عملية تسجيل الخروج
Route::post('/logout', [ProfileController::class, 'logout'])
    ->name('logout');
