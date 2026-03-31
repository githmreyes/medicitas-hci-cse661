<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2 class="section-title mb-1">Nuevo paciente</h2>
    <p class="section-subtitle">Complete la información del paciente</p>
</div>

<div class="form-card">
    <form method="POST" action="/MEDICITAS_HCI/controllers/pacienteController.php?action=store">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Identidad</label>
                <input type="text" name="identidad" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sexo</label>
                <select name="sexo" class="form-select" required>
                    <option value="">Seleccione</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Estado civil</label>
                <input type="text" name="estado_civil" class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">Dirección</label>
                <textarea name="direccion" class="form-control"></textarea>
            </div>
            <div class="col-12 d-flex gap-3">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="/MEDICITAS_HCI/views/pacientes/listado.php" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>
    </form>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const identidad = document.querySelector('[name="identidad"]').value.trim();
    const telefono = document.querySelector('[name="telefono"]').value.trim();

    if (identidad.length < 5) {
        alert('La identidad debe tener al menos 5 caracteres.');
        e.preventDefault();
        return;
    }

    if (telefono.length < 8) {
        alert('El teléfono debe tener al menos 8 caracteres.');
        e.preventDefault();
    }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>