<?php
require_once __DIR__ . '/../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$totalPacientes = $db->query("SELECT COUNT(*) total FROM pacientes")->fetch()['total'];
$totalMedicos = $db->query("SELECT COUNT(*) total FROM medicos")->fetch()['total'];
$totalCitas = $db->query("SELECT COUNT(*) total FROM citas")->fetch()['total'];
$totalCanceladas = $db->query("SELECT COUNT(*) total FROM citas WHERE estado_cita = 'cancelada'")->fetch()['total'];

$citasPorEstado = $db->query("
    SELECT estado_cita, COUNT(*) total
    FROM citas
    GROUP BY estado_cita
")->fetchAll();

$citasPorEspecialidad = $db->query("
    SELECT e.nombre AS especialidad, COUNT(*) total
    FROM citas c
    INNER JOIN medicos m ON c.id_medico = m.id_medico
    INNER JOIN especialidades e ON m.id_especialidad = e.id_especialidad
    GROUP BY e.nombre
    ORDER BY total DESC
")->fetchAll();

include __DIR__ . '/../layouts/header.php';
?>

<div class="mb-4">
    <h2 class="section-title mb-1">Reportes básicos</h2>
    <p class="section-subtitle">Indicadores generales del sistema</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-label">Pacientes</div>
            <p class="kpi-value"><?= $totalPacientes ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-label">Médicos</div>
            <p class="kpi-value"><?= $totalMedicos ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-label">Citas</div>
            <p class="kpi-value"><?= $totalCitas ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-label">Canceladas</div>
            <p class="kpi-value"><?= $totalCanceladas ?></p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="table-card">
            <h5 class="mb-3">Citas por estado</h5>
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citasPorEstado as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars(ucfirst($row['estado_cita'])) ?></td>
                            <td><?= htmlspecialchars($row['total']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="table-card">
            <h5 class="mb-3">Citas por especialidad</h5>
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Especialidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citasPorEspecialidad as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['especialidad']) ?></td>
                            <td><?= htmlspecialchars($row['total']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>