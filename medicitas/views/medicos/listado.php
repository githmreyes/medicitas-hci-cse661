<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Medico.php';

$database = new Database();
$db = $database->getConnection();
$model = new Medico($db);

$busqueda = trim($_GET['busqueda'] ?? '');
$medicos = $model->listar();

if ($busqueda !== '') {
    $medicos = array_filter($medicos, function ($row) use ($busqueda) {
        return stripos($row['colegiado'], $busqueda) !== false
            || stripos($row['especialidad'], $busqueda) !== false
            || stripos($row['telefono'], $busqueda) !== false
            || stripos($row['consultorio'], $busqueda) !== false;
    });
}

include __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="section-title mb-1">Médicos</h2>
        <p class="section-subtitle">Gestión de especialistas del sistema</p>
    </div>
    <a href="/MEDICITAS_HCI/views/medicos/nuevo.php" class="btn btn-success">
        <i class="bi bi-plus-circle me-2"></i>Nuevo médico
    </a>
</div>

<div class="table-card mb-4">
    <form method="GET" class="row g-3">
        <div class="col-md-10">
            <input type="text" name="busqueda" class="form-control" placeholder="Buscar por colegiado, especialidad, teléfono o consultorio" value="<?= htmlspecialchars($busqueda) ?>">
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
                <th>Colegiado</th>
                <th>Especialidad</th>
                <th>Teléfono</th>
                <th>Consultorio</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($medicos) > 0): ?>
                <?php foreach ($medicos as $row): ?>
                    <tr>
                        <td>#<?= $row['id_medico'] ?></td>
                        <td><?= htmlspecialchars($row['colegiado']) ?></td>
                        <td><?= htmlspecialchars($row['especialidad']) ?></td>
                        <td><?= htmlspecialchars($row['telefono']) ?></td>
                        <td><?= htmlspecialchars($row['consultorio']) ?></td>
                        <td><?= htmlspecialchars($row['estado']) ?></td>
                        <td class="text-end">
                            <a href="/MEDICITAS_HCI/views/medicos/editar.php?id=<?= $row['id_medico'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="/MEDICITAS_HCI/controllers/medicoController.php?action=delete&id=<?= $row['id_medico'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar médico?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted">No hay médicos registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>