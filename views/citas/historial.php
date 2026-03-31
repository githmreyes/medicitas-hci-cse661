<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Cita.php';

$database = new Database();
$db = $database->getConnection();
$model = new Cita($db);

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    die('ID de cita inválido.');
}

$historial = $model->historialPorCita($id);

include __DIR__ . '/../layouts/header.php';
?>

<div class="mb-4">
    <h2 class="section-title mb-1">Historial de la cita #<?= $id ?></h2>
    <p class="section-subtitle">Trazabilidad de cambios y acciones realizadas</p>
</div>

<div class="table-card">
    <table class="table table-modern align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Acción</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($historial) > 0): ?>
                <?php foreach ($historial as $row): ?>
                    <tr>
                        <td>#<?= $row['id_historial'] ?></td>
                        <td><?= htmlspecialchars($row['accion']) ?></td>
                        <td><?= htmlspecialchars($row['usuario_responsable']) ?></td>
                        <td><?= htmlspecialchars($row['fecha_accion']) ?></td>
                        <td><?= htmlspecialchars($row['detalle']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No hay historial registrado para esta cita.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-3">
        <a href="/MEDICITAS_HCI/views/citas/listado.php" class="btn btn-outline-secondary">
            Volver al listado
        </a>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>