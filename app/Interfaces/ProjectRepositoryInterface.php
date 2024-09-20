<?php

namespace App\Interfaces;

interface ProjectRepositoryInterface
{
    public function index();
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);
}
