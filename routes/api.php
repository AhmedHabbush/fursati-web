<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\FAQController;
use App\Http\Controllers\Api\PolicyController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('ar/api')->group(function(){

    // Job-Seeker Endpoints :contentReference[oaicite:0]{index=0}
    Route::prefix('job-seeker')->group(function(){
        Route::get('all-jobs',           [JobController::class,'index']);
        Route::get('job-details/{id}',   [JobController::class,'show']);
        Route::post('jobs/{id}/mark-favorite', [JobController::class,'toggleFavorite']);
        Route::get('favorite-jobs',      [JobController::class,'favoriteJobs']);
        Route::post('jobs/applied/{id}', [JobController::class,'apply']);
    });

    // Companies for filter :contentReference[oaicite:1]{index=1}
    Route::get('all-companies', [CompanyController::class,'all']);

    // FAQs :contentReference[oaicite:2]{index=2}
    Route::get('faqs',        [FAQController::class,'index']);
    Route::get('faqs/{id}',   [FAQController::class,'show']);

    // Policies :contentReference[oaicite:3]{index=3}
    Route::get('policies',    [PolicyController::class,'index']);
});
