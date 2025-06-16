<?php
/**
 * Configuración de la base de datos
 * Cambiar estos valores según tu entorno
 */
return [
    "driver" => "mysql",
    "host" => "localhost",
    "database" => "proyutu",
    "username" => "proyutu",
    "password" => "12345678",
    "charset" => "utf8mb4",
    "options" => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]
];
