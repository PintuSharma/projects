<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory,HasUlids,SoftDeletes;
    
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'collection_name',
        'name',
        'file_name',
        'mime_type',
        'disk',
        'size',
        'order_column',
        'media_id',
        'media_type'
    ];


    /**
     * Summary of media
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function media()
    {
        return $this->morphTo();
    }

    /**
     * Summary of getUrlAttribute
     * @return string
     */
    public function getUrlAttribute(){
        $file_path = "{$this->collection_name}/{$this->media_id}/{$this->file_name}";
        return Storage::disk($this->disk)->url($file_path);
    }

}
