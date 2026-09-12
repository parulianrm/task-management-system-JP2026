<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Repositories\ProjectRepository;
use App\Services\ProjectService;
use App\Services\AuthorizationService;

session_start();
header('Content-Type: application/json');

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$service = new ProjectService();
$repository = new ProjectRepository();

try {
    switch ($method) {
        case 'GET':
            $projects = $_SESSION['role'] === 'Admin'
                ? $repository->findAll()
                : $repository->findAllForMember((int) $_SESSION['user_id']);
            echo json_encode(['success' => true, 'data' => $projects]);
            break;

        case 'POST':
            AuthorizationService::requireRole('Admin', isApi: true);

            $action = $input['action'] ?? 'create';

            if ($action === 'archive') {
                $result = $service->archive((int) $input['id'], (int) $_SESSION['user_id']);
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
