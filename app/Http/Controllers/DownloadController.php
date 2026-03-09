<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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

        $tempDir = storage_path("app/temp_zip_" . uniqid());
        
        if (!mkdir($tempDir, 0777, true) && !is_dir($tempDir)) {
            return abort(500, "Could not create temporary directory");
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
            $skinTypePath = $tempDir . "/" . $skinTypeFolder;
            
            if (!is_dir($skinTypePath)) {
                mkdir($skinTypePath, 0777, true);
            }

            $filename = pathinfo($prediction->image_path, PATHINFO_FILENAME);
            $destFile = $skinTypePath . "/" . $prediction->id . "_" . $filename . ".jpg";
            
            copy($fullPath, $destFile);
        }

        $zipName = "predictions_" . now()->format("Ymd_His") . ".zip";
        $zipPath = storage_path("app/" . $zipName);
        
        $command = sprintf(
            "cd %s && zip -r %s .",
            escapeshellarg($tempDir),
            escapeshellarg($zipPath)
        );
        
        exec($command, $output, $returnCode);
        
        File::deleteDirectory($tempDir);

        if ($returnCode !== 0 || !file_exists($zipPath)) {
            return abort(500, "Could not create zip file. Return code: " . $returnCode);
        }

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }

    public function downloadAll()
    {
        $predictions = Prediction::with("skinType")->get();

        if ($predictions->isEmpty()) {
            return abort(404, "No predictions found");
        }

        $tempDir = storage_path("app/temp_zip_all_" . uniqid());
        
        if (!mkdir($tempDir, 0777, true) && !is_dir($tempDir)) {
            return abort(500, "Could not create temporary directory");
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
            $targetPath = $tempDir . "/" . $skinTypeFolder . "/" . $dateFolder;
            
            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0777, true);
            }

            $filename = pathinfo($prediction->image_path, PATHINFO_FILENAME);
            $destFile = $targetPath . "/" . $prediction->id . "_" . $filename . ".jpg";
            
            copy($fullPath, $destFile);
        }

        $zipName = "all_predictions_" . now()->format("Ymd_His") . ".zip";
        $zipPath = storage_path("app/" . $zipName);
        
        $command = sprintf(
            "cd %s && zip -r %s .",
            escapeshellarg($tempDir),
            escapeshellarg($zipPath)
        );
        
        exec($command, $output, $returnCode);
        
        File::deleteDirectory($tempDir);

        if ($returnCode !== 0 || !file_exists($zipPath)) {
            return abort(500, "Could not create zip file. Return code: " . $returnCode);
        }

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }
}
