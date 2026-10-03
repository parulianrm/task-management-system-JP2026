<?php

namespace App\Repositories\Contracts;

interface TaskRepositoryInterface
{
    public function findAll(array $filters = []): array;
    public function countAll(array $filters = []): int;
    public function findByProject(int $projectId): array;
    public function findById(int $id): ?array;
    public function create(array $data, int $updatedBy): int;
    public function update(int $id, array $data, int $updatedBy): void;
    public function updateStatus(int $id, string $status, int $updatedBy): void;
}
