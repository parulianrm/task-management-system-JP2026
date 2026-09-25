<?php

namespace App\Repositories;

use App\Core\Database;

class UserRepository
{
    public function findAll(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT id, name, email, role, is_active FROM USERS ORDER BY name ASC'
        );
        return $stmt->fetchAll();
    }

    public function findActiveUsers(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT id, name FROM USERS WHERE is_active = TRUE ORDER BY name ASC'
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id, name, email, role, is_active FROM USERS WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id, name, email, role, is_active FROM USERS WHERE email = :email'
        );
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(array $data, int $updatedBy): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO USERS (name, email, password_hash, role, is_active, updated_by)
             VALUES (:name, :email, :password_hash, :role, :is_active, :updated_by)'
        );
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => $data['password_hash'],
            'role' => $data['role'] ?? 'Member',
            'is_active' => $data['is_active'] ?? true,
            'updated_by' => $updatedBy,
        ]);

        return (int) Database::getConnection()->lastInsertId();
    }

    public function update(int $id, array $data, int $updatedBy): void
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE USERS SET name = :name, email = :email, role = :role, updated_by = :updated_by
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
            'UPDATE USERS SET is_active = :is_active, updated_by = :updated_by WHERE id = :id'
        );
        $stmt->execute([
            'is_active' => $isActive,
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }
}
