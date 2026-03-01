<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;
use App\Models\SkinType;
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
                $result = $response->json();
                
                // Log response untuk debugging
                \Log::info('Flask API Response:', ['response' => $result]);

                $resolved = $this->resolveApiSkinType($result);

                if ($resolved === null) {
                    \Log::error('Failed to resolve skin type', ['response' => $result]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Response AI tidak valid. Format: ' . json_encode($result)
                    ], 500);
                }

                $skinType = SkinType::where('api_id', $resolved['api_id'])->first();

                if (!$skinType) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Skin type API belum tersedia di database. Jalankan seeder terlebih dahulu.'
                    ], 500);
                }

                $data = Prediction::create([
                    'skin_type_id' => $skinType->id,
                    'image_path' => $path,
                    'confidence' => $resolved['confidence'],
                    'predicted_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'skinTypeId' => $resolved['api_id'],
                    'skinType' => $skinType->name,
                    'prediction' => $resolved['confidence'],
                    'data' => $data,
                    'redirectUrl' => route('result', $data->id)
                ]);
            } else {
                \Log::error('Flask API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menganalisis gambar. Status: ' . $response->status()
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Camera Prediction Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
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
        } elseif (isset($result['prediction']) && is_numeric($result['prediction'])) {
            $confidence = (float) $result['prediction'];
        }

        return [
            'api_id' => $apiId,
            'name' => SkinType::API_ID_TO_NAME[$apiId],
            'confidence' => $confidence,
        ];
    }
}
