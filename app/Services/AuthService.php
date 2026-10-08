<?php

namespace App\Services;

use App\Core\Database;

class AuthService
{
    public function attempt(string $email, string $password): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT id, name, email, password, role, is_active FROM users WHERE email = :email'
        );
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return ['status' => 'invalid'];
        }

        if (!$user['is_active']) {
            return ['status' => 'inactive'];
        }

        return ['status' => 'ok', 'user' => $user];
    }
}
