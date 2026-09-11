<?php

namespace App\Middleware;

class AuthMiddleware
{
    public static function requireLogin(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
