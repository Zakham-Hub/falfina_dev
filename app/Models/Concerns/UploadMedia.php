<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait UploadMedia {
    public function uploadMedia(UploadedFile $file, string $collection = 'default', string $disk = 'storage', ?int $resizeWidth = null, ?int $resizeHeight = null)
    {
        $modelName = class_basename($this);
        $folderPath = $disk === 'root'
            ? base_path("dashboard/uploads/{$modelName}")
            : "uploads/{$modelName}";

        if ($disk === 'root' && !file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
        $filePath = $folderPath . '/' . $fileName;
        if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'webp'])) {
            $image = Image::make($file);
            if ($resizeWidth && $resizeHeight) {
                $image->resize($resizeWidth, $resizeHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            if ($disk === 'root') {
                $image->save($filePath, 80);
            } else {
                Storage::disk($disk)->put($filePath, (string) $image->encode());
            }
        } else {
            if ($disk === 'root') {
                $file->move($folderPath, $fileName);
            } else {
                $filePath = $file->storeAs($folderPath, $fileName, $disk);
            }
        }
        return $this->media()->create([
            'collection_name' => $collection,
            'file_name' => $fileName,
            'disk' => $disk,
        ]);
    }

    public function deleteMedia(string $collection = 'default') {
        $media = $this->media()->where('collection_name', $collection)->latest()->first();

        if ($media) {
            $modelName = class_basename($this);
            $filePath = $media->disk === 'root'
                ? base_path("dashboard/uploads/{$modelName}/{$media->file_name}")
                : "uploads/{$modelName}/{$media->file_name}";
            if ($media->disk === 'root') {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            } else {
                Storage::disk($media->disk)->delete($filePath);
            }
            $media->delete();
        }
    }

    public function updateMedia(UploadedFile $file, string $collection = 'default', string $disk = 'storage', ?int $resizeWidth = null, ?int $resizeHeight = null)
    {
        $this->deleteMedia($collection);
        return $this->uploadMedia($file, $collection, $disk, $resizeWidth, $resizeHeight);
    }

    public function getMediaUrl(string $collection = 'default'): ?string {
        $media = $this->media()->where('collection_name', $collection)->latest()->first();
        if ($media) {
            $modelName = class_basename($this);
            $basePath = $media->disk === 'root'
                ? url("/media/{$modelName}/{$media->file_name}")
                : Storage::disk($media->disk)->url("uploads/{$modelName}/");
            return $basePath;
        }
        return null;
    }
}
