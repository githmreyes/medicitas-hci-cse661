# Conexión de Base de Datos

## Archivo principal
config/database.php

## Método utilizado
Se utilizó PDO con configuración UTF-8 y manejo de errores mediante excepciones.

## Justificación
PDO permite:
- seguridad en consultas
- portabilidad
- mejor manejo de errores
- estructura más profesional

## Base utilizada
medicitas_hci

## Tablas principales
- usuarios
- pacientes
- especialidades
- medicos
- citas
- historial_citas