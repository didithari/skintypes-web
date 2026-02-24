<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SkinPrediction;
use Illuminate\Support\Facades\Http;

class CameraController extends Controller
{
    public function index()
    {
        return view('camera');
    }

    public function predict(Request $request)
    {
        $request->validate([
            'photo' => 'required'
        ]);

        // Simpan foto dari camera
        $photo = $request->file('photo');
        $path = $photo->store('skins', 'public');

        try {
            // Kirim ke Flask API
            $response = Http::attach(
                'image',
                file_get_contents(storage_path("app/public/$path")),
                'photo.jpg'
            )->post('http://127.0.0.1:5000/predict');

            if ($response->successful()) {
                $prediction = $response->json()['prediction'];

                // Konversi ke label
                $label = $prediction > 0.5 ? 'Dry Skin' : 'Oily Skin';

                // Simpan ke database
                $data = SkinPrediction::create([
                    'image_path' => $path,
                    'prediction' => $prediction,
                    'result_label' => $label
                ]);

                return response()->json([
                    'success' => true,
                    'skinType' => $label,
                    'prediction' => $prediction,
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menganalisis gambar'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
