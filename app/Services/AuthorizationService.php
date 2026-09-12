<?php

namespace App\Services;

class AuthorizationService
{
    public static function requireRole(string $role, bool $isApi = false): void
    {
        if (($_SESSION['role'] ?? null) === $role) {
            return;
        }

        http_response_code(403);

        if ($isApi) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki akses untuk aksi ini.']);
        } else {
            require __DIR__ . '/../../views/errors/403.php';
        }

        exit;
    }
}
