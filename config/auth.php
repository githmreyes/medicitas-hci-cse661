<?php
require_once __DIR__ . '/../config/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin(): void
{
    if (!isset($_SESSION['usuario'])) {
        redirectTo('views/auth/login.php');
        exit;
    }
}

function currentUser(): array
{
    return $_SESSION['usuario'] ?? [];
}