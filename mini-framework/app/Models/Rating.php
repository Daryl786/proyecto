<?php

namespace App\Models;
use App\Core\Model;

class Rating extends Model {

    public function __construct() {
        $this->table = "Ratings";
        $this->primaryKey = "rating_id";
        parent::__construct();
    }
    
    // Crear o actualizar calificación
    public function guardarCalificacion($postId, $userId, $rating, $comment = null) {
        // Verificar si ya existe una calificación de este usuario para este post
        $existente = $this->find(['post_id' => $postId, 'user_id' => $userId]);
        
        if ($existente) {
            // Actualizar
            $query = "UPDATE {$this->table} SET rating = ?, comment = ?, updated_at = NOW() 
                      WHERE post_id = ? AND user_id = ?";
            $result = $this->db->query($query, [$rating, $comment, $postId, $userId]);
        } else {
            // Crear nueva
            $query = "INSERT INTO {$this->table} (post_id, user_id, rating, comment, created_at, updated_at) 
                      VALUES (?, ?, ?, ?, NOW(), NOW())";
            $result = $this->db->query($query, [$postId, $userId, $rating, $comment]);
        }
        
        return $result ? true : false;
    }
    
    // Obtener promedio de calificaciones de un post
    public function getPromedioPost($postId) {
        $query = "SELECT AVG(rating) as promedio, COUNT(*) as total 
                  FROM {$this->table} 
                  WHERE post_id = ?";
        $stmt = $this->db->query($query, [$postId]);
        return $stmt->fetch();
    }
    
    // Obtener todas las calificaciones de un post con información del usuario
    public function getCalificacionesPost($postId) {
        $query = "SELECT r.*, u.username, u.apellido 
                  FROM {$this->table} r 
                  LEFT JOIN Users u ON r.user_id = u.user_id 
                  WHERE r.post_id = ? 
                  ORDER BY r.created_at DESC";
        $stmt = $this->db->query($query, [$postId]);
        return $stmt->fetchAll();
    }
    
    // Verificar si un usuario ya calificó un post
    public function usuarioYaCalificó($postId, $userId) {
        $calificacion = $this->find(['post_id' => $postId, 'user_id' => $userId]);
        return $calificacion ? true : false;
    }
    
    // Obtener calificación de un usuario para un post
    public function getCalificacionUsuario($postId, $userId) {
        return $this->find(['post_id' => $postId, 'user_id' => $userId]);
    }
    
    // Eliminar calificación
    public function eliminarCalificacion($ratingId) {
        $query = "DELETE FROM {$this->table} WHERE rating_id = ?";
        $result = $this->db->query($query, [$ratingId]);
        return $result->rowCount() > 0;
    }
}
