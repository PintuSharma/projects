<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\MediaRepositoryInterface;

class MediaService
{

   
    /**
     * Summary of mediaRepositoryInterface
     * @var 
     */
    private $mediaRepositoryInterface;

    /**
     * Summary of __construct
     * @param \App\Interfaces\MediaRepositoryInterface $mediaRepositoryInterface
     */
    public function __construct(MediaRepositoryInterface $mediaRepositoryInterface)
    {
        $this->mediaRepositoryInterface = $mediaRepositoryInterface;
    }

    /**
     * Summary of upload
     * @param mixed $files
     * @param mixed $model
     * @param mixed $disk
     * @return array
     */
    public function upload($files, $model, $disk = 'public')
    {

        $files = is_array($files) ? $files : [$files];

        foreach ($files as $key => $file) {
            $collectionName = $this->getCollectionName($model);
            $uniqueFileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $directory = $this->getMediaDirectory($model);

            Storage::disk($disk)->putFileAs($directory, $file, $uniqueFileName);

            $mediaLibrary[] =  $this->mediaRepositoryInterface->store([
                'media_type' => get_class($model),
                'media_id' => $model->id,
                'collection_name' => $collectionName,
                'name' => $file->getClientOriginalName(),
                'file_name' => $uniqueFileName,
                'mime_type' => $file->getMimeType(),
                'disk' => $disk,
                'size' => $file->getSize(),
            ]);
        }
        return $mediaLibrary;
    }

    /**
     * Summary of deleteMedia
     * @param \App\Models\Media $media
     * @return bool|null
     */
    public function deleteMedia(Media $media)
    {
        $filePath = "{$media->collection_name}/{$media->media_id}/{$media->file_name}";

        if (Storage::disk($media->disk)->exists($filePath)) {
            Storage::disk($media->disk)->delete($filePath);
        }

        return $this->mediaRepositoryInterface->delete($media->id);
    }


    /**
     * Summary of deleteMediaFiles
     * @param mixed $model
     * @param mixed $disk
     * @return void
     */
    public function deleteMediaFiles($model, $disk = 'public'){
        $directory = $this->getMediaDirectory($model);
        if (Storage::disk($disk)->exists($directory)) {
            Storage::disk($disk)->deleteDirectory($directory);
        }
    }

    /**
     * Summary of getCollectionName
     * @param mixed $model
     * @return string
     */
    private function getCollectionName($model){
        return Str::snake(class_basename(get_class($model)));
    }

    /**
     * Summary of getMediaDirectory
     * @param mixed $model
     * @return string
     */
    private function getMediaDirectory($model){
        $collection_name = $this->getCollectionName($model);
        return "$collection_name/$model->id";
    }
}
