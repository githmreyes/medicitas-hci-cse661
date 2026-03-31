# Configuración y Despliegue

## Entorno local usado
- XAMPP o equivalente
- Apache
- PHP
- MySQL
- phpMyAdmin
- Visual Studio Code

## Pasos de configuración
1. Copiar carpeta `MEDICITAS_HCI` a `htdocs`.
2. Crear base de datos `medicitas_hci`.
3. Importar archivo SQL.
4. Revisar credenciales en `config/database.php`.
5. Abrir login en navegador.

## Ruta inicial
http://localhost/MEDICITAS_HCI/views/auth/login.php

## Despliegue futuro
El sistema puede migrarse a hosting con soporte PHP y MySQL.