<?php

use App\User\Repositories\Contracts\UserRepositoryInterface;
use App\User\Services\UserService;
use App\Models\User;
use Symfony\Component\Uid\Ulid;

beforeEach(function () {
    $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
    $this->userService = new UserService($this->userRepository);
});

it('creates a user correctly', function () {
    $userData = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password123'];

    $this->userRepository->shouldReceive('createUser')
        ->once()
        ->with(Mockery::on(function ($arg) use ($userData) {
            return $arg === $userData;
        }))
        ->andReturn(new User($userData));


    $user = $this->userService->createUser($userData);


    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toEqual('John Doe');
});

it('fetches a user by ID correctly', function () {
    $userId = Ulid::generate();
    $expectedUser = new User(['id' => $userId, 'name' => 'John Doe', 'email' => 'john@example.com']);

    $this->userRepository->shouldReceive('getUserById')
        ->once()
        ->with($userId)
        ->andReturn($expectedUser);

    $user = $this->userService->getUserById($userId);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->id)->toEqual($userId);
    expect($user->name)->toEqual('John Doe');
});


it('updates a user correctly', function () {
    $userId = Ulid::generate();
    $userData = ['name' => 'John Doe Updated', 'email' => 'john_updated@example.com'];
    $user = new User(['id' => $userId, 'name' => 'John Doe', 'email' => 'john@example.com']);

    $this->userRepository->shouldReceive('updateUser')
        ->once()
        ->withArgs([$userId, $userData])
        ->andReturn(true);

    $result = $this->userService->updateUser($userId, $userData);

    expect($result)->toBeTrue();
});

it('deletes a user correctly', function () {
    $userId = Ulid::generate();

    $this->userRepository->shouldReceive('deleteUser')
        ->once()
        ->with($userId)
        ->andReturn(true);

    $result = $this->userService->deleteUser($userId);

    expect($result)->toBeTrue();
});
