<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('profile', [AuthController::class, 'profile']);
    Route::delete('profile/delete/{id}', [AuthController::class, 'destroy']); // Delete User (Not Complete)
});

// REST API sanctum
// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::apiResource('companies', CompanyController::class);
//     Route::apiResource('jobs', JobController::class);
// });

//REST API For Frontend
Route::group(['namespace' => 'api'], (function () {
    // Route::apiResource('companies', CompanyController::class);

    //Companies
    Route::get('companies/{id}', [CompanyController::class, 'show'])->name('api.companies.show');
    Route::get('companies', [CompanyController::class, 'index'])->name('api.companies.index');

    //Jobs
    Route::get('jobs/{id}', [JobController::class, 'show'])->name('api.jobs.show');
    Route::get('jobs', [JobController::class, 'index'])->name('api.jobs.index');
}));

Route::middleware(['auth:api'])->group(function () {
    //Applicant
    Route::post('register_job/{id}', [ApplicantController::class, 'register_job'])->name('api.applicant.register_job');
    Route::get('applicants/{id}', [ApplicantController::class, 'show'])->name('api.applicant.show');
    Route::get('applicants', [ApplicantController::class, 'index'])->name('api.applicant.index');
});
