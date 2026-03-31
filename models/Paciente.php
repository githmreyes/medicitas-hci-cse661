<?php
declare(strict_types=1);

class Paciente
{
    private PDO $conn;
    private string $table = "pacientes";

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function crear(array $data): bool
    {
        $sql = "INSERT INTO {$this->table}
                (identidad, fecha_nacimiento, sexo, telefono, direccion, estado_civil)
                VALUES (:identidad, :fecha_nacimiento, :sexo, :telefono, :direccion, :estado_civil)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':identidad' => trim($data['identidad']),
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':sexo' => $data['sexo'],
            ':telefono' => trim($data['telefono']),
            ':direccion' => trim($data['direccion'] ?? ''),
            ':estado_civil' => trim($data['estado_civil'] ?? ''),
        ]);
    }

    public function listar(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id_paciente DESC";
        return $this->conn->query($sql)->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_paciente = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function actualizar(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET identidad = :identidad,
                    fecha_nacimiento = :fecha_nacimiento,
                    sexo = :sexo,
                    telefono = :telefono,
                    direccion = :direccion,
                    estado_civil = :estado_civil
                WHERE id_paciente = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':identidad' => trim($data['identidad']),
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':sexo' => $data['sexo'],
            ':telefono' => trim($data['telefono']),
            ':direccion' => trim($data['direccion'] ?? ''),
            ':estado_civil' => trim($data['estado_civil'] ?? ''),
            ':id' => $id,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id_paciente = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) total FROM {$this->table}";
        return (int)$this->conn->query($sql)->fetch()['total'];
    }
}