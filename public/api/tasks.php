<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Repositories\TaskRepository;
use App\Services\TaskService;
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
$service = new TaskService();
$repository = new TaskRepository();

try {
    switch ($method) {
        case 'GET':
            $filters = [
                'search' => $_GET['q'] ?? '',
                'project_id' => $_GET['project_id'] ?? '',
                'status' => $_GET['status'] ?? '',
                'priority' => $_GET['priority'] ?? '',
                'sort' => $_GET['sort'] ?? 'asc',
                'limit' => (int) ($_GET['limit'] ?? 10),
                'offset' => (int) ($_GET['offset'] ?? 0),
            ];

            if ($_SESSION['role'] !== 'Admin') {
                $filters['assignee_id'] = $_SESSION['user_id'];
            }

            $tasks = $repository->findAll($filters);
            $total = $repository->countAll($filters);

            echo json_encode(['success' => true, 'data' => $tasks, 'total' => $total]);
            break;

        case 'POST':
            $action = $input['action'] ?? null;

            if ($action === 'update_status') {
                $result = $service->updateStatus(
                    (int) $input['id'],
                    $input['status'],
                    (int) $_SESSION['user_id'],
                    $_SESSION['role']
                );
            } else {
                AuthorizationService::requireRole('Admin', isApi: true);

                $result = !empty($input['id'])
                    ? $service->update((int) $input['id'], $input, (int) $_SESSION['user_id'])
                    : $service->create($input, (int) $_SESSION['user_id']);
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
