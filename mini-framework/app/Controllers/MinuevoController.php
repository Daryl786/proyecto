<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Productos;

class MinuevoController extends Controller{
    private $mititulo;
    
    public function index($parmts){
        $parmts = count($parmts)==0?["id" => 33]:$parmts;
        
        // Aquí instancias y usas el modelo
        $productoModel = new Productos();
	$productos = $productoModel->getUltimos(3);
        
        $datos = [
            "mititulo" => "Aca pongo un titulo", 
            "miotrodato" => "id del Parametro es {$parmts['id']}",
            "productos" => $productos  // Pasar los productos a la vista
        ];
        
        return $this->render("minuevo/index", $datos);
    }
}
