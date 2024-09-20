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

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $projects = Project::paginate(10); // Display 10 projects per page
            return ProjectResource::collection($projects)
                ->additional([
                    'meta' => [
                        'total' => $projects->total(),
                        'per_page' => $projects->perPage(),
                        'current_page' => $projects->currentPage(),
                        'last_page' => $projects->lastPage(),
                        'next_page_url' => $projects->nextPageUrl(),
                        'prev_page_url' => $projects->previousPageUrl(),
                    ],
                ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to fetch projects'], 500);
        }
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $project = Project::create($request->validated());
            DB::commit();
            return response()->json(new ProjectResource($project), 201);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        try {
            return response()->json(new ProjectResource($project), 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        DB::beginTransaction();
        try {
            $project->update($request->validated());
            DB::commit();
            return response()->json(new ProjectResource($project), 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        DB::beginTransaction();
        try {
            $project->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

    }
}
