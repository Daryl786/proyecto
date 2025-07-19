<?php

namespace App\Models;
use App\Core\Model;

class Categoria extends Model {
    
    public function getAll() {
        $sql = "SELECT c.*, COUNT(s.id) as total_servicios 
                FROM categorias c 
                LEFT JOIN servicios s ON c.id = s.categoria_id AND s.estado = 'activo'
                GROUP BY c.id 
                ORDER BY c.nombre";
        return $this->db->query($sql)->fetchAll();
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM categorias WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getAllSimple() {
        $sql = "SELECT id, nombre FROM categorias ORDER BY nombre";
        return $this->db->query($sql)->fetchAll();
    }
}
