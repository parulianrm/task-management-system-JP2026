<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function findAll(): array;
    public function findActiveUsers(): array;
    public function findById(int $id): ?array;
    public function findByEmail(string $email): ?array;
    public function create(array $data, int $updatedBy): int;
    public function update(int $id, array $data, int $updatedBy): void;
    public function setActive(int $id, bool $isActive, int $updatedBy): void;
    public function resetPassword(int $id, string $passwordHash, int $updatedBy): void;
}
