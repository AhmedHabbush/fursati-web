<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SettingsController;
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

// قائمة الأسئلة المتكررة
Route::get('/settings/faqs', [SettingsController::class, 'faqs'])
    ->name('settings.faqs');

// تفاصيل سؤال محدد
Route::get('/settings/faqs/{id}', [SettingsController::class, 'faqDetail'])
    ->name('settings.faq.detail');

// صفحة السياسات (Privacy Policy)
Route::get('/settings/policies', [SettingsController::class, 'policies'])
    ->name('settings.policies');
