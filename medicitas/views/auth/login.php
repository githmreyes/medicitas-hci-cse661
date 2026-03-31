<?php
session_start();
$error = $_SESSION['error_login'] ?? null;
unset($_SESSION['error_login']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MediCitas HCI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('public/css/style.css') ?>">
    <style>
        .login-wrapper{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,#eff6ff,#f8fafc);
            padding:20px;
        }
        .login-card{
            width:100%;
            max-width:430px;
            background:#fff;
            border-radius:20px;
            box-shadow:0 20px 50px rgba(15,23,42,.10);
            padding:34px;
        }
        .login-logo{
            width:70px;height:70px;border-radius:18px;
            display:flex;align-items:center;justify-content:center;
            margin:0 auto 18px auto;
            background:linear-gradient(135deg,#0d6efd,#0dcaf0);
            color:#fff;font-size:32px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="text-center mb-4">
                <div class="login-logo">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <h3 class="fw-bold mb-1">MediCitas HCI</h3>
                <p class="text-muted mb-0">Inicia sesión para continuar</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= url('controllers/authController.php') ?>?action=login">
                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" class="form-control" placeholder="admin@medicitas.com" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                </button>
            </form>

            <div class="mt-4 text-center text-muted small">
                Usuario demo: admin@medicitas.com<br>
                Contraseña: admin123
            </div>
        </div>
    </div>
</body>
</html>