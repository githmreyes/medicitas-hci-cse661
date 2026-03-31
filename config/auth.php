<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin(): void
{
    if (!isset($_SESSION['usuario'])) {
        header('Location: /MEDICITAS_HCI/views/auth/login.php');
        exit;
    }
}

function currentUser(): array
{
    return $_SESSION['usuario'] ?? [];
}