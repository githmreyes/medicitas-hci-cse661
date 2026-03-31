<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Cita.php';

$database = new Database();
$db = $database->getConnection();
$model = new Cita($db);

$id = (int)($_GET['id'] ?? 0);
$cita = $model->obtenerPorId($id);

if (!$cita) {
    die('Cita no encontrada.');
}

$pacientes = $db->query("SELECT * FROM pacientes ORDER BY identidad ASC")->fetchAll();
$medicos = $db->query("
    SELECT m.id_medico, m.colegiado, e.nombre AS especialidad
    FROM medicos m
    INNER JOIN especialidades e ON m.id_especialidad = e.id_especialidad
    WHERE m.estado = 'activo'
    ORDER BY m.colegiado ASC
")->fetchAll();

include __DIR__ . '/../layouts/header.php';
?>

<div class="mb-4">
    <h2 class="section-title mb-1">Editar cita</h2>
    <p class="section-subtitle">Actualice la información de la cita médica</p>
</div>

<div class="form-card">
    <form method="POST" action="<?= url('controllers/citaController.php?action=update') ?>">
        <input type="hidden" name="id_cita" value="<?= $cita['id_cita'] ?>">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Paciente</label>
                <select name="id_paciente" class="form-select" required>
                    <?php foreach ($pacientes as $p): ?>
                        <option value="<?= $p['id_paciente'] ?>" <?= $cita['id_paciente'] == $p['id_paciente'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['identidad']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Médico</label>
                <select name="id_medico" class="form-select" required>
                    <?php foreach ($medicos as $m): ?>
                        <option value="<?= $m['id_medico'] ?>" <?= $cita['id_medico'] == $m['id_medico'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['colegiado']) ?> - <?= htmlspecialchars($m['especialidad']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="<?= htmlspecialchars($cita['fecha']) ?>" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Hora</label>
                <input type="time" name="hora" class="form-control" value="<?= htmlspecialchars(substr($cita['hora'], 0, 5)) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Estado</label>
                <select name="estado_cita" class="form-select">
                    <option value="programada" <?= $cita['estado_cita'] === 'programada' ? 'selected' : '' ?>>Programada</option>
                    <option value="confirmada" <?= $cita['estado_cita'] === 'confirmada' ? 'selected' : '' ?>>Confirmada</option>
                    <option value="atendida" <?= $cita['estado_cita'] === 'atendida' ? 'selected' : '' ?>>Atendida</option>
                    <option value="cancelada" <?= $cita['estado_cita'] === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                    <option value="reprogramada" <?= $cita['estado_cita'] === 'reprogramada' ? 'selected' : '' ?>>Reprogramada</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label">Motivo de consulta</label>
                <textarea name="motivo" class="form-control" required><?= htmlspecialchars($cita['motivo']) ?></textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones" class="form-control"><?= htmlspecialchars($cita['observaciones'] ?? '') ?></textarea>
            </div>

            <div class="col-12 d-flex gap-3">
                <button type="submit" class="btn btn-success">Actualizar cita</button>
                <a href="<?= url('views/citas/listado.php') ?>" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>