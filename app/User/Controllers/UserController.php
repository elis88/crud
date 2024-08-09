<?php

namespace App\User\Controllers;

use App\Http\Controllers\Controller;

use App\User\Validators\UserRequest;
use App\User\Services\UserService;
use App\User\Resources\UserResource;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return new UserResource($user);
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->createUser($request->all());
        return new UserResource($user);
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->userService->updateUser($id, $request->all());
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return response()->json(null, 204);
    }
}
