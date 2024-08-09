<?php

namespace App\Project\Repositories\Contracts;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $attributes);
    public function update(Project $project, array $attributes);
    public function delete(Project $project);
}
