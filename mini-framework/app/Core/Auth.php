<?php
namespace App\Core;

/**
 * Clase Auth - Maneja la autenticación de usuarios
 * 
 * Esta clase se encarga de:
 * - Autenticar usuarios contra la base de datos
 * - Mantener el estado de sesión del usuario
 * - Proporcionar métodos para verificar la autenticación
 */
class Auth {
    /**
     * @var Session Instancia de la clase Session
     */
    protected $session;
    
    /**
     * @var \App\Models\User Instancia del modelo User
     */
    protected $userModel;

    /**
     * Constructor
     * 
     * @param Session $session Instancia de la clase Session
     * @param \App\Models\User $userModel Instancia del modelo User
     */
    public function __construct(Session $session, \App\Models\User $userModel) {
        $this->session = $session;
        $this->userModel = $userModel;
    }

    /**
     * Intenta autenticar al usuario
     * 
     * @param string $email Email del usuario
     * @param string $password Contraseña sin encriptar
     * @return bool True si la autenticación fue exitosa
     */
    public function attempt($email, $password) {
        $user = $this->userModel->findByEmail($email);

        // CAMBIAR  if ($user && password_verify($password, $user["password"])) {
       if ($user && $password === $user["password"]) {

            // No almacenar la contraseña en la sesión
            unset($user["password"]);
            
            $this->session->set("user", $user);
            return true;
        }
        
        return false;
    }

    /**
     * Registra un nuevo usuario
     * 
     * @param array $userData Datos del usuario (nombre, email, password)
     * @return int|bool ID del usuario creado o false si falla
     */
    public function register($userData) {
        // Encriptar la contraseña
        $userData["password"] = password_hash($userData["password"], PASSWORD_DEFAULT);
        
        // Crear el usuario
        return $this->userModel->create($userData);
    }

    /**
     * Obtiene el usuario autenticado
     * 
     * @return array|null Datos del usuario o null si no está autenticado
     */
    public function user() {
        return $this->session->get("user");
    }

    /**
     * Verifica si el usuario está autenticado
     * 
     * @return bool True si está autenticado
     */
    public function check() {
        return $this->session->has("user");
    }

    /**
     * Cierra la sesión del usuario
     * 
     * @return void
     */
    public function logout() {
        $this->session->remove("user");
    }
}
