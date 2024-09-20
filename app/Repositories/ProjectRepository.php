<?php

namespace App\Repository;

use App\Models\Project;
use App\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index(){
        return Project::paginate();
    }

    public function store(array $data){
       return Project::create($data);
    }

    public function update(array $data,$id){
       return Project::whereId($id)->update($data);
    }
    
    public function delete($id){
       Project::destroy($id);
    }
}
