<?php

namespace App\Models;
use App\Core\Model;

class Api extends Model{

	public function __construct(){
			$this->table = "Categories";
			$this->primaryKey = "category_id";

			parent::__construct();
	}



}
