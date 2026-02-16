<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\CameraController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner');
Route::get('/camera', [CameraController::class, 'index'])->name('camera');
