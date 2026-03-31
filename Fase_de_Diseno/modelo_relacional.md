# Modelo Relacional de la Base de Datos

## Base de datos
medicitas_hci

## Tablas principales

### 1. usuarios
- id_usuario (PK)
- nombre
- correo
- password_hash
- rol
- estado
- fecha_creacion

### 2. pacientes
- id_paciente (PK)
- identidad
- fecha_nacimiento
- sexo
- telefono
- direccion
- estado_civil

### 3. especialidades
- id_especialidad (PK)
- nombre
- descripcion

### 4. medicos
- id_medico (PK)
- id_especialidad (FK)
- colegiado
- telefono
- consultorio
- estado

### 5. citas
- id_cita (PK)
- id_paciente (FK)
- id_medico (FK)
- fecha
- hora
- motivo
- estado_cita
- observaciones
- fecha_registro

### 6. historial_citas
- id_historial (PK)
- id_cita (FK)
- accion
- usuario_responsable
- fecha_accion
- detalle

## Relaciones
- Un médico pertenece a una especialidad.
- Un paciente puede tener muchas citas.
- Un médico puede atender muchas citas.
- Una cita puede tener muchos registros en historial.

## Justificación del modelo
Se eligió una base de datos relacional en MySQL por su facilidad de administración local con phpMyAdmin, consistencia de datos, trazabilidad y adecuada integración con PHP.