<?php
declare(strict_types=1);

class Database
{
    private string $host = 'localhost';
    private string $dbName = 'medicitas_hci';
    private string $username = 'root';
    private string $password = '';
    public ?PDO $conn = null;

    public function getConnection(): ?PDO
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }

        return $this->conn;
    }
}