<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserCompanyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Force redirect to login page
Route::redirect('/', '/login');

Route::post('company/register', [UserCompanyController::class, 'register'])->name('register.company.create');


Route::middleware(['auth:web', 'verified'])->group(function () {
    // Overview
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Job
    Route::get('jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::get('jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::get('jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::post('jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::patch('jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');

    //Candidate
    Route::get('candidate', [CandidateController::class, 'index'])->name('candidate.index');
    Route::get('candidate/interview/approve', [CandidateController::class, 'approve'])->name('candidate.candidates-approve-lists');
    Route::get('candidate/interview/finish', [CandidateController::class, 'finish'])->name('candidate.candidates-finish-lists');
    Route::get('candidate/{id}/setting/interview', [CandidateController::class, 'interview'])->name('candidate.date-interview-setting');
    Route::get('candidate/{id}', [CandidateController::class, 'edit'])->name('candidate.edit');
    Route::delete('candidate/{id}', [JobController::class, 'destroy'])->name('candidate.destroy');
});
