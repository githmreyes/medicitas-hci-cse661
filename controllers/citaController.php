<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/flash.php';
require_once __DIR__ . '/../models/Cita.php';

$database = new Database();
$db = $database->getConnection();
$model = new Cita($db);

$action = $_GET['action'] ?? '';
$usuarioResponsable = $_SESSION['usuario']['nombre'] ?? 'Sistema';

function validarCita(array $data): array
{
    $errores = [];

    if (empty(trim($data['id_paciente'] ?? ''))) {
        $errores[] = 'Debe seleccionar un paciente.';
    }

    if (empty(trim($data['id_medico'] ?? ''))) {
        $errores[] = 'Debe seleccionar un médico.';
    }

    if (empty(trim($data['fecha'] ?? ''))) {
        $errores[] = 'La fecha es obligatoria.';
    }

    if (empty(trim($data['hora'] ?? ''))) {
        $errores[] = 'La hora es obligatoria.';
    }

    if (empty(trim($data['motivo'] ?? ''))) {
        $errores[] = 'El motivo de consulta es obligatorio.';
    }

    return $errores;
}

if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = validarCita($_POST);

    if (!empty($errores)) {
        setFlash('danger', implode(' ', $errores));
        header('Location: /MEDICITAS_HCI/views/citas/nueva.php');
        exit;
    }

    if ($model->crear($_POST)) {
        $ultimoId = (int)$db->lastInsertId();
        $model->registrarHistorial($ultimoId, 'Creación de cita', $usuarioResponsable, 'La cita fue creada correctamente.');
        setFlash('success', 'Cita creada correctamente.');
    } else {
        setFlash('danger', 'No se pudo crear la cita.');
    }

    header('Location: /MEDICITAS_HCI/views/citas/listado.php');
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id_cita'] ?? 0);
    $errores = validarCita($_POST);

    if (!empty($errores)) {
        setFlash('danger', implode(' ', $errores));
        header("Location: /MEDICITAS_HCI/views/citas/editar.php?id={$id}");
        exit;
    }

    if ($model->actualizar($id, $_POST)) {
        $model->registrarHistorial($id, 'Actualización de cita', $usuarioResponsable, 'La cita fue actualizada.');
        setFlash('success', 'Cita actualizada correctamente.');
    } else {
        setFlash('danger', 'No se pudo actualizar la cita.');
    }

    header('Location: /MEDICITAS_HCI/views/citas/listado.php');
    exit;
}

if ($action === 'cancel') {
    $id = (int)($_GET['id'] ?? 0);

    if ($model->cancelar($id)) {
        $model->registrarHistorial($id, 'Cancelación de cita', $usuarioResponsable, 'La cita fue cancelada.');
        setFlash('warning', 'Cita cancelada correctamente.');
    } else {
        setFlash('danger', 'No se pudo cancelar la cita.');
    }

    header('Location: /MEDICITAS_HCI/views/citas/listado.php');
    exit;
}