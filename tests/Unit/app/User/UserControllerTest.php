<?php

use App\User\Controllers\UserController;
use App\User\Services\UserService;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Uid\Ulid;
use App\User\Validators\UserRequest;

beforeEach(function () {
    $this->userService = Mockery::mock(UserService::class);
    $this->controller = new UserController($this->userService);
});

it('shows a user correctly', function () {
    $userId = Ulid::generate();
    $user = new User(['id' => $userId, 'name' => 'John Doe']);
    $this->userService->shouldReceive('getUserById')
        ->with($userId)
        ->once()
        ->andReturn($user);

    $response = $this->controller->show($userId);

    expect($response)->toBeInstanceOf(JsonResource::class);
    expect($response->resource->id)->toEqual($userId);
    expect($response->resource->name)->toEqual('John Doe');
});

it('creates a user', function () {
    $data = ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'password' => 'secure'];
    $this->userService->shouldReceive('createUser')
        ->once()
        ->andReturn(new User($data));

    $response = $this->controller->store(new UserRequest($data));

    expect($response)->toBeInstanceOf(JsonResource::class);
    expect($response->resource->name)->toEqual('Jane Doe');
});

it('updates a user via controller', function () {
    $userId = 1;
    $userData = ['name' => 'John Doe Updated'];
    $user = new User($userData);

    $this->userService->shouldReceive('updateUser')
        ->with($userId, $userData)
        ->once()
        ->andReturn($user);

    $response = $this->controller->update(new UserRequest($userData), $userId);

    expect($response)->toBeInstanceOf(JsonResource::class);
    expect($response->resource->name)->toEqual('John Doe Updated');
});

it('deletes a user via controller', function () {
    $userId = 1;

    $this->userService->shouldReceive('deleteUser')
        ->with($userId)
        ->once()
        ->andReturn(true);

    $response = $this->controller->destroy($userId);

    expect($response->status())->toEqual(204);
});
