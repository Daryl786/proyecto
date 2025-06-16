<?php
namespace App\Middleware;

use App\Core\Middleware;

class AuthMiddleware extends Middleware {
    /**
     * Verifica si el usuario está autenticado
     * Si no lo está, redirige al login
     *
     * @return void
     */
    public function handle() {
        if (!$this->auth->check()) {
            $this->session->flash('error', 'Debes iniciar sesión para acceder a esta página');
            $this->redirect('/login');
        }
    }
}
