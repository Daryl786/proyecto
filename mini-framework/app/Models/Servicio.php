<?php

namespace App\Models;
use App\Core\Model;

class Servicio extends Model {
    
    public function getAll() {
        $sql = "SELECT s.*, c.nombre as categoria_nombre 
                FROM servicios s 
                JOIN categorias c ON s.categoria_id = c.id 
                WHERE s.estado = 'activo'
                ORDER BY s.created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }
    
    public function getByCategoria($categoria_id) {
        $sql = "SELECT s.*, c.nombre as categoria_nombre 
                FROM servicios s 
                JOIN categorias c ON s.categoria_id = c.id 
                WHERE s.categoria_id = :categoria_id AND s.estado = 'activo'
                ORDER BY s.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $sql = "SELECT s.*, c.nombre as categoria_nombre 
                FROM servicios s 
                JOIN categorias c ON s.categoria_id = c.id 
                WHERE s.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function crear($datos) {
        $sql = "INSERT INTO servicios (nombre, descripcion, precio, categoria_id, usuario_creador) 
                VALUES (:nombre, :descripcion, :precio, :categoria_id, :usuario_creador)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':precio' => $datos['precio'],
            ':categoria_id' => $datos['categoria_id'],
            ':usuario_creador' => $datos['usuario_creador']
        ]);
    }
    
    public function actualizar($id, $datos) {
        $sql = "UPDATE servicios 
                SET nombre = :nombre, descripcion = :descripcion, 
                    precio = :precio, categoria_id = :categoria_id 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':precio' => $datos['precio'],
            ':categoria_id' => $datos['categoria_id']
        ]);
    }
    
    public function eliminar($id) {
        $sql = "UPDATE servicios SET estado = 'inactivo' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
