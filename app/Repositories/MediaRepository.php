<?php

namespace App\Repositories;

use App\Models\Media;
use App\Interfaces\MediaRepositoryInterface;

class MediaRepository implements MediaRepositoryInterface
{
    
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        //
    }
   
    /**
     * Summary of store
     * @param array $data
     * @return \App\Models\Media
     */
    public function store(array $data): Media{
       return Media::create($data);
    }
    
    /**
     * Summary of delete
     * @param mixed $id
     * @return void
     */
    public function delete($id){
       Media::destroy($id);
    }
}
