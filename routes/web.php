<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\LoginController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner');
Route::post('/scanner/predict', [ScannerController::class, 'predict'])->name('scanner.predict');
Route::get('/camera', [CameraController::class, 'index'])->name('camera');
Route::post('/camera/predict', [CameraController::class, 'predict'])->name('camera.predict');

// Login Routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show');
Route::post('/login', [LoginController::class, 'handleLogin'])->name('login.handle');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
