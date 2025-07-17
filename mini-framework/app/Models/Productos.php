<?php
namespace App\Models;

use App\Core\Model;

class Productos extends Model {
    protected $table = 'productos';

    public function getUltimos($limite = 3) {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ?";
        return $this->db->query($sql, [$limite])->fetchAll(\PDO::FETCH_ASSOC);
    }
}

