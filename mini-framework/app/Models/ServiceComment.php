<?php

namespace App\Models;
use App\Core\Model;

class ServiceComment extends Model {

    public function __construct() {
        $this->table = "ServiceComments";
        $this->primaryKey = "comment_id";
        parent::__construct();
    }
    
    /**
     * Crear un nuevo comentario
     */
    public function crear($postId, $userId, $commentText) {
        $query = "INSERT INTO {$this->table} (post_id, user_id, comment_text, created_at, updated_at) 
                  VALUES (?, ?, ?, NOW(), NOW())";
        
        $result = $this->db->query($query, [$postId, $userId, $commentText]);
        
        if ($result) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Obtener todos los comentarios de un post con información del usuario
     */
    public function getComentariosPost($postId) {
        $query = "SELECT c.*, u.username, u.apellido, u.rol
                  FROM {$this->table} c
                  INNER JOIN Users u ON c.user_id = u.user_id
                  WHERE c.post_id = ?
                  ORDER BY c.created_at DESC";
        
        $stmt = $this->db->query($query, [$postId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Contar comentarios de un post
     */
    public function contarComentarios($postId) {
        $query = "SELECT COUNT(*) as total FROM {$this->table} WHERE post_id = ?";
        $stmt = $this->db->query($query, [$postId]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
    /**
     * Eliminar un comentario
     */
    public function eliminar($commentId, $userId = null, $isAdmin = false) {
        // Si es admin, puede eliminar cualquier comentario
        if ($isAdmin) {
            $query = "DELETE FROM {$this->table} WHERE comment_id = ?";
            $result = $this->db->query($query, [$commentId]);
            return $result->rowCount() > 0;
        }
        
        // Si no es admin, solo puede eliminar sus propios comentarios
        if ($userId) {
            $query = "DELETE FROM {$this->table} WHERE comment_id = ? AND user_id = ?";
            $result = $this->db->query($query, [$commentId, $userId]);
            return $result->rowCount() > 0;
        }
        
        return false;
    }
    
    /**
     * Verificar si un comentario pertenece a un usuario
     */
    public function perteneceAUsuario($commentId, $userId) {
        $query = "SELECT COUNT(*) as total FROM {$this->table} 
                  WHERE comment_id = ? AND user_id = ?";
        $stmt = $this->db->query($query, [$commentId, $userId]);
        $result = $stmt->fetch();
        return $result['total'] > 0;
    }
    
    /**
     * Obtener información de un comentario
     */
    public function obtenerPorId($commentId) {
        $query = "SELECT * FROM {$this->table} WHERE comment_id = ? LIMIT 1";
        $stmt = $this->db->query($query, [$commentId]);
        return $stmt->fetch();
    }
    
    /**
     * Obtener el post_id de un comentario
     */
    public function getPostId($commentId) {
        $query = "SELECT post_id FROM {$this->table} WHERE comment_id = ? LIMIT 1";
        $stmt = $this->db->query($query, [$commentId]);
        $result = $stmt->fetch();
        return $result['post_id'] ?? null;
    }
}
