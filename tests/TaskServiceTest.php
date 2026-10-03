<?php

use PHPUnit\Framework\TestCase;
use App\Services\TaskService;
use App\Repositories\TaskRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;

class TaskServiceTest extends TestCase
{
    public function test_validate_rejects_due_date_outside_project_range(): void
    {
        $taskRepo = $this->createMock(TaskRepository::class);
        $projectRepo = $this->createMock(ProjectRepository::class);
        $userRepo = $this->createMock(UserRepository::class);

        $projectRepo->method('findById')->willReturn([
            'id' => 1,
            'status' => 'Active',
            'start_date' => '2026-01-01',
            'target_date' => '2026-01-31',
        ]);

        $service = new TaskService($taskRepo, $projectRepo, $userRepo);

        $errors = $service->validate([
            'title' => 'Test Task',
            'project_id' => 1,
            'due_date' => '2026-03-01',
        ]);

        $this->assertArrayHasKey('due_date', $errors);
    }

    public function test_validate_rejects_archived_project(): void
    {
        $taskRepo = $this->createMock(TaskRepository::class);
        $projectRepo = $this->createMock(ProjectRepository::class);
        $userRepo = $this->createMock(UserRepository::class);

        $projectRepo->method('findById')->willReturn([
            'id' => 1,
            'status' => 'Archived',
            'start_date' => '2026-01-01',
            'target_date' => '2026-01-31',
        ]);

        $service = new TaskService($taskRepo, $projectRepo, $userRepo);

        $errors = $service->validate([
            'title' => 'Test Task',
            'project_id' => 1,
            'due_date' => '2026-01-15',
        ]);

        $this->assertArrayHasKey('project_id', $errors);
    }

    public function test_updateStatus_rejects_when_member_not_owner(): void
    {
        $taskRepo = $this->createMock(TaskRepository::class);
        $projectRepo = $this->createMock(ProjectRepository::class);
        $userRepo = $this->createMock(UserRepository::class);

        $taskRepo->method('findById')->willReturn([
            'id' => 10,
            'assignee_id' => 5,
            'project_id' => 1,
        ]);

        $service = new TaskService($taskRepo, $projectRepo, $userRepo);

        $result = $service->updateStatus(10, 'Done', 99, 'Member');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('tidak berhak', $result['message']);
    }

    public function test_updateStatus_allows_owner_member(): void
    {
        $taskRepo = $this->createMock(TaskRepository::class);
        $projectRepo = $this->createMock(ProjectRepository::class);
        $userRepo = $this->createMock(UserRepository::class);

        $taskRepo->method('findById')->willReturn([
            'id' => 10,
            'assignee_id' => 5,
            'project_id' => 1,
        ]);
        $projectRepo->method('findById')->willReturn([
            'id' => 1,
            'status' => 'Active',
        ]);
        $taskRepo->expects($this->once())->method('updateStatus');

        $service = new TaskService($taskRepo, $projectRepo, $userRepo);

        $result = $service->updateStatus(10, 'Done', 5, 'Member');

        $this->assertTrue($result['success']);
    }
}
