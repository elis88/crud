<?php

use App\Project\Services\ProjectService;
use App\Project\Repositories\Contracts\ProjectRepositoryInterface;
use App\Models\Project;

beforeEach(function () {
    $this->repository = Mockery::mock(ProjectRepositoryInterface::class);
    $this->service = new ProjectService($this->repository);
});

it('can retrieve a project by id', function () {
    $project = new Project(['id' => 1, 'name' => 'New Project']);
    $this->repository->shouldReceive('findById')
        ->with(1)
        ->once()
        ->andReturn($project);

    $result = $this->service->getProjectById(1);
    expect($result)->toBeInstanceOf(Project::class);
    expect($result->name)->toEqual('New Project');
});

it('can create a project', function () {
    $projectData = ['name' => 'New Project', 'description' => 'Project description'];
    $this->repository->shouldReceive('create')
        ->with($projectData)
        ->once()
        ->andReturn(new Project($projectData));

    $result = $this->service->createProject($projectData);
    expect($result)->toBeInstanceOf(Project::class);
    expect($result->name)->toEqual('New Project');
});

it('can delete a project', function () {
    $projectId = 1;
    $project = new Project(['id' => $projectId, 'name' => 'Project to Delete']);

    // Expectation for findById before deletion
    $this->repository->shouldReceive('findById')
        ->with($projectId)
        ->once()
        ->andReturn($project);

    // Expectation for delete method
    $this->repository->shouldReceive('delete')
        ->with($project)
        ->once()
        ->andReturn(true);

    $result = $this->service->deleteProject($projectId);
    expect($result)->toBeTrue();
});
