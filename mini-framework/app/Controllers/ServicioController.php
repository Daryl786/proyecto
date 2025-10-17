<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Servicio;
use App\Models\Categoria;

class ServicioController extends Controller {
    
    private $servicio;
    private $categoria;
    
    public function __construct() {
        $this->servicio = new Servicio();
        $this->categoria = new Categoria();
        parent::__construct();
    }
    
    // Mostrar todos los servicios
    public function index() {
        $servicios = $this->servicio->getAll();
        
        $this->render('servicios/index', [
            'servicios' => $servicios,
            'titulo' => 'Todos los Servicios'
        ]);
    }
    
    // Mostrar servicios por categoría
    public function porCategoria($categoria_id) {
        $servicios = $this->servicio->getByCategoria($categoria_id);
        $categoria = $this->categoria->getById($categoria_id);
        
        $this->render('servicios/index', [
            'servicios' => $servicios,
            'categoria' => $categoria,
            'titulo' => 'Servicios de ' . ($categoria ? $categoria['nombre'] : 'Categoría')
        ]);
    }
    
    // Mostrar formulario para crear servicio
    public function crear() {
        $categorias = $this->categoria->getAll();
        
        $this->render('servicios/crear', [
            'categorias' => $categorias
        ]);
    }
    
    // Procesar creación de servicio
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errores = $this->validarDatos($_POST);
            
            if (empty($errores)) {
                $datos = [
                    'nombre' => trim($_POST['nombre']),
                    'descripcion' => trim($_POST['descripcion']),
                    'precio' => floatval($_POST['precio']),
                    'categoria_id' => intval($_POST['categoria_id']),
                    'usuario_creador' => 'usuario' // Aquí puedes usar el usuario autenticado
                ];
                
                if ($this->servicio->crear($datos)) {
                    $_SESSION['success'] = 'Servicio creado exitosamente';
                    header('Location: /servicios');
                    exit;
                } else {
                    $_SESSION['error'] = 'Error al crear el servicio';
                }
            } else {
                $_SESSION['errores'] = $errores;
                $_SESSION['form_data'] = $_POST;
            }
        }
        
        header('Location: /servicios/crear');
        exit;
    }
    
    // Mostrar un servicio específico
    public function show($id) {
        $servicio = $this->servicio->getById($id);
        
        if (!$servicio) {
            $_SESSION['error'] = 'Servicio no encontrado';
            header('Location: /servicios');
            exit;
        }
        
        $this->render('servicios/show', [
            'servicio' => $servicio
        ]);
    }
    
    // Validar datos del formulario
    private function validarDatos($datos) {
        $errores = [];
        
        if (empty(trim($datos['nombre']))) {
            $errores['nombre'] = 'El nombre del servicio es requerido';
        }
        
        if (empty(trim($datos['descripcion']))) {
            $errores['descripcion'] = 'La descripción es requerida';
        }
        
        if (!isset($datos['precio']) || !is_numeric($datos['precio']) || floatval($datos['precio']) < 0) {
            $errores['precio'] = 'El precio debe ser un número válido mayor o igual a 0';
        }
        
        if (empty($datos['categoria_id']) || !is_numeric($datos['categoria_id'])) {
            $errores['categoria_id'] = 'Debe seleccionar una categoría válida';
        }
        
        return $errores;
    }
}
