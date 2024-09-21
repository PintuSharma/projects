<?php

namespace App\Repositories;

use App\Models\Project;
use App\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        //
    }

    /**
     * Summary of index
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(){
        return Project::all();
    }

    /**
     * Summary of find
     * @param mixed $id
     * @return \App\Models\Project
     */
    public function find($id): Project{
        return Project::findOrFail($id);
    }

    /**
     * Summary of store
     * @param array $data
     * @return Project
     */
    public function store(array $data): Project{
       return Project::create($data);
    }

    /**
     * Summary of update
     * @param array $data
     * @param mixed $id
     * @return mixed
     */
    public function update(array $data,$id): mixed{
       return Project::whereId($id)->update($data);
    }
    
    /**
     * Summary of delete
     * @param mixed $id
     * @return void
     */
    public function delete($id){
       Project::destroy($id);
    }
}
