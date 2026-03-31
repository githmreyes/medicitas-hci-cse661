# Pruebas de Autenticación y Autorización

## Objetivo
Verificar que solo usuarios autenticados accedan al sistema.

## Casos evaluados
- login correcto
- login incorrecto
- cierre de sesión
- acceso no autorizado a vistas privadas

## Resultado
La sesión se protege mediante `requireLogin()` y se redirige al login cuando no existe sesión activa.