<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/flash.php';
require_once __DIR__ . '/../models/Usuario.php';

$database = new Database();
$db = $database->getConnection();
$usuarioModel = new Usuario($db);

$action = $_GET['action'] ?? '';

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($correo === '' || $password === '') {
        $_SESSION['error_login'] = 'Debe completar correo y contraseña.';
        header('Location: /MEDICITAS_HCI/views/auth/login.php');
        exit;
    }

    $usuario = $usuarioModel->findByCorreo($correo);

    if ($usuario && password_verify($password, $usuario['password_hash'])) {
        $_SESSION['usuario'] = [
            'id' => $usuario['id_usuario'],
            'nombre' => $usuario['nombre'],
            'correo' => $usuario['correo'],
            'rol' => $usuario['rol'],
        ];

        setFlash('success', 'Bienvenido al sistema.');
        header('Location: /MEDICITAS_HCI/index.php');
        exit;
    }

    $_SESSION['error_login'] = 'Credenciales inválidas.';
    header('Location: /MEDICITAS_HCI/views/auth/login.php');
    exit;
}

if ($action === 'logout') {
    session_destroy();
    header('Location: /MEDICITAS_HCI/views/auth/login.php');
    exit;
}