<?php
namespace App\Core;


/**
 * Clase Session - Maneja la sesión de PHP
 * 
 * Esta clase se encarga de:
 * - Iniciar y gestionar sesiones
 * - Almacenar y recuperar datos de sesión
 * - Proporcionar un sistema de mensajes flash
 */
class Session {
    /**
     * Constructor - Inicia la sesión si no está activa
     */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            // Configurar cookie segura para sesión
            $cookieParams = session_get_cookie_params();
            session_set_cookie_params(
                $cookieParams["lifetime"],
                $cookieParams["path"],
                $cookieParams["domain"],
                isset($_SERVER["HTTPS"]), // Secure
                true // HttpOnly
            );
            
            session_start();
        }
    }

    /**
     * Establece un valor en la sesión
     * 
     * @param string $key Clave
     * @param mixed $value Valor
     * @return void
     */
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Obtiene un valor de la sesión
     * 
     * @param string $key Clave
     * @param mixed $default Valor por defecto
     * @return mixed Valor encontrado o valor por defecto
     */
    public function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Verifica si existe una clave en la sesión
     * 
     * @param string $key Clave
     * @return bool True si existe
     */
    public function has($key) {
        return isset($_SESSION[$key]);
    }

    /**
     * Elimina una clave de la sesión
     * 
     * @param string $key Clave
     * @return void
     */
    public function remove($key) {
        unset($_SESSION[$key]);
    }

    /**
     * Destruye la sesión por completo
     * 
     * @return void
     */
    public function destroy() {
        $_SESSION = [];
        
        // Destruir la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                "",
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        session_destroy();
    }
    
    /**
     * Establece o recupera un mensaje flash
     * Los mensajes flash solo están disponibles para la siguiente solicitud
     * 
     * @param string $key Clave
     * @param mixed $value Valor (opcional)
     * @return mixed Valor del mensaje flash o null
     */
    public function flash($key, $value = null) {
        if ($value !== null) {
            $this->set("flash_{$key}", $value);
            return $value;
        }
        
        $value = $this->get("flash_{$key}");
        $this->remove("flash_{$key}");
        return $value;
    }
}
