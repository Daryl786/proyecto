<?php
namespace App\Core;

/**
 * Clase Router - Maneja el enrutamiento y la ejecución de controladores
 * 
 * Esta clase se encarga de:
 * - Registrar rutas
 * - Comparar la URL actual con las rutas registradas
 * - Ejecutar los middleware asociados a la ruta
 * - Llamar al controlador y método correspondiente
 */
class Router {
    /**
     * @var array Colección de rutas registradas
     */
    protected $routes = [];
    
    /**
     * @var array Parámetros extraídos de la URL
     */
    protected $params = [];
    
    /**
     * @var View Instancia de la clase View
     */
    protected $view;
    
    /**
     * @var array Datos de la petición actual
     */
    protected $request;
    
    /**
     * Constructor
     * 
     * @param View $view Instancia de la clase View
     * @param array $request Datos de la petición actual
     */
    public function __construct(View $view, array $request) {
        $this->view = $view;
        $this->request = $request;
    }

    /**
     * Registra una nueva ruta
     * 
     * @param string $method Método HTTP (GET, POST, etc.)
     * @param string $uri Patrón de URL
     * @param mixed $handler Controlador@método o callable
     * @param array $middleware Lista de clases middleware
     * @return void
     */
    public function addRoute($method, $uri, $handler, $middleware = []) {
        $uri = trim($uri, "/");
        $uri = $uri ?: "home";
        
        // Convierte los parámetros tipo :id en expresiones regulares con grupos con nombre
        $pattern = preg_replace("~/:([a-zA-Z]+)~", "/(?P<\\1>[^/]+)", $uri);
        
        $this->routes[] = [
            "method" => strtoupper($method),
            "pattern" => "~^" . $pattern . "$~",
            "handler" => $handler,
            "middleware" => $middleware
        ];
    }

    /**
     * Procesa la solicitud actual y ejecuta el controlador correspondiente
     * 
     * @return mixed Resultado de la ejecución del controlador
     */
    public function dispatch() {
        foreach ($this->routes as $route) {
            if ($this->matchRoute($route)) {
                // Ejecutar los middleware asociados a esta ruta
                foreach ($route["middleware"] as $middlewareClass) {
                    (new $middlewareClass())->handle();
                }
                
                // Ejecutar el controlador
                return $this->callHandler($route["handler"]);
            }
        }
        
        // Si llegamos aquí, no se encontró ninguna ruta
        http_response_code(404);
        return $this->view->render("errors/404", [
            "title" => "Página no encontrada"
        ]);
    }

    /**
     * Comprueba si una ruta coincide con la solicitud actual
     * 
     * @param array $route Información de la ruta
     * @return bool True si coincide, false en caso contrario
     */
    protected function matchRoute($route) {
        // Verificar si el método HTTP coincide
        if ($route["method"] !== $this->request["method"]) {
            return false;
        }
        
        // Verificar si la URI coincide con el patrón de la ruta
        if (preg_match($route["pattern"], $this->request["uri"], $matches)) {
            // Extraer parámetros de la URL (solo los que tienen nombre)
            $this->params = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
            return true;
        }
        
        return false;
    }

    /**
     * Ejecuta el controlador asociado a la ruta
     * 
     * @param mixed $handler Controlador@método o callable
     * @return mixed Resultado de la ejecución
     * @throws \Exception Si el controlador no es válido
     */
    protected function callHandler($handler) {
        // Si el handler es una función anónima o callable
        if (is_callable($handler)) {
            return call_user_func($handler, $this->params);
        }
        
        // Si el handler es un string en formato Controlador@método
        if (is_string($handler)) {
            list($controller, $method) = explode("@", $handler);
            $controllerClass = "App\\Controllers\\" . $controller;
            
            if (class_exists($controllerClass)) {
                // Ya no pasamos la vista ni el request en el constructor
                // Las dependencias se obtienen del contenedor
                $controllerInstance = new $controllerClass();
                
                if (method_exists($controllerInstance, $method)) {
                    return call_user_func_array([$controllerInstance, $method], [$this->params]);
                }
                
                throw new \Exception("Método {$method} no encontrado en el controlador {$controller}");
            }
            
            throw new \Exception("Controlador {$controller} no encontrado");
        }
        
        throw new \Exception("Manejador de ruta no válido");
    }
    
    /**
     * Redirige a una URL específica
     * 
     * @param string $url URL de destino
     * @return void
     */
    public function redirect($url) {
        header("Location: " . $url);
        exit;
    }
}
