<?php

namespace App\Models;
use App\Core\Model;

class Contratacion extends Model {
    
    public function __construct() {
        $this->table = "Contrataciones";
        $this->primaryKey = "contratacion_id";
        parent::__construct();
    }
    
    /**
     * Crea una nueva contratación
     */
    public function crear($postId, $userId, $fechaFinalizacion, $notas = null) {
        $query = "INSERT INTO {$this->table} 
                  (post_id, user_id, fecha_finalizacion, estado, notas) 
                  VALUES (?, ?, ?, 'activo', ?)";
        
        $result = $this->db->query($query, [
            $postId,
            $userId,
            $fechaFinalizacion,
            $notas
        ]);
        
        if ($result) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Verifica si un usuario ya contrató un servicio (activo)
     */
    public function usuarioYaContrato($postId, $userId) {
        $query = "SELECT COUNT(*) as total 
                  FROM {$this->table} 
                  WHERE post_id = ? AND user_id = ? AND estado = 'activo'";
        
        $stmt = $this->db->query($query, [$postId, $userId]);
        $result = $stmt->fetch();
        
        return $result['total'] > 0;
    }
    
    /**
     * Obtiene todas las contrataciones de un usuario
     */
    public function obtenerPorUsuario($userId) {
        $query = "SELECT c.*, p.title, p.content, p.precio, p.duracion, 
                  p.nombre_empresa, cat.name as categoria_nombre,
                  u.username as proveedor_username, u.apellido as proveedor_apellido,
                  DATEDIFF(c.fecha_finalizacion, NOW()) as dias_restantes
                  FROM {$this->table} c
                  INNER JOIN Posts p ON c.post_id = p.post_id
                  LEFT JOIN Categories cat ON p.category_id = cat.category_id
                  INNER JOIN Users u ON p.user_id = u.user_id
                  WHERE c.user_id = ?
                  ORDER BY c.fecha_contratacion DESC";
        
        $stmt = $this->db->query($query, [$userId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene las contrataciones activas de un usuario
     */
    public function obtenerActivasPorUsuario($userId) {
        $query = "SELECT c.*, p.title, p.content, p.precio, p.duracion,
                  DATEDIFF(c.fecha_finalizacion, NOW()) as dias_restantes
                  FROM {$this->table} c
                  INNER JOIN Posts p ON c.post_id = p.post_id
                  WHERE c.user_id = ? AND c.estado = 'activo'
                  ORDER BY c.fecha_finalizacion ASC";
        
        $stmt = $this->db->query($query, [$userId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Cuenta las contrataciones de un usuario por estado
     */
    public function contarPorUsuario($userId, $estado = null) {
        if ($estado) {
            $query = "SELECT COUNT(*) as total 
                      FROM {$this->table} 
                      WHERE user_id = ? AND estado = ?";
            $stmt = $this->db->query($query, [$userId, $estado]);
        } else {
            $query = "SELECT COUNT(*) as total 
                      FROM {$this->table} 
                      WHERE user_id = ?";
            $stmt = $this->db->query($query, [$userId]);
        }
        
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    /**
     * Actualiza el estado de una contratación
     */
    public function actualizarEstado($contratacionId, $estado) {
        $query = "UPDATE {$this->table} 
                  SET estado = ? 
                  WHERE contratacion_id = ?";
        
        return $this->db->query($query, [$estado, $contratacionId]);
    }
    
    /**
     * Finaliza automáticamente las contrataciones vencidas
     */
    public function finalizarVencidas() {
        $query = "UPDATE {$this->table} 
                  SET estado = 'finalizado' 
                  WHERE estado = 'activo' 
                  AND fecha_finalizacion < NOW()";
        
        return $this->db->query($query);
    }
    
    /**
     * Obtiene los servicios contratados de un proveedor
     */
    public function obtenerPorProveedor($proveedorUserId) {
        $query = "SELECT c.*, p.title, 
                  u.username as cliente_username, u.apellido as cliente_apellido, u.email as cliente_email,
                  DATEDIFF(c.fecha_finalizacion, NOW()) as dias_restantes
                  FROM {$this->table} c
                  INNER JOIN Posts p ON c.post_id = p.post_id
                  INNER JOIN Users u ON c.user_id = u.user_id
                  WHERE p.user_id = ?
                  ORDER BY c.fecha_contratacion DESC";
        
        $stmt = $this->db->query($query, [$proveedorUserId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Cancela una contratación
     */
    public function cancelar($contratacionId, $userId) {
        // Verificar que la contratación pertenece al usuario y está activa
        $query = "SELECT * FROM {$this->table} 
                  WHERE contratacion_id = ? AND user_id = ? AND estado = 'activo'";
        $stmt = $this->db->query($query, [$contratacionId, $userId]);
        $contratacion = $stmt->fetch();
        
        if (!$contratacion) {
            return false;
        }
        
        // Actualizar estado a cancelado
        $updateQuery = "UPDATE {$this->table} 
                       SET estado = 'cancelado' 
                       WHERE contratacion_id = ?";
        
        return $this->db->query($updateQuery, [$contratacionId]);
    }
    
    /**
     * Verifica si una contratación puede ser cancelada
     * Regla: Solo se puede cancelar si han pasado menos de 48 horas desde la contratación
     */
    public function puedeCancelar($contratacionId, $userId) {
        $query = "SELECT *, 
                  TIMESTAMPDIFF(HOUR, fecha_contratacion, NOW()) as horas_transcurridas
                  FROM {$this->table} 
                  WHERE contratacion_id = ? AND user_id = ? AND estado = 'activo'";
        
        $stmt = $this->db->query($query, [$contratacionId, $userId]);
        $contratacion = $stmt->fetch();
        
        if (!$contratacion) {
            return ['puede' => false, 'razon' => 'Contratación no encontrada o ya finalizada'];
        }
        
        // Verificar las 48 horas desde la contratación
        if ($contratacion['horas_transcurridas'] > 48) {
            return [
                'puede' => false, 
                'razon' => 'Solo puedes cancelar dentro de las primeras 48 horas de la contratación',
                'horas_transcurridas' => $contratacion['horas_transcurridas']
            ];
        }
        
        return [
            'puede' => true, 
            'razon' => 'Puede cancelar',
            'horas_restantes' => 48 - $contratacion['horas_transcurridas']
        ];
    }
    
    /**
     * Obtiene una contratación específica
     */
    public function obtenerPorId($contratacionId) {
        $query = "SELECT * FROM {$this->table} WHERE contratacion_id = ? LIMIT 1";
        $stmt = $this->db->query($query, [$contratacionId]);
        return $stmt->fetch();
    }
    
    /**
     * NUEVO: Elimina una contratación cancelada
     */
    public function eliminar($contratacionId, $userId) {
        // Verificar que la contratación pertenece al usuario y está cancelada
        $query = "SELECT * FROM {$this->table} 
                  WHERE contratacion_id = ? AND user_id = ? AND estado = 'cancelado'";
        $stmt = $this->db->query($query, [$contratacionId, $userId]);
        $contratacion = $stmt->fetch();
        
        if (!$contratacion) {
            return false;
        }
        
        // Eliminar la contratación
        $deleteQuery = "DELETE FROM {$this->table} WHERE contratacion_id = ?";
        $result = $this->db->query($deleteQuery, [$contratacionId]);
        
        return $result->rowCount() > 0;
    }
/**
 * Verificar si un usuario ha contratado (finalizado o activo) un servicio
 */
public function usuarioHaContratado($postId, $userId) {
    $query = "SELECT COUNT(*) as total 
              FROM {$this->table} 
              WHERE post_id = ? AND user_id = ? AND estado IN ('activo', 'finalizado')";
    
    $stmt = $this->db->query($query, [$postId, $userId]);
    $result = $stmt->fetch();
    
    return $result['total'] > 0;
}
}
