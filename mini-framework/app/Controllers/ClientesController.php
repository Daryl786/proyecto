<?php 

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Clientes;

class ClientesController extends Controller{

private $modelo;


public function __construct(){
$this->modelo = new Clientes();

parent::__construct();

}


public function index(){
/*
$insertar = [
"rut" => 32132,
"razonsocial" => "Trabucatti S.R.L",
"calle" => "25 de mayo",
"numero" => 683,
"telefono" => "091123123",
"email" => "info@trabucatti.com"
];
$this->modelo->create($insertar);
*/

$datos = $this->modelo->clientesTodos();
return $this->render( "clientes/index",["clientes" =>  $datos]);

}


}
