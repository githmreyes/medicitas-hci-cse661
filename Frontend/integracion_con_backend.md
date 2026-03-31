# Integración con Backend

## Método de integración
El frontend se conecta con el backend mediante formularios HTML enviados a controladores PHP.

## Flujo general
1. Usuario ingresa datos
2. Formulario envía información al controlador
3. El controlador valida
4. El modelo consulta o modifica la base de datos
5. El sistema redirige y muestra mensaje flash

## Ejemplos
- login -> authController
- nuevo paciente -> pacienteController
- nuevo médico -> medicoController
- nueva cita -> citaController

## Resultado
Se logró una integración directa, simple y funcional entre interfaz, lógica y persistencia.