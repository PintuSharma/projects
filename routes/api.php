<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\MediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('projects', ProjectController::class);
Route::apiResource('media', MediaController::class,  ['only' => ['store', 'destroy']]);


