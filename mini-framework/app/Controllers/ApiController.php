<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Api;

class ApiController extends Controller{

	 private $modelo;		

    public function __construct(){
		$this->modelo = new Api();
		parent::__construct();
	}

public function index() {

    if ( isset( $_POST["miDato"] ) ) {
        // Asegúrate de usar $miDato en tu código si lo necesitas
        $miDato = $_POST["miDato"];

        // Establece la cabecera antes de imprimir cualquier cosa
        header('Content-Type: application/json');
        // Lógica para buscar en la base de datos

          $datos = $this->modelo->find(["name" => $miDato]);

		  if ( isset( $datos["name"])){

			$sql = sprintf("SELECT * FROM Posts WHERE  category_id =  %s " , $datos["category_id"])   ;	
			$datos = $this->modelo->executeRawQuery($sql);

			}else{
			
			$datos = [ 
					[ "name" => "No existe la categoria" ]				
			];
		}

        $response = [
            'status' => 'success',
            'message' => 'Datos obtenidos correctamente.',
            'data' => [
               $datos
            ]
        ];

        echo json_encode($response);
        exit(); // Es crucial para detener la ejecución y evitar que la vista se renderice
    } else {
        // Lógica para peticiones GET que renderizan la vista
        $datos = $this->modelo->all();
        $this->render("api/index", ["titulo" => "Categorias: Mostrar Articulos", "datosTabla" => $datos]);
    }
}


}
