<?php
// tests/Unit/ProjectControllerTest.php

use App\Project\Controllers\ProjectController;
use App\Project\Services\ProjectService;
use App\Models\Project;
use Illuminate\Http\Request;
use Symfony\Component\Uid\Ulid;
use App\Project\Validators\ProjectRequest;

beforeEach(function () {

    $this->service = Mockery::mock(ProjectService::class);

    $this->app->instance(ProjectService::class, $this->service);

    $this->controller = $this->app->make(ProjectController::class);
});

it('shows a project correctly', function () {
    $projectId = Ulid::generate();
    $project = new Project(['id' => $projectId, 'name' => 'Existing Project']);
    $this->service->shouldReceive('getProjectById')
        ->with($projectId)
        ->once()
        ->andReturn($project);

    $response = $this->controller->show($projectId);
   // $responseContent = $response->getContent();
    expect($response->resource->id)->toEqual($projectId);
    expect($response->resource->name)->toEqual('Existing Project');
});

it('creates a project correctly', function () {
    $request = new ProjectRequest(['name' => 'New Project', 'description' => 'Project description']);
    $project = new Project(['id' => 1, 'name' => 'New Project']);
    $this->service->shouldReceive('createProject')
        ->with($request->all())
        ->once()
        ->andReturn($project);

    $response = $this->controller->store($request);

    expect($response->resource->id)->toEqual(1);
    expect($response->resource->name)->toEqual('New Project');
});

it('deletes a project correctly', function () {

    $this->service->shouldReceive('deleteProject')
        ->with(1)
        ->once()
        ->andReturn(true);

    $response = $this->controller->destroy(1);
    expect($response->status())->toEqual(204);
});

