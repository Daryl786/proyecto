<?php
namespace App\Core;


class Database {
    private static $instance;
    private $connection;

    private function __construct() {
        $config = require BASE_PATH . "/config/database.php";
        $dsn = "{$config["driver"]}:host={$config["host"]};dbname={$config["database"]};charset={$config["charset"]}";
        
        try {
            $this->connection = new \PDO(
                $dsn,
                $config["username"],
                $config["password"],
                $config["options"] ?? []
            );
        } catch (\PDOException $e) {
            throw new \Exception("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
}
