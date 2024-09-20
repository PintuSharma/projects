<?php

namespace App\Interfaces;

use Illuminate\Http\UploadedFile;
use App\Models\Media;

interface MediaRepositoryInterface
{
    public function store(array $data);
    public function delete($id);
}
