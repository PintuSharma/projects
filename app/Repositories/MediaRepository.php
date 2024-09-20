<?php

namespace App\Repositories;

use App\Models\Media;
use App\Interfaces\MediaRepositoryInterface;

class MediaRepository implements MediaRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index(){
        return Media::paginate();
    }

    public function store(array $data){
       return Media::create($data);
    }

    public function update(array $data,$id){
       return Media::whereId($id)->update($data);
    }
    
    public function delete($id){
       Media::destroy($id);
    }
}
