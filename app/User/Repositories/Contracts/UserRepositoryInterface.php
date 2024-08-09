<?php

namespace App\User\Repositories\Contracts;
use App\Models\User;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getUserById($userId);
    public function createUser(array $userDetails);
    public function updateUser($userId, array $newDetails);
    public function deleteUser($userId);
}
