<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaService {
   
    public function upload($file,$disk,$collectionName, $model)
    {
   
        // Store the file

        Storage::disk($disk)->putFileAs($collectionName, $file, basename($file));

        // Create a media record
        $media = Media::create([
            'media_type' => get_class($model),
            'media_id' => $model->id,
            'collection_name' => $collectionName,
            'name' => $file->getClientOriginalName(),
            'file_name' => basename($file),
            'mime_type' => $file->getMimeType(),
            'disk' => $disk,
            'size' => $file->getSize(),
        ]);

        return $media;
    }

    public function delete(Media $media)
    {
        $filePath = "{$media->collection_name}/{$media->media_id}/{$media->file_name}";

        if (Storage::disk($media->disk)->exists($filePath)) {
            Storage::disk($media->disk)->delete($filePath);
        }

        return $media->delete();
    }



}