<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Media;
use App\Services\ApiResponse;
use App\Services\MediaService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\MediaResource;

class MediaController extends Controller
{

    /**
     * Summary of projectRepository
     * @var ProjectRepositoryInterface
     */
    private ProjectRepositoryInterface $projectRepository;

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
    public function __construct(ProjectRepositoryInterface $projectRepository, MediaService $mediaService)
    {
        $this->projectRepository = $projectRepository;
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
    public function store(StoreMediaRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->find($request->get("model_id"));
            $mediaCol = $this->mediaService->upload($request->file('files'), $project);
       
            DB::commit();
            return ApiResponse::sendResponse(MediaResource::collection($mediaCol), 'Media created successfully.', Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return ApiResponse::rollback($ex);
        }

    }

    
    
    public function show()
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
    public function destroy(Media $medium): JsonResponse
    {
        $this->mediaService->deleteMedia($medium);
        return ApiResponse::sendResponse('Media Delete Successful', '', Response::HTTP_NO_CONTENT);
    }
}
