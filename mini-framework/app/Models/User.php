<?php
namespace App\Models;

use App\Core\Model;

class User extends Model {
    protected $table = 'Users';

    public function findByEmail($email) {
        $query = $this->db->query(
            "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1", 
            [$email]
        );
        return $query->fetch();
    }
    
    public function findByCedula($cedula) {
        $query = $this->db->query(
            "SELECT * FROM {$this->table} WHERE cedula = ? LIMIT 1", 
            [$cedula]
        );
        return $query->fetch();
    }
    
    public function crear($data) {
        $query = "INSERT INTO {$this->table} 
                  (username, apellido, email, cedula, pais, ciudad, password, rol, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $result = $this->db->query($query, [
            $data['username'],
            $data['apellido'],
            $data['email'],
            $data['cedula'],
            $data['pais'],
            $data['ciudad'],
            $data['password'],
            $data['rol'] ?? 'usuario'
        ]);
        
        if ($result) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    public function actualizarPassword($userId, $hashedPassword) {
        $query = "UPDATE {$this->table} SET password = ? WHERE user_id = ?";
        
        $result = $this->db->query($query, [$hashedPassword, $userId]);
        
        return $result->rowCount() > 0;
    }
    
    public function find($userId) {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table} WHERE user_id = ? LIMIT 1", 
            [$userId]
        );
        
        if ($stmt) {
            return $stmt->fetch();
        }
        
        return false;
    }
    
    public function actualizar($userId, $data) {
        $query = "UPDATE {$this->table} 
                  SET username = ?, email = ?, apellido = ?, cedula = ?, pais = ?, ciudad = ?, rol = ?
                  WHERE user_id = ?";
        
        $result = $this->db->query($query, [
            $data['username'],
            $data['email'],
            $data['apellido'],
            $data['cedula'],
            $data['pais'],
            $data['ciudad'],
            $data['rol'],
            $userId
        ]);
        
        return $result->rowCount() > 0;
    }
    
    public function eliminar($userId) {
        error_log("=== ELIMINANDO USUARIO ===");
        error_log("UserID tipo: " . gettype($userId));
        error_log("UserID valor: '" . $userId . "'");
        error_log("UserID var_export: " . var_export($userId, true));
        
        try {
            // Eliminar registros relacionados primero
            $this->db->query("DELETE FROM password_resets WHERE user_id = ?", [$userId]);
            $this->db->query("DELETE FROM Comments WHERE user_id = ?", [$userId]);
            $this->db->query("DELETE FROM Posts WHERE user_id = ?", [$userId]);
            
            // Eliminar usuario
            $query = "DELETE FROM {$this->table} WHERE user_id = ?";
            error_log("Query: " . $query);
            error_log("Parametros: " . var_export([$userId], true));
            
            $stmt = $this->db->query($query, [$userId]);
            $affected = $stmt->rowCount();
            
            error_log("Filas afectadas: " . $affected);
            error_log("=== FIN ELIMINACION ===");
            
            return $affected > 0;
        } catch (\Exception $e) {
            error_log("ERROR EXCEPTION: " . $e->getMessage());
            return false;
        }
    }
}
