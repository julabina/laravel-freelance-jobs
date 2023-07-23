<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Mission\CreateController;
use App\Http\Controllers\Mission\FreelanceInteractController;
use App\Http\Controllers\Mission\ShowController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
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

Route::middleware(['auth', 'verified'])->get('/', [HomeController::class, 'show'])->name('dashboard');

Route::prefix('/mission')->as('mission.')->middleware(['auth'])->group(function () {
    Route::middleware('isClient')->get('/créer', [CreateController::class, 'showCreate'])->name('create');
    Route::middleware('isClient')->post('/create', [CreateController::class, 'store'])->name('store');
    Route::middleware('isFreelance')->get('/all', [ShowController::class, 'list'])->name('list');
    Route::middleware('isFreelance')->put('/like/{id}', [FreelanceInteractController::class, 'like'])->name('like');
    Route::middleware('isFreelance')->post('/proposal', [FreelanceInteractController::class, 'proposal'])->name('proposal');
    Route::get('/{id}', [ShowController::class, 'show'])->name('show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
