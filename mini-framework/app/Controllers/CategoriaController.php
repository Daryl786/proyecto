<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Categoria;


class CategoriaController extends Controller{

		private $modelo;

	public function __construct(){
		$this->modelo = new Categoria();
		
		parent::__construct();
}

	public function index(){

		$datos = $this->modelo->all();

		$this->render("categoria/index", ["titulo" => "Las categorias", "datosTabla" => $datos]); 
	}


}
