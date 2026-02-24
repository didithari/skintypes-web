<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SkinPrediction;
use Illuminate\Support\Facades\Http;

class ScannerController extends Controller
{
    public function index()
    {
        return view('scanner');
    }

    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        try {
            // 1️⃣ Simpan gambar
            $path = $request->file('image')->store('skins', 'public');

            // 2️⃣ Kirim ke Flask API
            $response = Http::timeout(30)->attach(
                'image',
                file_get_contents(storage_path("app/public/$path")),
                $request->file('image')->getClientOriginalName()
            )->post('http://127.0.0.1:5000/predict');

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'AI service error'
                ], 500);
            }

            $result = $response->json();

            $label = $result['label'];
            $confidence = $result['confidence'];

            // 3️⃣ Simpan ke database
            $data = SkinPrediction::create([
                'image_path' => $path,
                'label' => $label,
                'confidence' => $confidence,
            ]);

            // 4️⃣ Return response bersih
            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
