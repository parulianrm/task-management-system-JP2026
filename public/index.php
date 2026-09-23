<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use App\Middleware\AuthMiddleware;
use App\Services\AuthService;

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/login' && $method === 'POST') {
    $authService = new AuthService();
    $result = $authService->attempt($_POST['email'] ?? '', $_POST['password'] ?? '');

    if ($result['status'] === 'invalid') {
        header('Location: /login?error=invalid');
        exit;
    }

    if ($result['status'] === 'inactive') {
        header('Location: /login?error=inactive');
        exit;
    }

    $user = $result['user'];
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
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
        require __DIR__ . '/../views/dashboard.php';
        break;

    case $uri === '/projects':
    AuthMiddleware::requireLogin();
    $repository = new \App\Repositories\ProjectRepository();
    $projects = $_SESSION['role'] === 'Admin'
        ? $repository->findAll()
        : $repository->findAllForMember((int) $_SESSION['user_id']);
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

    $taskRepository = new \App\Repositories\TaskRepository();
    $tasks = $taskRepository->findByProject($projectId);

    require __DIR__ . '/../views/projects/detail.php';
    break;


    case $uri === '/tasks':
        AuthMiddleware::requireLogin();
        $taskRepository = new \App\Repositories\TaskRepository();
        $projectRepository = new \App\Repositories\ProjectRepository();
        $userRepository = new \App\Repositories\UserRepository();

        $filters = $_SESSION['role'] === 'Admin' ? [] : ['assignee_id' => (int) $_SESSION['user_id']];
        $tasks = $taskRepository->findAll($filters);
        $projects = $projectRepository->findAll();
        $activeUsers = $userRepository->findActiveUsers();

        require __DIR__ . '/../views/tasks/tasks.php';
        break;

    case $uri === '/users':
        AuthMiddleware::requireLogin();
        require __DIR__ . '/../views/users/users.php';
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
}

