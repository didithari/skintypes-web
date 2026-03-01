<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SkinTypeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PredictionController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner');
Route::post('/scanner/predict', [ScannerController::class, 'predict'])->name('scanner.predict');
Route::get('/camera', [CameraController::class, 'index'])->name('camera');
Route::post('/camera/predict', [CameraController::class, 'predict'])->name('camera.predict');
Route::get('/result/{prediction}', [ResultController::class, 'show'])->name('result');

// Login Routes
Route::middleware('guest')->group(function () {
	Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
	Route::post('/login', [LoginController::class, 'handleLogin'])->name('login.handle');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
	Route::redirect('/', '/admin/dashboard');
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::resource('skin-types', SkinTypeController::class)->only(['index', 'edit', 'update']);
	Route::resource('products', ProductController::class)->except(['show']);
	Route::resource('predictions', PredictionController::class)->only(['index', 'edit', 'update', 'destroy']);
});
