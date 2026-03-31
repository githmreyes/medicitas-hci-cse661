<?php
require_once __DIR__ . '/../../config/database.php';

$database = new Database();
$db = $database->getConnection();

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
    <h2 class="section-title mb-1">Registrar nueva cita</h2>
    <p class="section-subtitle">Complete la información para programar una cita médica</p>
</div>

<div class="form-card">
    <form method="POST" action="/MEDICITAS_HCI/controllers/citaController.php?action=store">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Paciente</label>
                <select name="id_paciente" class="form-select" required>
                    <option value="">Seleccione un paciente</option>
                    <?php foreach ($pacientes as $p): ?>
                        <option value="<?= $p['id_paciente'] ?>"><?= htmlspecialchars($p['identidad']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Médico</label>
                <select name="id_medico" class="form-select" required>
                    <option value="">Seleccione un médico</option>
                    <?php foreach ($medicos as $m): ?>
                        <option value="<?= $m['id_medico'] ?>">
                            <?= htmlspecialchars($m['colegiado']) ?> - <?= htmlspecialchars($m['especialidad']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Hora</label>
                <input type="time" name="hora" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Estado inicial</label>
                <select name="estado_cita" class="form-select">
                    <option value="programada">Programada</option>
                    <option value="confirmada">Confirmada</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label">Motivo de consulta</label>
                <textarea name="motivo" class="form-control" required></textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones" class="form-control"></textarea>
            </div>

            <div class="col-12 d-flex gap-3">
                <button type="submit" class="btn btn-success">Guardar cita</button>
                <a href="/MEDICITAS_HCI/views/citas/listado.php" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>
    </form>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const fecha = document.querySelector('[name="fecha"]').value;
    const motivo = document.querySelector('[name="motivo"]').value.trim();

    if (!fecha) {
        alert('Debe seleccionar una fecha.');
        e.preventDefault();
        return;
    }

    if (motivo.length < 5) {
        alert('El motivo de consulta debe tener al menos 5 caracteres.');
        e.preventDefault();
    }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>