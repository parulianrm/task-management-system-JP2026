<?php

use PHPUnit\Framework\TestCase;
use App\Services\ProjectService;
use App\Repositories\ProjectRepository;

class ProjectServiceTest extends TestCase
{
    public function test_create_rejects_empty_name(): void
    {
        $repository = $this->createMock(ProjectRepository::class);
        $service = new ProjectService($repository);

        $result = $service->create([
            'name' => '',
            'start_date' => '2026-01-01',
            'target_date' => '2026-02-01',
        ], 1);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('name', $result['errors']);
    }

    public function test_create_rejects_target_date_before_start_date(): void
    {
        $repository = $this->createMock(ProjectRepository::class);
        $service = new ProjectService($repository);

        $result = $service->create([
            'name' => 'Project A',
            'start_date' => '2026-03-01',
            'target_date' => '2026-01-01',
        ], 1);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('target_date', $result['errors']);
    }

    public function test_archive_rejected_when_tasks_incomplete(): void
    {
        $repository = $this->createMock(ProjectRepository::class);
        $repository->method('countIncompleteTasks')->willReturn(3);

        $service = new ProjectService($repository);
        $result = $service->archive(1, 1);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('belum selesai', $result['message']);
    }

    public function test_archive_succeeds_when_all_tasks_done(): void
    {
        $repository = $this->createMock(ProjectRepository::class);
        $repository->method('countIncompleteTasks')->willReturn(0);
        $repository->expects($this->once())->method('archive');

        $service = new ProjectService($repository);
        $result = $service->archive(1, 1);

        $this->assertTrue($result['success']);
    }
}