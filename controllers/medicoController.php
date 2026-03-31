<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/flash.php';
require_once __DIR__ . '/../models/Medico.php';

$database = new Database();
$db = $database->getConnection();
$model = new Medico($db);

$action = $_GET['action'] ?? '';

function validarMedico(array $data): array
{
    $errores = [];

    if (empty(trim($data['colegiado'] ?? ''))) {
        $errores[] = 'El número de colegiado es obligatorio.';
    }

    if (empty(trim($data['id_especialidad'] ?? ''))) {
        $errores[] = 'La especialidad es obligatoria.';
    }

    if (empty(trim($data['estado'] ?? ''))) {
        $errores[] = 'El estado es obligatorio.';
    }

    return $errores;
}

if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = validarMedico($_POST);

    if (!empty($errores)) {
        setFlash('danger', implode(' ', $errores));
        redirectTo('views/medicos/nuevo.php');
        exit;
    }

    if ($model->crear($_POST)) {
        setFlash('success', 'Médico creado correctamente.');
    } else {
        setFlash('danger', 'No se pudo crear el médico.');
    }

    redirectTo('views/medicos/listado.php');
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id_medico'] ?? 0);
    $errores = validarMedico($_POST);

    if (!empty($errores)) {
        setFlash('danger', implode(' ', $errores));
        redirectTo("views/medicos/editar.php?id={$id}");
        exit;
    }

    if ($model->actualizar($id, $_POST)) {
        setFlash('success', 'Médico actualizado correctamente.');
    } else {
        setFlash('danger', 'No se pudo actualizar el médico.');
    }

    redirectTo('views/medicos/listado.php');
    exit;
}

if ($action === 'delete') {
    $id = (int)($_GET['id'] ?? 0);

    if ($model->eliminar($id)) {
        setFlash('warning', 'Médico eliminado correctamente.');
    } else {
        setFlash('danger', 'No se pudo eliminar el médico.');
    }

    redirectTo('views/medicos/listado.php');
    exit;
}