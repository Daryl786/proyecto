<?php
/**
 * Definición de rutas de la aplicación
 * Formato: $router->addRoute(método, ruta, controlador@método, [middleware])
 */

use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

// Rutas públicas
$router->addRoute("POST","/apicategorias", "ApiController@index");
$router->addRoute("GET","/apicategorias", "ApiController@index");
$router->addRoute("GET","/products/pagina/:pagina", "ProductsController@todosPaginas");
$router->addRoute("GET","/products", "ProductsController@index", [AuthMiddleware::class]);
$router->addRoute("GET", "/", "HomeController@index");
$router->addRoute("GET", "/login", "AuthController@showLogin");
$router->addRoute("POST", "/login", "AuthController@login");
$router->addRoute("GET", "/logout", "AuthController@logout");
$router->addRoute("GET", "/register", "AuthController@showRegister");
$router->addRoute("POST", "/register", "AuthController@register");
$router->addRoute("GET", "/reset_password", "PasswordResetController@PasswordReset");
$router->addRoute("POST", "/reset_password", "PasswordResetController@PasswordReset");
$router->addRoute("GET", "/password", "PasswordResetController@PasswordReset");
$router->addRoute("POST", "/password", "PasswordResetController@PasswordReset");
$router->addRoute("GET", "/post/ver/:id", "PostController@ver");

$router->addRoute("GET", "/categoria", "CategoriaController@index");
$router->addRoute("GET", "/categoria/crear", "CategoriaController@crear", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("POST", "/categoria/crear", "CategoriaController@crear", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("GET", "/categoria/editar/:id", "CategoriaController@editar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("POST", "/categoria/editar/:id", "CategoriaController@editar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("GET", "/categoria/eliminar/:id", "CategoriaController@eliminar", [AuthMiddleware::class, AdminMiddleware::class]);

$router->addRoute("GET", "/post", "PostController@index");
$router->addRoute("GET", "/post/paginar/:pagina", "PostController@index",[AuthMiddleware::class]);
$router->addRoute("GET", "/usuarios", "UsuariosController@index");

// Rutas protegidas por middleware de autenticación
$router->addRoute("GET", "/dashboard", "DashboardController@index", [AuthMiddleware::class]);
$router->addRoute("GET", "/dashboard/:id", "DashboardController@show", [AuthMiddleware::class]);
$router->addRoute("GET", "/usuarios/editar/:id", "UsuariosController@editar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("POST", "/usuarios/editar/:id", "UsuariosController@editar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("GET", "/usuarios/eliminar/:id", "UsuariosController@eliminar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("GET", "/post/editar/:id", "PostController@editar", [AuthMiddleware::class]);
$router->addRoute("POST", "/post/editar/:id", "PostController@editar", [AuthMiddleware::class]);
$router->addRoute("POST", "/post/calificar/:id", "PostController@calificar", [AuthMiddleware::class]);
$router->addRoute("GET", "/post/eliminar/:id", "PostController@eliminar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("GET", "/post/crear", "PostController@crear", [AuthMiddleware::class]);
$router->addRoute("POST", "/post/crear", "PostController@crear", [AuthMiddleware::class]);

// NUEVO: Ruta para contratar servicios
$router->addRoute("GET", "/post/contratar/:id", "PostController@contratar", [AuthMiddleware::class]);
