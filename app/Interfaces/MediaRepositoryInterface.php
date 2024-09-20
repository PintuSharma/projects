<?php

namespace App\Interfaces;

interface MediaRepositoryInterface
{
    public function upload($file, $collectionName);
    public function delete($mediaId);
    public function find($mediaId);
    public function getAll($collectionName);
}
