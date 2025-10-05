<?php
namespace App\Middleware;

use App\Core\Middleware;

class AdminMiddleware extends Middleware {
    public function handle() {
        // Verificar si el usuario está autenticado
        if (!$this->auth->check()) {
            $this->session->flash('error', 'Debes iniciar sesión para acceder');
            $this->redirect('/login');
            return false;
        }
        
        // Obtener el usuario actual
        $user = $this->auth->user();
        
        // Verificar si el usuario es admin
        if (!isset($user['rol']) || $user['rol'] !== 'admin') {
            $this->session->flash('error', 'No tienes permisos para acceder a esta página. Solo administradores.');
            $this->redirect('/dashboard');
            return false;
        }
        
        return true;
    }
}
