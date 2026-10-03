<?php

namespace App\Repositories\Contracts;

interface ProjectRepositoryInterface
{
    public function findAll(array $filters = []): array;
    public function findAllForMember(int $userId, array $filters = []): array;
    public function findById(int $id): ?array;
    public function countTasks(int $projectId): int;
    public function countIncompleteTasks(int $projectId): int;
    public function create(array $data, int $updatedBy): int;
    public function update(int $id, array $data, int $updatedBy): void;
    public function setStatus(int $id, string $status, int $updatedBy): void;
    public function archive(int $id, int $updatedBy): void;
    public function isAssignedToMember(int $projectId, int $userId): bool;

}
