<?php
namespace App\Models;

use App\Core\Model;

class Clientes extends Model {

    protected $table = 'clientes';
	protected $primaryKey='rut';


	public function clientesTodos(){

        return $this->all();

	}

    public function findByRut($rut) {
        $query = $this->db->query(
            "SELECT * FROM {$this->table} WHERE rut = ? LIMIT 1", 
            [$rut]
        );
        return $query->fetch();
    }
}
