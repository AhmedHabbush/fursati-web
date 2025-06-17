<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
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
Route::get('/', function() {
    return view('jobs.index'); // مؤقتاً
})->name('jobs.index');
Route::get('/jobs', [JobController::class, 'index'])
    ->name('jobs.index');
