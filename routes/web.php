<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\FavoriteController;
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

