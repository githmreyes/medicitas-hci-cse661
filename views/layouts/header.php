<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/flash.php';
requireLogin();

$usuario = currentUser();
$usuarioNombre = $usuario['nombre'] ?? 'Usuario';
$usuarioRol = $usuario['rol'] ?? 'Invitado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCitas HCI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('public/css/style.css') ?>">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <div>
                <h5 class="mb-0">MediCitas</h5>
                <small>HCI System</small>
            </div>
        </div>

        <nav class="sidebar-menu">
            <a href="<?= url('index.php') ?>" class="menu-item"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>
            <a href="<?= url('views/pacientes/listado.php') ?>" class="menu-item"><i class="bi bi-people"></i><span>Pacientes</span></a>
            <a href="<?= url('views/medicos/listado.php') ?>" class="menu-item"><i class="bi bi-person-badge"></i><span>Médicos</span></a>
            <a href="<?= url('views/citas/listado.php') ?>" class="menu-item"><i class="bi bi-calendar2-check"></i><span>Citas</span></a>
            <a href="<?= url('views/citas/nueva.php') ?>" class="menu-item"><i class="bi bi-plus-circle"></i><span>Nueva cita</span></a>
            <a href="<?= url('views/reportes/index.php') ?>" class="menu-item"><i class="bi bi-bar-chart-line"></i><span>Reportes</span></a>
            <a href="<?= url('controllers/authController.php') ?>?action=logout" class="menu-item"><i class="bi bi-box-arrow-left"></i><span>Salir</span></a>
        </nav>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button class="btn btn-light d-lg-none" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h4 class="page-title mb-0">Sistema de Gestión de Citas Médicas</h4>
                    <small class="text-muted">Plataforma centrada en HCI</small>
                </div>
            </div>

            <div class="topbar-right">
                <div class="topbar-user">
                    <div class="user-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div class="user-info">
                        <strong><?= htmlspecialchars($usuarioNombre) ?></strong>
                        <small><?= htmlspecialchars(ucfirst($usuarioRol)) ?></small>
                    </div>
                </div>
            </div>
        </header>

        <main class="content-area">
            <?php $flash = getFlash(); ?>
            <?php if ($flash): ?>
                <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($flash['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>