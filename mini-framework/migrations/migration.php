<?php
/**
 * Script para ejecutar migraciones de base de datos
 * 
 * Uso: php migrate.php
 */
use App\Core\Database;

define("BASE_PATH", dirname(__DIR__));


function migrations( $file_sql ){

require BASE_PATH."/vendor/autoload.php";

// Imprimir mensaje de inicio
echo "Iniciando migraciones...\n";

try {
    // Obtener instancia de la base de datos
    $db = Database::getInstance();
    
    // Ejecutar migración de usuarios
    echo "Migrando tabla de usuarios... ";
    
    $usersMigration = file_get_contents(BASE_PATH . "/migrations/{$file_sql}");
    $queries = explode(';', $usersMigration);
    
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            $db->query($query);
        }
    }
    
    echo "OK\n";
    
    // Aquí puedes agregar más migraciones en el futuro
    
    echo "Migraciones completadas con éxito.\n";
} catch (Exception $e) {
    echo "Error al ejecutar migraciones: " . $e->getMessage() . "\n";
    exit(1);
}

}

migrations("create_users_table.sql");
migrations("create_products_table.sql");
