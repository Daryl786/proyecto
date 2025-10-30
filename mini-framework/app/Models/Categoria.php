<?php

namespace App\Models;
use App\Core\Model;

class Categoria extends Model {

    public function __construct() {
        $this->table = "Categories";
        $this->primaryKey = "category_id";
        parent::__construct();
    }
    
    public function crear($data) {
        $query = "INSERT INTO {$this->table} (name, description, created_at) 
                  VALUES (?, ?, NOW())";
        
        $result = $this->db->query($query, [
            $data['name'],
            $data['description'] ?? null
        ]);
        
        if ($result) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    public function actualizar($categoryId, $data) {
        $query = "UPDATE {$this->table} 
                  SET name = ?, description = ? 
                  WHERE category_id = ?";
        
        $result = $this->db->query($query, [
            $data['name'],
            $data['description'] ?? null,
            $categoryId
        ]);
        
        return $result ? true : false;
    }
    
    public function eliminar($categoryId) {
        try {
            // Verificar si hay posts usando esta categoría
            $countQuery = "SELECT COUNT(*) as total FROM Posts WHERE category_id = ?";
            $stmt = $this->db->query($countQuery, [$categoryId]);
            $result = $stmt->fetch();
            
            if ($result['total'] > 0) {
                // No se puede eliminar si hay posts asociados
                return false;
            }
            
            // Eliminar PostTags relacionados (si existen)
            $this->db->query("DELETE FROM PostTags WHERE post_id IN (SELECT post_id FROM Posts WHERE category_id = ?)", [$categoryId]);
            
            // Eliminar la categoría
            $query = "DELETE FROM {$this->table} WHERE category_id = ?";
            $stmt = $this->db->query($query, [$categoryId]);
            
            return $stmt->rowCount() > 0;
        } catch (\Exception $e) {
            error_log("Error al eliminar categoría ID $categoryId: " . $e->getMessage());
            return false;
        }
    }
    
    public function findById($categoryId) {
        $query = "SELECT * FROM {$this->table} WHERE category_id = ? LIMIT 1";
        $stmt = $this->db->query($query, [$categoryId]);
        return $stmt->fetch();
    }
    
    public function contarPosts($categoryId) {
        $query = "SELECT COUNT(*) as total FROM Posts WHERE category_id = ?";
        $stmt = $this->db->query($query, [$categoryId]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
