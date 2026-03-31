<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Cita.php';

$database = new Database();
$db = $database->getConnection();
$model = new Cita($db);

$busqueda = trim($_GET['busqueda'] ?? '');
$estadoFiltro = trim($_GET['estado'] ?? '');
$citas = $model->listar();

if ($busqueda !== '') {
    $citas = array_filter($citas, function ($row) use ($busqueda) {
        return stripos($row['identidad'], $busqueda) !== false
            || stripos($row['colegiado'], $busqueda) !== false
            || stripos($row['especialidad'], $busqueda) !== false
            || stripos($row['motivo'], $busqueda) !== false;
    });
}

if ($estadoFiltro !== '') {
    $citas = array_filter($citas, function ($row) use ($estadoFiltro) {
        return $row['estado_cita'] === $estadoFiltro;
    });
}

include __DIR__ . '/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="section-title mb-1">Listado de citas</h2>
        <p class="section-subtitle">Consulta, edita y da seguimiento a las citas registradas</p>
    </div>
    <a href="<?= url('views/citas/nueva.php') ?>" class="btn btn-success">
        <i class="bi bi-plus-circle me-2"></i>Nueva cita
    </a>
</div>

<div class="table-card mb-4">
    <form method="GET" class="row g-3">
        <div class="col-md-7">
            <input type="text" name="busqueda" class="form-control" placeholder="Buscar paciente, médico, especialidad o motivo" value="<?= htmlspecialchars($busqueda) ?>">
        </div>
        <div class="col-md-3">
            <select name="estado" class="form-select">
                <option value="">Todos los estados</option>
                <option value="programada" <?= $estadoFiltro === 'programada' ? 'selected' : '' ?>>Programada</option>
                <option value="confirmada" <?= $estadoFiltro === 'confirmada' ? 'selected' : '' ?>>Confirmada</option>
                <option value="atendida" <?= $estadoFiltro === 'atendida' ? 'selected' : '' ?>>Atendida</option>
                <option value="cancelada" <?= $estadoFiltro === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                <option value="reprogramada" <?= $estadoFiltro === 'reprogramada' ? 'selected' : '' ?>>Reprogramada</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>
</div>

<div class="table-card">
    <table class="table table-modern align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Especialidad</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($citas) > 0): ?>
                <?php foreach ($citas as $row): ?>
                    <tr>
                        <td>#<?= $row['id_cita'] ?></td>
                        <td><?= htmlspecialchars($row['identidad']) ?></td>
                        <td><?= htmlspecialchars($row['colegiado']) ?></td>
                        <td><?= htmlspecialchars($row['especialidad']) ?></td>
                        <td><?= htmlspecialchars($row['fecha']) ?></td>
                        <td><?= htmlspecialchars(substr($row['hora'], 0, 5)) ?></td>
                        <td><?= htmlspecialchars($row['motivo']) ?></td>
                        <td><span class="status-badge status-<?= strtolower($row['estado_cita']) ?>"><?= htmlspecialchars(ucfirst($row['estado_cita'])) ?></span></td>
                        <td class="text-end">
                            <a href="<?= url('views/citas/editar.php') ?>?id=<?= $row['id_cita'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="<?= url('controllers/citaController.php') ?>?action=cancel&id=<?= $row['id_cita'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Cancelar cita?')">Cancelar</a>
                            <a href="<?= url('views/citas/historial.php') ?>?id=<?= $row['id_cita'] ?>" class="btn btn-info btn-sm">Historial</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="9" class="text-center text-muted">No hay citas registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>