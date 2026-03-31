# Diagrama de Casos de Uso

## Actores principales
- Administrador
- Recepcionista
- Médico
- Paciente

## Casos de uso por actor

### Administrador
- Iniciar sesión
- Gestionar usuarios
- Gestionar pacientes
- Gestionar médicos
- Gestionar citas
- Consultar historial
- Ver reportes

### Recepcionista
- Iniciar sesión
- Registrar paciente
- Registrar médico
- Programar cita
- Editar cita
- Cancelar cita
- Consultar historial

### Médico
- Iniciar sesión
- Consultar agenda
- Revisar historial de cita
- Ver pacientes asignados

### Paciente
- Solicitar cita (escenario futuro)
- Consultar estado de cita (escenario futuro)

## Descripción textual del flujo principal
1. El usuario inicia sesión.
2. Accede al dashboard.
3. Selecciona módulo.
4. Ejecuta operación CRUD.
5. El sistema valida.
6. El sistema guarda o actualiza.
7. Muestra mensaje de resultado.