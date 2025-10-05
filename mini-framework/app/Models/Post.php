<?php

namespace App\Models;
use App\Core\Model;

class Post extends Model{

	public function __construct(){
		$this->table = "Posts";
		$this->primaryKey = "post_id";
		parent::__construct();
	}
	
	public function eliminar($postId) {
    try {
        // Eliminar registros relacionados en orden correcto
        $this->db->query("DELETE FROM Comments WHERE post_id = ?", [$postId]);
        $this->db->query("DELETE FROM PostTags WHERE post_id = ?", [$postId]); // Nueva línea
        
        // Eliminar el post
        $query = "DELETE FROM {$this->table} WHERE post_id = ?";
        $stmt = $this->db->query($query, [$postId]);
        
        return $stmt->rowCount() > 0;
    } catch (\Exception $e) {
        error_log("Error al eliminar post ID $postId: " . $e->getMessage());
        return false;
    }
}
	public function crear($data) {
    $query = "INSERT INTO {$this->table} 
              (title, content, category_id, user_id, created_at, updated_at) 
              VALUES (?, ?, ?, ?, NOW(), NOW())";
    
    $result = $this->db->query($query, [
        $data['title'],
        $data['content'],
        $data['category_id'],
        $data['user_id']
    ]);
    
    if ($result) {
        return $this->db->lastInsertId();
    }
    
    return false;
}
	public function findByUserId($userId) {
    $query = "SELECT p.*, c.name as categoria_nombre 
              FROM {$this->table} p 
              LEFT JOIN Categories c ON p.category_id = c.category_id 
              WHERE p.user_id = ? 
              ORDER BY p.created_at DESC";
    
    $stmt = $this->db->query($query, [$userId]);
    return $stmt->fetchAll();
}
}
