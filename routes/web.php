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
use App\Models\Prediction;
use App\Models\Questionnaire;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner');
Route::post('/scanner/predict', [ScannerController::class, 'predict'])->name('scanner.predict');
Route::get('/camera', [CameraController::class, 'index'])->name('camera');
Route::post('/camera/predict', [CameraController::class, 'predict'])->name('camera.predict');
Route::get('/result/{prediction}', [ResultController::class, 'show'])->name('result');

// Questionnaire Route
Route::get('/questionnaire/{prediction}', function(Prediction $prediction) {
    return view('questionnaire', compact('prediction'));
})->name('questionnaire');

Route::post('/questionnaire/{prediction}', function(Request $request, Prediction $prediction) {
    $validated = $request->validate([
        'q1' => 'required|in:iya,tidak',
        'q2' => 'required|integer|min:1|max:5',
        'q3' => 'required|in:iya,tidak,tidak_tahu',
        'expected_skin' => 'nullable|required_if:q3,tidak|string|max:255',
        'q4' => 'required|in:iya,tidak',
        'q5' => 'required|in:iya,tidak',
        'q6' => 'required|in:iya,tidak',
        'q7' => 'required|in:iya,tidak',
        'consent' => 'accepted',
    ]);

    Questionnaire::updateOrCreate(
        ['result_id' => $prediction->id],
        [
            'q1_is_smooth' => $validated['q1'] === 'iya',
            'q2_rating' => (int) $validated['q2'],
            'q3_match_status' => $validated['q3'],
            'expected_skin' => $validated['q3'] === 'tidak' ? $validated['expected_skin'] : null,
            'q4_has_used_recommended_product' => $validated['q4'] === 'iya',
            'q5_ingredient_info_clear' => $validated['q5'] === 'iya',
            'q6_helpful_for_new_product' => $validated['q6'] === 'iya',
            'q7_would_click_buy_button' => $validated['q7'] === 'iya',
            'consent' => true,
            'submitted_at' => now(),
        ]
    );
    
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json(['success' => true]);
    }
    
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
