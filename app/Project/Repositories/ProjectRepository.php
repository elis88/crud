<?php

namespace App\Project\Repositories;

use App\Models\Project;
use App\Project\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAll()
    {
        return Project::with('creator')->get();
    }

    public function findById($id)
    {
        return Project::with('creator')->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return Project::create($attributes);
    }

    public function update(Project $project, array $attributes)
    {
        $project->update($attributes);
        return $project;
    }

    public function delete(Project $project)
    {
        return $project->delete();
    }
}
