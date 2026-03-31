<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Cita.php';
require_once __DIR__ . '/models/Paciente.php';
require_once __DIR__ . '/models/Medico.php';

$database = new Database();
$db = $database->getConnection();

$citaModel = new Cita($db);
$pacienteModel = new Paciente($db);
$medicoModel = new Medico($db);

$citasHoy = $citaModel->countHoy();
$totalPacientes = $pacienteModel->countAll();
$totalMedicos = $medicoModel->countAll();
$totalCanceladas = $citaModel->countCanceladas();
$recientes = $citaModel->listarRecientes();

include __DIR__ . '/views/layouts/header.php';
?>

<div class="mb-4">
    <h2 class="section-title">Dashboard General</h2>
    <p class="section-subtitle">Resumen operativo del sistema de citas médicas</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Citas hoy</div>
                    <p class="kpi-value"><?= $citasHoy ?></p>
                </div>
                <div class="kpi-icon primary"><i class="bi bi-calendar-check"></i></div>
            </div>
            <div class="kpi-trend">Actividad del día</div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Pacientes registrados</div>
                    <p class="kpi-value"><?= $totalPacientes ?></p>
                </div>
                <div class="kpi-icon success"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="kpi-trend">Base activa</div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Médicos activos</div>
                    <p class="kpi-value"><?= $totalMedicos ?></p>
                </div>
                <div class="kpi-icon info"><i class="bi bi-person-badge-fill"></i></div>
            </div>
            <div class="kpi-trend">Especialistas</div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="kpi-card">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Citas canceladas</div>
                    <p class="kpi-value"><?= $totalCanceladas ?></p>
                </div>
                <div class="kpi-icon warning"><i class="bi bi-exclamation-circle-fill"></i></div>
            </div>
            <div class="kpi-trend">Requieren seguimiento</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-1">Citas recientes</h5>
                    <small class="text-muted">Últimos registros en el sistema</small>
                </div>
                <a href="<?= url('views/citas/listado.php') ?>" class="btn btn-primary btn-sm">Ver todas</a>
            </div>

            <table class="table table-modern align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($recientes) > 0): ?>
                        <?php foreach ($recientes as $row): ?>
                            <tr>
                                <td>#<?= $row['id_cita'] ?></td>
                                <td><?= htmlspecialchars($row['identidad']) ?></td>
                                <td><?= htmlspecialchars($row['colegiado']) ?></td>
                                <td><?= htmlspecialchars($row['fecha']) ?></td>
                                <td><?= htmlspecialchars(substr($row['hora'], 0, 5)) ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($row['estado_cita']) ?>">
                                        <?= htmlspecialchars(ucfirst($row['estado_cita'])) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted">No hay citas registradas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-card">
            <h5 class="mb-3">Acciones rápidas</h5>
            <div class="d-grid gap-3">
                <a href="<?= url('views/citas/nueva.php') ?>" class="btn btn-success">
                    <i class="bi bi-plus-circle me-2"></i>Nueva cita
                </a>
                <a href="<?= url('views/pacientes/nuevo.php') ?>" class="btn btn-primary">
                    <i class="bi bi-person-plus me-2"></i>Nuevo paciente
                </a>
                <a href="<?= url('views/medicos/nuevo.php') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-person-badge me-2"></i>Nuevo médico
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/views/layouts/footer.php'; ?>