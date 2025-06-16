<?php
namespace App\Controllers;

use App\Core\Controller;

class DashboardController extends Controller {
    public function index() {
      
        return $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'user' => $this->auth->user()
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
