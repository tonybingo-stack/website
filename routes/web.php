<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');



Route::resource('login', LoginController::class)->only(['destroy']);