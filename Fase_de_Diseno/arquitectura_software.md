# Arquitectura de Software

## Tipo de arquitectura
Arquitectura modular en tres capas.

## Capas

### 1. Capa de presentación
Responsable de mostrar la interfaz al usuario.
Tecnologías:
- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- PHP embebido en vistas

### 2. Capa de lógica de negocio
Responsable del control de flujo, validaciones y procesamiento de operaciones.
Componentes:
- authController.php
- pacienteController.php
- medicoController.php
- citaController.php

### 3. Capa de datos
Responsable de la persistencia y consulta de datos.
Tecnologías:
- MySQL
- phpMyAdmin
- PDO para conexión segura

## Estructura del proyecto
- config
- models
- controllers
- views
- public
- routes
- tests

## Ventajas de esta arquitectura
- Separación de responsabilidades
- Mantenimiento más sencillo
- Reutilización de componentes
- Escalabilidad básica
- Integración clara entre interfaz y datos