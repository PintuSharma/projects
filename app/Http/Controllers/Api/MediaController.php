<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Interfaces\MediaRepositoryInterface;
use App\Models\Media;
use App\Services\ApiResponse;
use App\Services\MediaService;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{

    /**
     * Summary of projectRepository
     * @var MediaRepositoryInterface
     */
    private MediaRepositoryInterface $mediaRepository;

    /**
     * Summary of mediaService
     * @var MediaService
     */
    protected MediaService $mediaService;

    /**
     * Summary of __construct
     * @param \App\Interfaces\ProjectRepositoryInterface $projectRepository
     * @param \App\Services\MediaService $mediaService
     */
    public function __construct(MediaRepositoryInterface $mediaRepository, MediaService $mediaService)
    {
        $this->mediaRepository = $mediaRepository;
        $this->mediaService = $mediaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }


    
    /**
     * Summary of store
     * @param \App\Http\Requests\StoreProjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->store($request->except('files'));

            if ($request->has('files')) {
                $this->mediaService->upload($request->file('files'), $project);
            }

            DB::commit();
            return ApiResponse::sendResponse(new ProjectResource($project), 'Project created successfully.', Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return ApiResponse::rollback($ex);
        }

    }

    
    
    public function show(Project $project):
    {
       
    }

    
    public function update()
    {
       
    }

   
    /**
     * Summary of destroy
     * @param \App\Models\Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Media $media): JsonResponse
    {
        $this->mediaService->deleteMedia($media);
        return ApiResponse::sendResponse('Media Delete Successful', '', Response::HTTP_NO_CONTENT);
    }
}
