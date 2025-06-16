<?php
namespace App\Core;


/**
 * Clase Middleware - Clase base para todos los middleware
 * 
 * Esta clase se encarga de:
 * - Proporcionar una estructura base para todos los middleware
 * - Definir el contrato que deben implementar los middleware
 */
abstract class Middleware {
    /**
     * @var Session Instancia de la clase Session
     */
    protected $session;
    
    /**
     * @var Auth Instancia de la clase Auth
     */
    protected $auth;
    
    /**
     * Constructor
     * Obtiene dependencias del contenedor
     */
    public function __construct() {
        $this->session = Container::get("session");
        $this->auth = Container::get("auth");
    }
    
    /**
     * Método que deben implementar todos los middleware
     * 
     * @return mixed
     */
    abstract public function handle();
    
    /**
     * Redirige a una URL específica
     * 
     * @param string $url URL de destino
     * @return void
     */
    protected function redirect($url) {
        header("Location: " . $url);
        exit;
    }
}
