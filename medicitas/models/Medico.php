<?php
declare(strict_types=1);

class Medico
{
    private PDO $conn;
    private string $table = "medicos";

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function crear(array $data): bool
    {
        $sql = "INSERT INTO {$this->table}
                (id_especialidad, colegiado, telefono, consultorio, estado)
                VALUES (:id_especialidad, :colegiado, :telefono, :consultorio, :estado)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id_especialidad' => $data['id_especialidad'],
            ':colegiado' => trim($data['colegiado']),
            ':telefono' => trim($data['telefono'] ?? ''),
            ':consultorio' => trim($data['consultorio'] ?? ''),
            ':estado' => $data['estado'],
        ]);
    }

    public function listar(): array
    {
        $sql = "SELECT m.*, e.nombre AS especialidad
                FROM {$this->table} m
                INNER JOIN especialidades e ON m.id_especialidad = e.id_especialidad
                ORDER BY m.id_medico DESC";
        return $this->conn->query($sql)->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_medico = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function actualizar(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET id_especialidad = :id_especialidad,
                    colegiado = :colegiado,
                    telefono = :telefono,
                    consultorio = :consultorio,
                    estado = :estado
                WHERE id_medico = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id_especialidad' => $data['id_especialidad'],
            ':colegiado' => trim($data['colegiado']),
            ':telefono' => trim($data['telefono'] ?? ''),
            ':consultorio' => trim($data['consultorio'] ?? ''),
            ':estado' => $data['estado'],
            ':id' => $id,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id_medico = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) total FROM {$this->table}";
        return (int)$this->conn->query($sql)->fetch()['total'];
    }

    public function listarEspecialidades(): array
    {
        return $this->conn->query("SELECT * FROM especialidades ORDER BY nombre ASC")->fetchAll();
    }
}