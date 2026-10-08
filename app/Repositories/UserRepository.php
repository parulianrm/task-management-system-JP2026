<?php

namespace App\Repositories;

use App\Core\Database;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findAll(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT id, name, email, role, is_active FROM users ORDER BY name ASC'
        );
        return $stmt->fetchAll();
    }

    public function findActiveusers(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT id, name FROM users WHERE is_active = TRUE ORDER BY name ASC'
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id, name, email, role, is_active FROM users WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id, name, email, role, is_active FROM users WHERE email = :email'
        );
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(array $data, int $updatedBy): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO users (name, email, password, role, is_active, updated_by)
             VALUES (:name, :email, :password, :role, :is_active, :updated_by)'
        );
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'Member',
            'is_active' => ($data['is_active'] ?? true) ? 1 : 0,
            'updated_by' => $updatedBy,
        ]);

        return (int) Database::getConnection()->lastInsertId();
    }

    public function update(int $id, array $data, int $updatedBy): void
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE users SET name = :name, email = :email, role = :role, updated_by = :updated_by
             WHERE id = :id'
        );
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'] ?? 'Member',
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }

    public function setActive(int $id, bool $isActive, int $updatedBy): void
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE users SET is_active = :is_active, updated_by = :updated_by WHERE id = :id'
        );
        $stmt->execute([
            'is_active' => $isActive ? 1 : 0,
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }

    public function resetPassword(int $id, string $passwordHash, int $updatedBy): void
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE users SET password = :password, updated_by = :updated_by WHERE id = :id'
        );
        $stmt->execute([
            'password' => $passwordHash,
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }
}
