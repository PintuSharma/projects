<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\MediaRepositoryInterface;

class MediaService
{

    /**
     * Create a new class instance.
     */

    private $mediaRepositoryInterface;
    public function __construct(MediaRepositoryInterface $mediaRepositoryInterface)
    {
        $this->mediaRepositoryInterface = $mediaRepositoryInterface;
    }

    public function upload($files, $model, $disk = 'public')
    {

        $files = is_array($files) ? $files : [$files];

        foreach ($files as $key => $file) {
            $collectionName = Str::snake(class_basename(get_class($model)));
            $uniqueFileName = uniqid() . '.' . $file->getClientOriginalExtension();

            Storage::disk($disk)->putFileAs("$collectionName/$model->id", $file, $uniqueFileName);

            $mediaLibrary[] =  $this->mediaRepositoryInterface->store([
                'media_type' => get_class($model),
                'media_id' => $model->id,
                'collection_name' => $collectionName,
                'name' => $file->getClientOriginalName(),
                'file_name' => $uniqueFileName,
                'mime_type' => $file->getMimeType(),
                'disk' => $disk,
                'size' => $file->getSize(),
                'order_column' => 1
            ]);
        }
        return $mediaLibrary;
    }

    public function deleteMedia(Media $media)
    {
        $filePath = "{$media->collection_name}/{$media->media_id}/{$media->file_name}";

        if (Storage::disk($media->disk)->exists($filePath)) {
            Storage::disk($media->disk)->delete($filePath);
        }

        return $media->delete();
    }
}
