<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
    case '/index.php':
        try {
            Database::getConnection();
            echo 'App jalan, koneksi database berhasil.';
        } catch (\PDOException $e) {
            http_response_code(500);
            echo 'Koneksi database gagal.';
        }
        break;

    default:
        http_response_code(404);
        echo '404 Not Found';
}
