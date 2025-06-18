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
| Here is where you can register web routes for your application.
|
*/

// Authentication (login/register)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Public Routes
// Home → jobs listing
Route::get('/', [JobController::class, 'index'])->name('jobs.index');

Route::prefix('jobs')->group(function () {
    // list & detail share the same controller
    Route::get('/', [JobController::class, 'index']);
    Route::get('{id}', [JobController::class, 'show'])->name('jobs.show');
    Route::post('{id}/apply', [JobController::class, 'apply'])->name('jobs.apply');
});

Route::prefix('companies')->group(function () {
    Route::get('{id}', [CompanyController::class, 'show'])->name('companies.show');
    Route::get('{id}/action', [CompanyController::class, 'action'])->name('companies.action');
});

Route::prefix('settings')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('faqs', [SettingsController::class, 'faqs'])->name('settings.faqs');
    Route::get('faqs/{id}', [SettingsController::class, 'faqDetail'])->name('settings.faq.detail');
    Route::get('policies', [SettingsController::class, 'policies'])->name('settings.policies');
    Route::get('help', [SettingsController::class, 'help'])->name('settings.help');
    Route::post('help', [SettingsController::class, 'submitHelp'])->name('settings.help.submit');
    Route::get('language', [SettingsController::class, 'language'])->name('settings.language');
    Route::post('language', [SettingsController::class, 'setLanguage'])->name('settings.language.set');
    Route::get('notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');
    Route::post('notifications', [SettingsController::class, 'setNotifications'])->name('settings.notifications.set');
});

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {

    // Favorites / Bookmarks
    Route::get('/bookmarks', [FavoriteController::class, 'index'])->name('bookmarks.index');
    Route::post('jobs/{id}/favorite', [FavoriteController::class, 'toggle'])->name('jobs.favorite.toggle');

    // Profile & Logout
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
