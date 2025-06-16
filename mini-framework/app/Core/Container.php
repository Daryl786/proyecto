<?php
namespace App\Core;

/**
 * Clase Container - Contenedor de dependencias simple
 * 
 * Esta clase se encarga de:
 * - Administrar instancias compartidas de objetos
 * - Proporcionar un punto central para la inyección de dependencias
 * - Evitar la creación de múltiples instancias innecesarias
 */
class Container {
    /**
     * @var array Almacena las instancias de los objetos
     */
    private static $instances = [];
    
    /**
     * Registra una instancia en el contenedor
     * 
     * @param string $key Identificador de la instancia
     * @param mixed $value La instancia a almacenar
     * @return void
     */
    public static function set($key, $value) {
        self::$instances[$key] = $value;
    }
    
    /**
     * Obtiene una instancia del contenedor
     * 
     * @param string $key Identificador de la instancia
     * @return mixed La instancia solicitada
     * @throws \Exception Si la instancia no existe
     */
    public static function get($key) {
        if (!isset(self::$instances[$key])) {
            throw new \Exception("No se ha registrado la dependencia: {$key}");
        }
        return self::$instances[$key];
    }
    
    /**
     * Verifica si una instancia existe en el contenedor
     * 
     * @param string $key Identificador de la instancia
     * @return bool True si existe, false en caso contrario
     */
    public static function has($key) {
        return isset(self::$instances[$key]);
    }
}
