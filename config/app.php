<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Base URL del proyecto
|--------------------------------------------------------------------------
| Local con carpeta:
|   http://localhost:8012/MEDICITAS_HCI
|
| Hosting en raíz:
|   https://tudominio.com
|
| Si el hosting queda en subcarpeta:
|   https://tudominio.com/medicitas
*/
const APP_BASE_URL = '/MEDICITAS_HCI';

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/
function url(string $path = ''): string
{
    $base = rtrim(APP_BASE_URL, '/');
    $path = ltrim($path, '/');
    return $path === '' ? $base : $base . '/' . $path;
}

function redirectTo(string $path): void
{
    header('Location: ' . url($path));
    exit;
}