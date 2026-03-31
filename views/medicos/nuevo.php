<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Medico.php';

$database = new Database();
$db = $database->getConnection();
$model = new Medico($db);
$especialidades = $model->listarEspecialidades();

include __DIR__ . '/../layouts/header.php';
?>

<div class="mb-4">
    <h2 class="section-title mb-1">Nuevo médico</h2>
    <p class="section-subtitle">Complete la información del especialista</p>
</div>

<div class="form-card">
    <form method="POST" action="<?= url('controllers/medicoController.php') ?>?action=store">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Colegiado</label>
                <input type="text" name="colegiado" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Especialidad</label>
                <select name="id_especialidad" class="form-select" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($especialidades as $e): ?>
                        <option value="<?= $e['id_especialidad'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Consultorio</label>
                <input type="text" name="consultorio" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="col-12 d-flex gap-3">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="<?= url('views/medicos/listado.php') ?>" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>
    </form>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const colegiado = document.querySelector('[name="colegiado"]').value.trim();

    if (colegiado.length < 3) {
        alert('El número de colegiado no es válido.');
        e.preventDefault();
    }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>