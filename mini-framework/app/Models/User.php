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
        error_log("UserID: " . $userId);
        
        try {
            // ORDEN IMPORTANTE: Eliminar en orden inverso de dependencias
            
            // 1. Obtener todos los posts del usuario
            $posts = $this->db->query("SELECT post_id FROM Posts WHERE user_id = ?", [$userId])->fetchAll();
            
            // 2. Eliminar comentarios de esos posts
            foreach ($posts as $post) {
                $this->db->query("DELETE FROM Comments WHERE post_id = ?", [$post['post_id']]);
                error_log("Eliminados comentarios del post: " . $post['post_id']);
            }
            
            // 3. Eliminar calificaciones (ratings) de los posts del usuario
            foreach ($posts as $post) {
                $this->db->query("DELETE FROM Ratings WHERE post_id = ?", [$post['post_id']]);
                error_log("Eliminadas calificaciones del post: " . $post['post_id']);
            }
            
            // 4. Eliminar PostTags de los posts del usuario
            foreach ($posts as $post) {
                $this->db->query("DELETE FROM PostTags WHERE post_id = ?", [$post['post_id']]);
                error_log("Eliminados tags del post: " . $post['post_id']);
            }
            
            // 5. Eliminar los posts del usuario
            $this->db->query("DELETE FROM Posts WHERE user_id = ?", [$userId]);
            error_log("Eliminados posts del usuario");
            
            // 6. Eliminar comentarios hechos por el usuario en otros posts
            $this->db->query("DELETE FROM Comments WHERE user_id = ?", [$userId]);
            error_log("Eliminados comentarios del usuario");
            
            // 7. Eliminar calificaciones hechas por el usuario
            $this->db->query("DELETE FROM Ratings WHERE user_id = ?", [$userId]);
            error_log("Eliminadas calificaciones del usuario");
            
            // 8. Eliminar password resets
            $this->db->query("DELETE FROM password_resets WHERE user_id = ?", [$userId]);
            error_log("Eliminados password resets");
            
            // 9. Finalmente, eliminar el usuario
            $query = "DELETE FROM {$this->table} WHERE user_id = ?";
            $stmt = $this->db->query($query, [$userId]);
            $affected = $stmt->rowCount();
            
            error_log("Usuario eliminado. Filas afectadas: " . $affected);
            error_log("=== FIN ELIMINACION EXITOSA ===");
            
            return $affected > 0;
            
        } catch (\Exception $e) {
            error_log("ERROR AL ELIMINAR USUARIO: " . $e->getMessage());
            error_log("Trace: " . $e->getTraceAsString());
            return false;
        }
    }
	public function actualizarPerfil($userId, $data) {
    $query = "UPDATE {$this->table} 
              SET username = ?, apellido = ?, email = ?, cedula = ?, pais = ?, ciudad = ?
              WHERE user_id = ?";
    
    $result = $this->db->query($query, [
        $data['username'],
        $data['apellido'],
        $data['email'],
        $data['cedula'],
        $data['pais'],
        $data['ciudad'],
        $userId
    ]);
    
    return $result->rowCount() > 0;
}
}
