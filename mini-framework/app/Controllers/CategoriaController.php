<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Categoria; 

class CategoriaController extends Controller{

    private $categoria;

    public function __construct(){
        $this->categoria = new Categoria();
        parent::__construct();
    } 

    // Método para mostrar la lista de categorías
    public function index(){
        $categorias = $this->categoria->getAll(); 
        
        // Cambiar view() por render()
        $this->render('categorias/index', [
            'categorias' => $categorias
        ]);
    }
}
