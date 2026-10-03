<?php

use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Repositories\UserRepository;

class UserServiceTest extends TestCase
{
    public function test_create_rejects_duplicate_email(): void
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('findByEmail')->willReturn(['id' => 1, 'email' => 'exist@test.com']);

        $service = new UserService($repository);

        $result = $service->create([
            'name' => 'New User',
            'email' => 'exist@test.com',
            'password' => 'password123',
            'role' => 'Member',
        ], 1);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('email', $result['errors']);
    }

    public function test_create_rejects_invalid_role(): void
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('findByEmail')->willReturn(null);

        $service = new UserService($repository);

        $result = $service->create([
            'name' => 'New User',
            'email' => 'new@test.com',
            'password' => 'password123',
            'role' => 'SuperAdmin',
        ], 1);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('role', $result['errors']);
    }

    public function test_create_succeeds_with_valid_data(): void
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('findByEmail')->willReturn(null);
        $repository->method('create')->willReturn(5);

        $service = new UserService($repository);

        $result = $service->create([
            'name' => 'New User',
            'email' => 'new@test.com',
            'password' => 'password123',
            'role' => 'Member',
        ], 1);

        $this->assertTrue($result['success']);
        $this->assertEquals(5, $result['id']);
    }
}
