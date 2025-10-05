<?php
namespace App\Core;

class View {
    protected $sharedData = [];

    public function e($value) {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    public function share($key, $value = null) {
        if (is_array($key)) {
            $this->sharedData = array_merge($this->sharedData, $key);
        } else {
            $this->sharedData[$key] = $value;
        }
    }

    public function component($name, $data = []) {
        // Combina los datos compartidos con los datos específicos del componente.
        $data = array_merge($this->sharedData, $data);
        extract($data); // Hace que las variables de $data estén disponibles en el ámbito del componente.

        // Determina la ruta del archivo del componente.
        if (strpos($name, '/') === false) {
            $componentFile = BASE_PATH . "/app/Views/components/{$name}.php";
        } else {
            // Permite componentes en subdirectorios como 'minuevo/lista_articulos'
            $componentFile = BASE_PATH . "/app/Views/{$name}.php";
        }

        // Verifica si el archivo del componente existe.
        if (!file_exists($componentFile)) {
            error_log("Componente no encontrado: {$name}. Ruta esperada: {$componentFile}");
            echo "<div style='color:red;'>Error: Componente '{$name}' no encontrado.</div>";
            return;
        }
        require $componentFile; // Esto imprimirá directamente en el búfer de salida activo (el iniciado por render()).
    }

    public function render($viewPath, $data = []) {
        // Combina datos compartidos con datos específicos de la vista.

        $data = array_merge($this->sharedData, $data);

        extract($data); // Hace que las variables de $data estén disponibles en el ámbito de la vista.

        // Inicia el búfer de salida para capturar todo el contenido de la vista.
        ob_start();
        $viewFile = BASE_PATH . "/app/Views/{$viewPath}.php";

        // Verifica si el archivo de vista existe.
        if (!file_exists($viewFile)) {
            ob_end_clean(); // Limpia el búfer antes de lanzar una excepción.
            throw new \Exception("Vista no encontrada: {$viewPath}. Archivo esperado: {$viewFile}");
        }

        require $viewFile; // Ejecuta el archivo de vista. Todo su HTML (y la salida de componentes) se captura aquí.

        $content = ob_get_clean(); // Captura todo el HTML de la vista en esta variable.

        $layoutFile = BASE_PATH . "/app/Views/layouts/main.php";

        // Si existe un archivo de layout, lo incluimos.
        if (file_exists($layoutFile)) {
            // El contenido capturado de la vista ($_layoutContent) estará disponible en el layout.
            // Iniciamos un nuevo búfer para capturar la salida del layout.
            ob_start();
            require $layoutFile;
            echo ob_get_clean(); // Imprime la salida final del layout.
        } else {
            // Si no hay layout, simplemente imprimimos el contenido de la vista directamente.
            echo $content;
        }
    }
}
