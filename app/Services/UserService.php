<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    public function __construct(private UserRepositoryInterface $repository = new UserRepository())
    {
    }

    public function validate(array $data, ?int $excludeId = null): array
    {
        $errors = [];

        if (trim($data['name'] ?? '') === '') {
            $errors['name'] = 'Nama wajib diisi.';
        }

        $email = trim($data['email'] ?? '');
        if ($email === '') {
            $errors['email'] = 'Email wajib diisi.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid.';
        } else {
            $existing = $this->repository->findByEmail($email);
            if ($existing !== null && (int) $existing['id'] !== $excludeId) {
                $errors['email'] = 'Email sudah digunakan.';
            }
        }

        if (!in_array($data['role'] ?? '', ['Admin', 'Member'], true)) {
            $errors['role'] = 'Role harus Admin atau Member.';
        }

        if ($excludeId === null) {
            if (empty($data['password'])) {
                $errors['password'] = 'Password wajib diisi.';
            } elseif (strlen($data['password']) < 8) {
                $errors['password'] = 'Password minimal 8 karakter.';
            }
        }

        return $errors;
    }

    public function create(array $data, int $userId): array
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $id = $this->repository->create($data, $userId);
        return ['success' => true, 'id' => $id];
    }

    public function update(int $id, array $data, int $userId): array
    {
        $errors = $this->validate($data, $id);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $this->repository->update($id, $data, $userId);
        return ['success' => true];
    }

    public function setActive(int $id, bool $isActive, int $userId): array
    {
        $this->repository->setActive($id, $isActive, $userId);
        return ['success' => true];
    }

    public function resetPassword(int $id, string $password, int $userId): array
    {
        if (trim($password) === '') {
            return ['success' => false, 'errors' => ['password' => 'Password wajib diisi.']];
        }

        if (strlen($password) < 8) {
            return ['success' => false, 'errors' => ['password' => 'Password minimal 8 karakter.']];
        }

        if ($this->repository->findById($id) === null) {
            return ['success' => false, 'message' => 'User tidak ditemukan.'];
        }

        $this->repository->resetPassword($id, password_hash($password, PASSWORD_DEFAULT), $userId);
        return ['success' => true];
    }

}
