<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\DownloadController;
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

// Questionnaire Route
Route::get('/questionnaire/{prediction}', function(\App\Models\Prediction $prediction) {
    return view('questionnaire', compact('prediction'));
})->name('questionnaire');

Route::post('/questionnaire/{prediction}', function(\Illuminate\Http\Request $request, \App\Models\Prediction $prediction) {
    // Process the data for the requested 1 question and additional expected_skin
    $prediction->update([
        'is_skin_type_correct' => $request->input('q3') === 'iya' ? true : false,
        'expected_skin' => $request->input('expected_skin'),
    ]);
    
    return redirect()->route('home')->with('message', 'Terima kasih atas partisipasi Anda dalam riset ini!');
})->name('questionnaire.submit');

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

// Download Routes
Route::get("/download/prediction/{prediction}", [DownloadController::class, "downloadImage"])->name("download.image");
Route::post("/download/multiple", [DownloadController::class, "downloadMultiple"])->name("download.multiple");
Route::get("/download/all", [DownloadController::class, "downloadAll"])->name("download.all");
