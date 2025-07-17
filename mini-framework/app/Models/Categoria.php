<?php

namespace App\Models;
use App\Core\Model;

class Categoria extends Model{
    
    public function getAll(){
        $sql = "SELECT * FROM categorias ORDER BY nombre";
        return $this->db->query($sql)->fetchAll();
    }
}
