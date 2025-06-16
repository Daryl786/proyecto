<?php
namespace App\Models;

use App\Core\Model;

class User extends Model {
    protected $table = 'users';

    public function findByEmail($email) {
        $query = $this->db->query(
            "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1", 
            [$email]
        );
        return $query->fetch();
    }
}
