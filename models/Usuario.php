<?php
declare(strict_types=1);

class Usuario
{
    private PDO $conn;
    private string $table = "usuarios";

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function findByCorreo(string $correo): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE correo = :correo AND estado = 'activo' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $row = $stmt->fetch();

        return $row ?: null;
    }
}