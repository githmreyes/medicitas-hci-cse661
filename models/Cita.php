<?php
declare(strict_types=1);

class Cita
{
    private PDO $conn;
    private string $table = "citas";

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function crear(array $data): bool
    {
        $sql = "INSERT INTO {$this->table}
                (id_paciente, id_medico, fecha, hora, motivo, estado_cita, observaciones)
                VALUES (:id_paciente, :id_medico, :fecha, :hora, :motivo, :estado_cita, :observaciones)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id_paciente' => $data['id_paciente'],
            ':id_medico' => $data['id_medico'],
            ':fecha' => $data['fecha'],
            ':hora' => $data['hora'],
            ':motivo' => trim($data['motivo']),
            ':estado_cita' => $data['estado_cita'] ?? 'programada',
            ':observaciones' => trim($data['observaciones'] ?? ''),
        ]);
    }

    public function listar(): array
    {
        $sql = "SELECT c.*, 
                       p.identidad,
                       m.colegiado,
                       e.nombre AS especialidad
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN medicos m ON c.id_medico = m.id_medico
                INNER JOIN especialidades e ON m.id_especialidad = e.id_especialidad
                ORDER BY c.fecha DESC, c.hora DESC";
        return $this->conn->query($sql)->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_cita = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function actualizar(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET id_paciente = :id_paciente,
                    id_medico = :id_medico,
                    fecha = :fecha,
                    hora = :hora,
                    motivo = :motivo,
                    estado_cita = :estado_cita,
                    observaciones = :observaciones
                WHERE id_cita = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id_paciente' => $data['id_paciente'],
            ':id_medico' => $data['id_medico'],
            ':fecha' => $data['fecha'],
            ':hora' => $data['hora'],
            ':motivo' => trim($data['motivo']),
            ':estado_cita' => $data['estado_cita'],
            ':observaciones' => trim($data['observaciones'] ?? ''),
            ':id' => $id,
        ]);
    }

    public function cancelar(int $id): bool
    {
        $sql = "UPDATE {$this->table} SET estado_cita = 'cancelada' WHERE id_cita = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function registrarHistorial(int $idCita, string $accion, string $usuarioResponsable, string $detalle = ''): bool
    {
        $sql = "INSERT INTO historial_citas (id_cita, accion, usuario_responsable, detalle)
                VALUES (:id_cita, :accion, :usuario_responsable, :detalle)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id_cita' => $idCita,
            ':accion' => $accion,
            ':usuario_responsable' => $usuarioResponsable,
            ':detalle' => $detalle,
        ]);
    }

    public function historialPorCita(int $idCita): array
    {
        $sql = "SELECT * FROM historial_citas WHERE id_cita = :id_cita ORDER BY fecha_accion DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id_cita' => $idCita]);
        return $stmt->fetchAll();
    }

    public function countHoy(): int
    {
        $sql = "SELECT COUNT(*) total FROM {$this->table} WHERE fecha = CURDATE()";
        return (int)$this->conn->query($sql)->fetch()['total'];
    }

    public function countCanceladas(): int
    {
        $sql = "SELECT COUNT(*) total FROM {$this->table} WHERE estado_cita = 'cancelada'";
        return (int)$this->conn->query($sql)->fetch()['total'];
    }

    public function listarRecientes(int $limit = 5): array
    {
        $sql = "SELECT c.*, p.identidad, m.colegiado
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN medicos m ON c.id_medico = m.id_medico
                ORDER BY c.fecha DESC, c.hora DESC
                LIMIT {$limit}";
        return $this->conn->query($sql)->fetchAll();
    }
}