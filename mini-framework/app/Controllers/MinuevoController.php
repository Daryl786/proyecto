<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Minuevo;

class MinuevoController extends Controller{
    private $mititulo;
    
    public function index($parmts){
        $parmts = count($parmts)==0?["id" => 33]:$parmts;
        
        try {
            // Instanciar el modelo
            $productoModel = new Minuevo();
            $productos = $productoModel->getUltimos(3);
            
            $datos = [
                "mititulo" => "Últimos Productos", 
                "miotrodato" => "id del Parametro es {$parmts['id']}",
                "productos" => $productos
            ];
            
        } catch (\Exception $e) {
            $datos = [
                "mititulo" => "Error al cargar productos", 
                "miotrodato" => "Error: " . $e->getMessage(),
                "productos" => []
            ];
        }
        
        return $this->render("minuevo/index", $datos);
    }
}
