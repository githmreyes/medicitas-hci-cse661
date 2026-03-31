<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/flash.php';
require_once __DIR__ . '/../models/Paciente.php';

$database = new Database();
$db = $database->getConnection();
$model = new Paciente($db);

$action = $_GET['action'] ?? '';

function validarPaciente(array $data): array
{
    $errores = [];

    if (empty(trim($data['identidad'] ?? ''))) {
        $errores[] = 'La identidad es obligatoria.';
    }

    if (empty(trim($data['fecha_nacimiento'] ?? ''))) {
        $errores[] = 'La fecha de nacimiento es obligatoria.';
    }

    if (empty(trim($data['sexo'] ?? ''))) {
        $errores[] = 'El sexo es obligatorio.';
    }

    if (empty(trim($data['telefono'] ?? ''))) {
        $errores[] = 'El teléfono es obligatorio.';
    }

    return $errores;
}

if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = validarPaciente($_POST);

    if (!empty($errores)) {
        setFlash('danger', implode(' ', $errores));
        header('Location: /MEDICITAS_HCI/views/pacientes/nuevo.php');
        exit;
    }

    if ($model->crear($_POST)) {
        setFlash('success', 'Paciente creado correctamente.');
    } else {
        setFlash('danger', 'No se pudo crear el paciente.');
    }

    header('Location: /MEDICITAS_HCI/views/pacientes/listado.php');
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id_paciente'] ?? 0);
    $errores = validarPaciente($_POST);

    if (!empty($errores)) {
        setFlash('danger', implode(' ', $errores));
        header("Location: /MEDICITAS_HCI/views/pacientes/editar.php?id={$id}");
        exit;
    }

    if ($model->actualizar($id, $_POST)) {
        setFlash('success', 'Paciente actualizado correctamente.');
    } else {
        setFlash('danger', 'No se pudo actualizar el paciente.');
    }

    header('Location: /MEDICITAS_HCI/views/pacientes/listado.php');
    exit;
}

if ($action === 'delete') {
    $id = (int)($_GET['id'] ?? 0);

    if ($model->eliminar($id)) {
        setFlash('warning', 'Paciente eliminado correctamente.');
    } else {
        setFlash('danger', 'No se pudo eliminar el paciente.');
    }

    header('Location: /MEDICITAS_HCI/views/pacientes/listado.php');
    exit;
}