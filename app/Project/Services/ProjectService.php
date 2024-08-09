<?php

namespace App\Project\Services;

use App\Project\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjects()
    {
        return $this->projectRepository->getAll();
    }

    public function getProjectById($id)
    {
        return $this->projectRepository->findById($id);
    }

    public function createProject(array $data)
    {
        return $this->projectRepository->create($data);
    }

    public function updateProject($id, array $data)
    {
        $project = $this->projectRepository->findById($id);
        return $this->projectRepository->update($project, $data);
    }

    public function deleteProject($id)
    {
        $project = $this->projectRepository->findById($id);
        return $this->projectRepository->delete($project);
    }
}
