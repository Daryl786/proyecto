<?php
namespace App\Models;

use App\Core\Model;

class Minuevo extends Model {
    protected $table = 'productos';

    public function getUltimos($limite = 3) {
        $sql = "SELECT * FROM {$this->table} ORDER BY nombreProducto";
        return $this->db->query($sql, [$limite])->fetchAll(\PDO::FETCH_ASSOC);
    }
}
