<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Paciente.php';

$database = new Database();
$db = $database->getConnection();
$model = new Paciente($db);

$id = (int)($_GET['id'] ?? 0);
$paciente = $model->obtenerPorId($id);

if (!$paciente) {
    die('Paciente no encontrado.');
}

include __DIR__ . '/../layouts/header.php';
?>

<div class="mb-4">
    <h2 class="section-title mb-1">Editar paciente</h2>
    <p class="section-subtitle">Actualice la información del paciente</p>
</div>

<div class="form-card">
    <form method="POST" action="/MEDICITAS_HCI/controllers/pacienteController.php?action=update">
        <input type="hidden" name="id_paciente" value="<?= $paciente['id_paciente'] ?>">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Identidad</label>
                <input type="text" name="identidad" class="form-control" value="<?= htmlspecialchars($paciente['identidad']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" value="<?= htmlspecialchars($paciente['fecha_nacimiento']) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sexo</label>
                <select name="sexo" class="form-select" required>
                    <option value="M" <?= $paciente['sexo'] === 'M' ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= $paciente['sexo'] === 'F' ? 'selected' : '' ?>>Femenino</option>
                    <option value="Otro" <?= $paciente['sexo'] === 'Otro' ? 'selected' : '' ?>>Otro</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($paciente['telefono']) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Estado civil</label>
                <input type="text" name="estado_civil" class="form-control" value="<?= htmlspecialchars($paciente['estado_civil']) ?>">
            </div>
            <div class="col-md-12">
                <label class="form-label">Dirección</label>
                <textarea name="direccion" class="form-control"><?= htmlspecialchars($paciente['direccion']) ?></textarea>
            </div>
            <div class="col-12 d-flex gap-3">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="/MEDICITAS_HCI/views/pacientes/listado.php" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>