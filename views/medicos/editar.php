<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Medico.php';

$database = new Database();
$db = $database->getConnection();
$model = new Medico($db);

$id = (int)($_GET['id'] ?? 0);
$medico = $model->obtenerPorId($id);
$especialidades = $model->listarEspecialidades();

if (!$medico) {
    die('Médico no encontrado.');
}

include __DIR__ . '/../layouts/header.php';
?>

<div class="mb-4">
    <h2 class="section-title mb-1">Editar médico</h2>
    <p class="section-subtitle">Actualice la información del especialista</p>
</div>

<div class="form-card">
    <form method="POST" action="<?= url('controllers/medicoController.php') ?>?action=update">
        <input type="hidden" name="id_medico" value="<?= $medico['id_medico'] ?>">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Colegiado</label>
                <input type="text" name="colegiado" class="form-control" value="<?= htmlspecialchars($medico['colegiado']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Especialidad</label>
                <select name="id_especialidad" class="form-select" required>
                    <?php foreach ($especialidades as $e): ?>
                        <option value="<?= $e['id_especialidad'] ?>" <?= $medico['id_especialidad'] == $e['id_especialidad'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($e['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($medico['telefono']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Consultorio</label>
                <input type="text" name="consultorio" class="form-control" value="<?= htmlspecialchars($medico['consultorio']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="activo" <?= $medico['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= $medico['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
            <div class="col-12 d-flex gap-3">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="<?= url('views/medicos/listado.php') ?>" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>