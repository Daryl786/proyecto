<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Contratacion;

class DashboardController extends Controller {
    
    private $postModel;
    private $contratacionModel;
    
    public function __construct() {
        $this->postModel = new Post();
        $this->contratacionModel = new Contratacion();
        parent::__construct();
    }
    
    public function index() {
        // Verificar autenticación
        if (!$this->auth->check()) {
            $this->redirect('/login');
            return;
        }
        
        $user = $this->auth->user();
        
        // Finalizar contrataciones vencidas
        $this->contratacionModel->finalizarVencidas();
        
        // Obtener servicios publicados por el usuario
        $misServicios = $this->postModel->findByUserId($user['user_id']);
        $totalServicios = count($misServicios);
        
        // Obtener contrataciones del usuario (servicios que contrató)
        $misContrataciones = $this->contratacionModel->obtenerPorUsuario($user['user_id']);
        $totalContrataciones = count($misContrataciones);
        $contratacionesActivas = $this->contratacionModel->contarPorUsuario($user['user_id'], 'activo');
        
        // Obtener servicios contratados por otros usuarios (si es proveedor)
        $serviciosContratados = $this->contratacionModel->obtenerPorProveedor($user['user_id']);
        
        return $this->render('dashboard/index', [
            'title' => 'Mi Perfil',
            'user' => $user,
            'misServicios' => $misServicios,
            'totalServicios' => $totalServicios,
            'misContrataciones' => $misContrataciones,
            'totalContrataciones' => $totalContrataciones,
            'contratacionesActivas' => $contratacionesActivas,
            'serviciosContratados' => $serviciosContratados
        ]);
    }
    
    public function show($params = []) {
        if (!$this->auth->check()) {
            $this->redirect('/login');
        }

        return $this->render('dashboard/show', [
            'title' => 'Usuario',
            'user' => $this->auth->user(),
            'userId' => $params['id'] ?? null
        ]);
    }
}
