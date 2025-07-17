<?php
/**
 * Definición de rutas de la aplicación
 * Formato: $router->addRoute(método, ruta, controlador@método, [middleware])
 */

use App\Middleware\AuthMiddleware;

// Rutas públicas
$router->addRoute("GET", "/", "HomeController@index");
$router->addRoute("GET", "/login", "AuthController@showLogin");
$router->addRoute("POST", "/login", "AuthController@login");
$router->addRoute("GET", "/logout", "AuthController@logout");
$router->addRoute("GET", "/register", "AuthController@showRegister");
$router->addRoute("POST", "/register", "AuthController@register");
$router->addRoute("GET", "/listado", "CategoriaController@index");


$router->addRoute("GET", "/minuevo", "MinuevoController@index");
$router->addRoute("GET", "/minv/id/:id", "MinuevoController@index");
$router->addRoute("GET", "/clientes", "ClientesController@index");





// Rutas protegidas por middleware de autenticación
$router->addRoute("GET", "/dashboard", "DashboardController@index", [AuthMiddleware::class]);
$router->addRoute("GET", "/dashboard/:id", "DashboardController@show", [AuthMiddleware::class]);
$router->addRoute("GET", "/profile", "ProfileController@index", [AuthMiddleware::class]);
$router->addRoute("POST", "/profile", "ProfileController@update", [AuthMiddleware::class]);
