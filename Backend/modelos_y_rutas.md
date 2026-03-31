# Modelos y Rutas

## Modelos implementados

### Usuario.php
- búsqueda por correo
- soporte a autenticación

### Paciente.php
- crear
- listar
- obtener por id
- actualizar
- eliminar
- contar registros

### Medico.php
- crear
- listar
- obtener por id
- actualizar
- eliminar
- listar especialidades
- contar registros

### Cita.php
- crear
- listar
- obtener por id
- actualizar
- cancelar
- registrar historial
- consultar historial
- contar citas
- listar recientes

## Ruta base
- routes/web.php redirecciona al index principal

## Patrón usado
Las acciones se ejecutan mediante parámetros `action` enviados a cada controlador.
Ejemplo:
- authController.php?action=login
- pacienteController.php?action=store
- medicoController.php?action=update
- citaController.php?action=cancel