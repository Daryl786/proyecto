<?php
namespace App\Core;

/**
 * Clase Controller - Clase base para todos los controladores
 * 
 * Esta clase se encarga de:
 * - Proporcionar métodos comunes para todos los controladores
 * - Manejar la vista, solicitudes y autenticación
 */
abstract class Controller {
    /**
     * @var View Instancia de la clase View
     */
    protected $view;
    
    /**
     * @var array Datos de la solicitud actual
     */
    protected $request;
    
    /**
     * @var Auth Instancia de la clase Auth
     */
    protected $auth;
    
    /**
     * @var Session Instancia de la clase Session
     */
    protected $session;

    /**
     * Constructor
     * Obtiene dependencias del contenedor
     */
    public function __construct() {
        $this->view = Container::get('view');
        $this->request = Container::get('request');
        $this->session = Container::get('session');
        $this->auth = Container::get('auth');
    }

    /**
     * Renderiza una vista
     * 
     * @param string $viewPath Ruta a la vista
     * @param array $data Datos para la vista
     * @return void
     */
    protected function render($viewPath, $data = []) {
        return $this->view->render($viewPath, $data);
    }

    /**
     * Redirige a una URL
     * 
     * @param string $url URL de destino
     * @return void
     */
    protected function redirect($url) {
        header("Location: " . $url);
        exit;
    }
    
    /**
     * Obtiene un valor de la solicitud (POST o GET)
     * 
     * @param string $key Clave a buscar
     * @param mixed $default Valor por defecto
     * @return mixed Valor encontrado o valor por defecto
     */
    protected function input($key, $default = null) {
        return $this->request["post"][$key] ?? $this->request["get"][$key] ?? $default;
    }
    
    /**
     * Valida los datos de entrada según reglas especificadas
     * 
     * @param array $rules Reglas de validación
     * @return array Array de errores (vacío si todo es válido)
     */
    protected function validate($rules) {
        $errors = [];
        
        foreach ($rules as $field => $ruleString) {
            $value = $this->input($field);
            $fieldRules = explode("|", $ruleString);
            
            foreach ($fieldRules as $rule) {
                // Regla required
                if ($rule === "required" && empty($value)) {
                    $errors[$field] = "El campo {$field} es obligatorio";
                    break; // Saltar a la siguiente regla si ésta falla
                }
                
                // Solo validar reglas adicionales si hay un valor o si es required
                if (!empty($value)) {
                    // Regla email
                    if ($rule ===  "email" && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field] = "El campo {$field} debe ser un email válido";
                        break;
                    }
                    
                    // Regla min:X
                    if (preg_match("/^min:(\d+)$/", $rule, $matches)) {
                        $min = (int)$matches[1];
                        if (strlen($value) < $min) {
                            $errors[$field] = "El campo {$field} debe tener al menos {$min} caracteres";
                            break;
                        }
                    }
                    
                    // Regla max:X
                    if (preg_match("/^max:(\d+)$/", $rule, $matches)) {
                        $max = (int)$matches[1];
                        if (strlen($value) > $max) {
                            $errors[$field] = "El campo {$field} no debe exceder {$max} caracteres";
                            break;
                        }
                    }
                }
            }
        }
        
        return $errors;
    }
}
