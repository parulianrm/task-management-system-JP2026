<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use App\Middleware\AuthMiddleware;
use App\Services\AuthService;

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($uri === '/login' && $method === 'POST') {
        $authService = new AuthService();
        $result = $authService->attempt($_POST['email'] ?? '', $_POST['password'] ?? '');

        if($result['status'] === 'invalid') {
            header('Location: /login?error=invalid&email='. urldecode($_POST['email'] ?? ''));
            exit;
        }

        if($result['inactive']) {
            header('Location: /login?error=inactive&email='. urldecode($_POST['email'] ?? ''));
            exit;
        }

        $user = $result['user'];
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        header('Location: /dashboard');
        exit;
    }

    if ($uri === '/logout') {
        $_SESSION = [];
        session_destroy();
        header('Location: /login');
        exit;
    }

    switch (true) {
        case $uri === '/' || $uri === '/login':
            require __DIR__ . '/../views/auth/login.php';
            break;

        case $uri === '/dashboard':
            AuthMiddleware::requireLogin();
            $dashboardRepository = new \App\Repositories\DashboardRepository();

            $isAdmin = $_SESSION['role'] === 'Admin';
            $scopeUserId = $isAdmin ? null : (int) $_SESSION['user_id'];

            $activeProjects = $isAdmin ? $dashboardRepository->countActiveProjects() : null;
            $tasksByStatus = $dashboardRepository->countTasksByStatus($scopeUserId);
            $overdueCount = $dashboardRepository->countOverdueTasks($scopeUserId);
            $upcomingLimit = 5;
            $upcomingTasks = $dashboardRepository->findUpcomingTasks($scopeUserId, $upcomingLimit);
            require __DIR__ . '/../views/dashboard.php';
            break;

        case $uri === '/projects':
            AuthMiddleware::requireLogin();
            $repository = new \App\Repositories\ProjectRepository();
            $projectFilters = [
                'search' => $_GET['q'] ?? '',
                'status' => $_GET['status'] ?? '',
            ];
            $projects = $_SESSION['role'] === 'Admin'
                ? $repository->findAll($projectFilters)
                : $repository->findAllForMember((int) $_SESSION['user_id'], $projectFilters);
            require __DIR__ . '/../views/projects/projects.php';
            break;

        case $uri === '/projects/detail':
            AuthMiddleware::requireLogin();
            $repository = new \App\Repositories\ProjectRepository();
            $projectId = (int) ($_GET['id'] ?? 0);
            $project = $repository->findById($projectId);

            if ($project === null) {
                http_response_code(404);
                require __DIR__ . '/../views/errors/404.php';
                break;
            }

            if ($_SESSION['role'] !== 'Admin' && !$repository->isAssignedToMember($projectId, (int) $_SESSION['user_id'])) {
                http_response_code(403);
                require __DIR__ . '/../views/errors/403.php';
                break;
            }

            $taskRepository = new \App\Repositories\TaskRepository();
            $tasks = $taskRepository->findByProject($projectId);

            require __DIR__ . '/../views/projects/detail.php';
            break;

        case $uri === '/tasks':
            AuthMiddleware::requireLogin();
            $taskRepository = new \App\Repositories\TaskRepository();
            $projectRepository = new \App\Repositories\ProjectRepository();
            $userRepository = new \App\Repositories\UserRepository();

            $page = max(1, (int) ($_GET['page'] ?? 1));
            $allowedPerPage = [5, 10, 25, 50];
            $perPage = (int) ($_GET['per_page'] ?? 10);
            if (!in_array($perPage, $allowedPerPage, true)) {
                $perPage = 10;
            }

            $filters = [
                'search' => $_GET['q'] ?? '',
                'project_id' => $_GET['project_id'] ?? '',
                'status' => $_GET['status'] ?? '',
                'priority' => $_GET['priority'] ?? '',
                'sort' => $_GET['sort'] ?? 'asc',
                'limit' => $perPage,
                'offset' => ($page - 1) * $perPage,
            ];

            if ($_SESSION['role'] !== 'Admin') {
                $filters['assignee_id'] = (int) $_SESSION['user_id'];
            }

            $tasks = $taskRepository->findAll($filters);
            $totalTasks = $taskRepository->countAll($filters);
            $totalPages = max(1, (int) ceil($totalTasks / $perPage));

            $projects = $projectRepository->findAll();
            $activeUsers = $userRepository->findActiveUsers();

            require __DIR__ . '/../views/tasks/tasks.php';
            break;

        case $uri === '/users':
            AuthMiddleware::requireLogin();
            \App\Services\AuthorizationService::requireRole('Admin');
            $userRepository = new \App\Repositories\UserRepository();
            $users = $userRepository->findAll();
            require __DIR__ . '/../views/users/users.php';
            break;

        default:
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
    }
} catch (\Throwable $e) {
    http_response_code(500);
    require __DIR__ . '/../views/errors/500.php';
}
