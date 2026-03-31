<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Paciente.php';

$database = new Database();
$db = $database->getConnection();
$model = new Paciente($db);

$busqueda = trim($_GET['busqueda'] ?? '');
$pacientes = $model->listar();

if ($busqueda !== '') {
    $pacientes = array_filter($pacientes, function ($row) use ($busqueda) {
        return stripos($row['identidad'], $busqueda) !== false
            || stripos($row['telefono'], $busqueda) !== false
            || stripos($row['estado_civil'], $busqueda) !== false;
    });
}

include __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="section-title mb-1">Pacientes</h2>
        <p class="section-subtitle">Gestión integral de pacientes registrados</p>
    </div>
    <a href="<?= url('views/pacientes/nuevo.php') ?>"
 class="btn btn-success">
        <i class="bi bi-plus-circle me-2"></i>Nuevo paciente
    </a>
</div>

<div class="table-card mb-4">
    <form method="GET" class="row g-3">
        <div class="col-md-10">
            <input type="text" name="busqueda" class="form-control" placeholder="Buscar por identidad, teléfono o estado civil" value="<?= htmlspecialchars($busqueda) ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Buscar</button>
        </div>
    </form>
</div>

<div class="table-card">
    <table class="table table-modern align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Identidad</th>
                <th>Fecha nacimiento</th>
                <th>Sexo</th>
                <th>Teléfono</th>
                <th>Estado civil</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pacientes) > 0): ?>
                <?php foreach ($pacientes as $row): ?>
                    <tr>
                        <td>#<?= $row['id_paciente'] ?></td>
                        <td><?= htmlspecialchars($row['identidad']) ?></td>
                        <td><?= htmlspecialchars($row['fecha_nacimiento']) ?></td>
                        <td><?= htmlspecialchars($row['sexo']) ?></td>
                        <td><?= htmlspecialchars($row['telefono']) ?></td>
                        <td><?= htmlspecialchars($row['estado_civil']) ?></td>
                        <td class="text-end">
                            <a href="<?= url('views/pacientes/editar.php') ?>?id=<?= $row['id_paciente'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= url('controllers/pacienteController.php') ?>?action=delete&id=<?= $row['id_paciente'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar paciente?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted">No hay pacientes registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>