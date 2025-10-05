<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

class DashboardController extends Controller {
    public function index() {
        // Verificar autenticación
        if (!$this->auth->check()) {
            $this->redirect('/login');
            return;
        }
        
        $user = $this->auth->user();
        
        // Obtener servicios del usuario
        $postModel = new Post();
        $misServicios = $postModel->findByUserId($user['user_id']);
        
        // Estadísticas básicas
        $totalServicios = count($misServicios);
        
        return $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'user' => $user,
            'misServicios' => $misServicios,
            'totalServicios' => $totalServicios
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
