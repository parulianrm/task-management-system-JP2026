<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Services\AuthorizationService;

session_start();
header('Content-Type: application/json');

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

AuthorizationService::requireRole('Admin', isApi: true);

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$service = new UserService();
$repository = new UserRepository();

try {
    switch ($method) {
        case 'GET':
            echo json_encode(['success' => true, 'data' => $repository->findAll()]);
            break;

        case 'POST':
            $action = $input['action'] ?? null;

            if ($action === 'toggle_active') {
                $result = $service->setActive((int) $input['id'], (bool) $input['is_active'], (int) $_SESSION['user_id']);
            } elseif ($action === 'reset_password') {
                $result = $service->resetPassword((int) $input['id'], $input['password'] ?? '', (int) $_SESSION['user_id']);
            } elseif (!empty($input['id'])) {
                $result = $service->update((int) $input['id'], $input, (int) $_SESSION['user_id']);
            } else {
                $result = $service->create($input, (int) $_SESSION['user_id']);
            }

            http_response_code($result['success'] ? 200 : 422);
            echo json_encode($result);
            break;

        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan pada server.']);
}
