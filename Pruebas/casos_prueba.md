# Casos de Prueba

## CP-01 Login correcto
Entrada: admin@medicitas.com / admin123
Esperado: ingreso al dashboard
Resultado: OK

## CP-02 Login incorrecto
Entrada: usuario válido + contraseña incorrecta
Esperado: mensaje de error
Resultado: OK

## CP-03 Acceso sin sesión
Entrada: abrir index.php sin login
Esperado: redirección al login
Resultado: OK

## CP-04 Crear paciente
Entrada: datos completos y válidos
Esperado: paciente guardado y mensaje flash
Resultado: OK

## CP-05 Validación de paciente
Entrada: formulario incompleto
Esperado: mensaje de error y no guardar
Resultado: OK

## CP-06 Editar paciente
Entrada: cambio de datos
Esperado: actualización correcta
Resultado: OK

## CP-07 Eliminar paciente
Entrada: confirmación de eliminación
Esperado: eliminación correcta
Resultado: OK

## CP-08 Crear médico
Entrada: colegiado, especialidad, estado
Esperado: médico registrado
Resultado: OK

## CP-09 Editar médico
Entrada: actualización de consultorio y teléfono
Esperado: actualización correcta
Resultado: OK

## CP-10 Eliminar médico
Entrada: confirmación
Esperado: eliminación correcta
Resultado: OK

## CP-11 Crear cita
Entrada: paciente, médico, fecha, hora y motivo
Esperado: cita guardada
Resultado: OK

## CP-12 Editar cita
Entrada: cambio de fecha, hora o estado
Esperado: actualización y registro en historial
Resultado: OK

## CP-13 Cancelar cita
Entrada: acción cancelar
Esperado: estado cancelada e historial
Resultado: OK

## CP-14 Historial de cita
Entrada: abrir historial
Esperado: visualizar acciones registradas
Resultado: OK

## CP-15 Navegación lateral
Entrada: uso del sidebar
Esperado: acceso correcto a cada módulo
Resultado: OK

## CP-16 Responsive
Entrada: pantalla reducida
Esperado: interfaz adaptable
Resultado: OK