<?php

namespace App\Repositories\Contracts;

interface DashboardRepositoryInterface
{
    public function countActiveProjects(): int;
    public function countTasksByStatus(?int $assigneeId = null): array;
    public function countOverdueTasks(?int $assigneeId = null): int;
    public function findUpcomingTasks(?int $assigneeId = null, int $limit = 5): array;
}
