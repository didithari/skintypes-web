<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DownloadController extends Controller
{
    public function downloadImage(Prediction $prediction)
    {
        if (!$prediction->image_path) {
            return abort(404, "Image path not found");
        }

        $fullPath = storage_path("app/public/{$prediction->image_path}");
        
        if (!file_exists($fullPath)) {
            return abort(404, "File not found");
        }

        $skinTypeName = strtolower(str_replace(" ", "-", $prediction->skinType->name ?? "unknown"));
        $filename = $skinTypeName . "_" . $prediction->id . "_" . now()->format("Ymd_His") . ".jpg";

        return response()->download($fullPath, $filename);
    }

    public function downloadMultiple(Request $request)
    {
        $predictionIds = $request->input("ids", []);

        if (empty($predictionIds)) {
            return abort(400, "No predictions selected");
        }

        $predictions = Prediction::whereIn("id", $predictionIds)->with("skinType")->get();

        if ($predictions->isEmpty()) {
            return abort(404, "Predictions not found");
        }

        $tempZip = storage_path("app/temp_download_" . uniqid() . ".zip");
        $zip = new ZipArchive;

        if ($zip->open($tempZip, ZipArchive::CREATE) !== TRUE) {
            return abort(500, "Could not create zip file");
        }

        foreach ($predictions as $prediction) {
            if (!$prediction->image_path) {
                continue;
            }

            $fullPath = storage_path("app/public/{$prediction->image_path}");
            
            if (!file_exists($fullPath)) {
                continue;
            }

            $skinTypeFolder = strtolower(str_replace(" ", "-", $prediction->skinType->name ?? "unknown"));
            $filename = pathinfo($prediction->image_path, PATHINFO_FILENAME);
            $arcPath = "{$skinTypeFolder}/{$prediction->id}_{$filename}.jpg";

            $zip->addFile($fullPath, $arcPath);
        }

        $zip->close();

        $downloadName = "predictions_" . now()->format("Ymd_His") . ".zip";
        
        return response()->download($tempZip, $downloadName)->deleteFileAfterSend(true);
    }

    public function downloadAll()
    {
        $predictions = Prediction::with("skinType")->get();

        if ($predictions->isEmpty()) {
            return abort(404, "No predictions found");
        }

        $tempZip = storage_path("app/temp_download_all_" . uniqid() . ".zip");
        $zip = new ZipArchive;

        if ($zip->open($tempZip, ZipArchive::CREATE) !== TRUE) {
            return abort(500, "Could not create zip file");
        }

        foreach ($predictions as $prediction) {
            if (!$prediction->image_path) {
                continue;
            }

            $fullPath = storage_path("app/public/{$prediction->image_path}");
            
            if (!file_exists($fullPath)) {
                continue;
            }

            $skinTypeFolder = strtolower(str_replace(" ", "-", $prediction->skinType->name ?? "unknown"));
            $dateFolder = optional($prediction->predicted_at ?? $prediction->created_at)->format("Y-m-d");
            $filename = pathinfo($prediction->image_path, PATHINFO_FILENAME);
            $arcPath = "{$skinTypeFolder}/{$dateFolder}/{$prediction->id}_{$filename}.jpg";

            $zip->addFile($fullPath, $arcPath);
        }

        $zip->close();

        $downloadName = "all_predictions_" . now()->format("Ymd_His") . ".zip";
        
        return response()->download($tempZip, $downloadName)->deleteFileAfterSend(true);
    }
}
