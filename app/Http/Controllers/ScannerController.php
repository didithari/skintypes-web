<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;
use App\Models\SkinType;
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
            
            // Log response untuk debugging
            \Log::info('Flask API Response (Scanner):', ['response' => $result]);

            $resolved = $this->resolveApiSkinType($result);

            if ($resolved === null) {
                \Log::error('Failed to resolve skin type (Scanner)', ['response' => $result]);
                return response()->json([
                    'error' => 'Response AI tidak valid. Format: ' . json_encode($result)
                ], 500);
            }

            $skinType = SkinType::where('api_id', $resolved['api_id'])->first();

            if (!$skinType) {
                return response()->json([
                    'error' => 'Skin type API belum tersedia di database. Jalankan seeder terlebih dahulu.'
                ], 500);
            }

            // 3️⃣ Simpan ke database
            $data = Prediction::create([
                'skin_type_id' => $skinType->id,
                'image_path' => $path,
                'confidence' => $resolved['confidence'],
                'predicted_at' => now(),
            ]);

            // 4️⃣ Redirect ke halaman hasil
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'skinTypeId' => $resolved['api_id'],
                    'skinType' => $skinType->name,
                    'redirectUrl' => route('result', $data->id)
                ]);
            }

            return redirect()->route('result', $data->id);

        } catch (\Exception $e) {
            \Log::error('Scanner Prediction Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function resolveApiSkinType(array $result): ?array
    {
        $apiId = null;

        foreach (['id', 'class_id', 'skin_type_id', 'label_id'] as $key) {
            if (array_key_exists($key, $result) && is_numeric($result[$key])) {
                $apiId = (int) $result[$key];
                break;
            }
        }

        if ($apiId === null && array_key_exists('label', $result)) {
            $apiId = SkinType::apiIdFromName((string) $result['label']);
        }

        if ($apiId === null && isset($result['prediction'])) {
            // Prediction sebagai array [0.8, 0.1, 0.1]
            if (is_array($result['prediction']) && count($result['prediction']) >= 3) {
                $maxIndex = array_keys($result['prediction'], max($result['prediction']))[0] ?? null;
                if ($maxIndex !== null && is_numeric($maxIndex)) {
                    $apiId = (int) $maxIndex;
                }
            }
            // Prediction sebagai single numeric (0, 1, 2)
            elseif (is_numeric($result['prediction'])) {
                $apiId = (int) $result['prediction'];
            }
        }

        if ($apiId === null || !array_key_exists($apiId, SkinType::API_ID_TO_NAME)) {
            return null;
        }

        $confidence = null;

        if (isset($result['confidence']) && is_numeric($result['confidence'])) {
            $confidence = (float) $result['confidence'];
        } elseif (isset($result['prediction']) && is_array($result['prediction']) && isset($result['prediction'][$apiId]) && is_numeric($result['prediction'][$apiId])) {
            $confidence = (float) $result['prediction'][$apiId];
        }

        return [
            'api_id' => $apiId,
            'name' => SkinType::API_ID_TO_NAME[$apiId],
            'confidence' => $confidence,
        ];
    }
}
