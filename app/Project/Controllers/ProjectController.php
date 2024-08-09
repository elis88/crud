<?php

namespace App\Project\Controllers;

use App\Http\Controllers\Controller;
use App\Project\Services\ProjectService;
use App\Project\Resources\ProjectResource;
use App\Project\Validators\ProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectService->getAllProjects();
        return ProjectResource::collection($projects);
    }

    public function show($id)
    {
        $project = $this->projectService->getProjectById($id);
        return new ProjectResource($project);
    }

    public function store(ProjectRequest $request)
    {
        $project = $this->projectService->createProject($request->all());
        return new ProjectResource($project);
    }

    public function update(ProjectRequest $request, $id)
    {
        $project = $this->projectService->updateProject($id, $request->all());
        return new ProjectResource($project);
    }

    public function destroy($id)
    {
        $this->projectService->deleteProject($id);
        return response()->json(null, 204);
    }
}
