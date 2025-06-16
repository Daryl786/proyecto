<?php

namespace App\Controllers;
use App\Core\Controller;



class MinuevoController extends Controller{

	private $mititulo;


	public function index($parmts){

	$parmts = count($parmts)==0?["id" => 33]:$parmts;

		$datos=["mititulo" => "Aca pongo un titulo" , "miotrodato" => "id del Parametro es {$parmts['id']}"];

	return 	$this->render("minuevo/index", $datos);

	}


}
