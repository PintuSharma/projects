<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory,HasUlids,SoftDeletes;

    
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
    ];


    /**
     * Summary of media
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media(){
        return $this->morphMany(Media::class, 'media');
    }

    /**
     * Summary of boot
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function($project) { 
             $project->media()->delete();
        }); 
    }
}
