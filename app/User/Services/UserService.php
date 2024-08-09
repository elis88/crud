<?php

namespace App\User\Services;

use App\User\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getUserById($userId)
    {
        return $this->userRepository->getUserById($userId);
    }

    public function createUser(array $data)
    {
        return $this->userRepository->createUser($data);
    }

    public function updateUser($userId, array $data)
    {
        return $this->userRepository->updateUser($userId, $data);
    }

    public function deleteUser($userId)
    {
        return $this->userRepository->deleteUser($userId);
    }
}
