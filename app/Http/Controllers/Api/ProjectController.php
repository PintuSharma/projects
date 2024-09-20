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
use App\Interfaces\ProjectRepositoryInterface;
use App\Services\ApiResponse;
use App\Services\MediaService;

class ProjectController extends Controller
{

    private ProjectRepositoryInterface $projectRepository;

    protected $mediaService;
    public function __construct(ProjectRepositoryInterface $projectRepository,MediaService $mediaService)
    {
        $this->projectRepository = $projectRepository;
        $this->mediaService = $mediaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = $this->projectRepository->index();

        return ApiResponse::sendResponse(ProjectResource::collection($data),'',200);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->store($request->only('name','description','price'));

            if($request->has('files')) {
                    $this->mediaService->upload($request->file('files'),$project);
            }

            DB::commit();
            return ApiResponse::sendResponse(new ProjectResource($project),'Project created successfully.',201);
        } catch (Exception $ex) {
            return ApiResponse::rollback($ex);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return ApiResponse::sendResponse(new ProjectResource($project),'',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->update($request->only('name','description','price'),$project);
            if($request->has('files')) {
                $this->mediaService->upload($request->file('files'),$project);
             }
            DB::commit();
            return ApiResponse::sendResponse(new ProjectResource($project),'Project updated successfully',200);

        } catch (Exception $ex) {
            return ApiResponse::rollback($ex);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return ApiResponse::sendResponse('Product Delete Successful','',204);           
    }
}
