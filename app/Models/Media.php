<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory,HasUlids;
    
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


    public function media()
    {
        return $this->morphTo();
    }

}
