# Especificación de API / Endpoints Internos

Aunque el sistema no usa una API REST externa completa, sí implementa endpoints internos basados en controladores.

## Autenticación
### POST /controllers/authController.php?action=login
Parámetros:
- correo
- password

Respuesta:
- redirección a dashboard si es correcto
- mensaje de error si es inválido

### GET /controllers/authController.php?action=logout
Respuesta:
- cierre de sesión
- redirección al login

## Pacientes
### POST /controllers/pacienteController.php?action=store
Parámetros:
- identidad
- fecha_nacimiento
- sexo
- telefono
- direccion
- estado_civil

### POST /controllers/pacienteController.php?action=update
Parámetros:
- id_paciente
- campos editables

### GET /controllers/pacienteController.php?action=delete&id={id}

## Médicos
### POST /controllers/medicoController.php?action=store
### POST /controllers/medicoController.php?action=update
### GET /controllers/medicoController.php?action=delete&id={id}

## Citas
### POST /controllers/citaController.php?action=store
### POST /controllers/citaController.php?action=update
### GET /controllers/citaController.php?action=cancel&id={id}

## Autenticación
La protección se realiza por sesión mediante `config/auth.php`.