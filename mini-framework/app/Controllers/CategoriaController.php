<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Categoria;

class CategoriaController extends Controller {
    
    private $categoria;
    
    public function __construct() {
        $this->categoria = new Categoria();
        parent::__construct();
    }
    
    // Método para mostrar la lista de categorías
    public function index() {
        $categorias = $this->categoria->getAll(); 
        
        $this->render('categorias/index', [
            'categorias' => $categorias
        ]);
    }
    
    // Método para mostrar una categoría específica
    public function show($id) {
        $categoria = $this->categoria->getById($id);
        
        if (!$categoria) {
            $_SESSION['error'] = 'Categoría no encontrada';
            header('Location: /listado');
            exit;
        }
        
        // Redirigir a los servicios de esta categoría
        header("Location: /servicios/categoria/$id");
        exit;
    }
}
