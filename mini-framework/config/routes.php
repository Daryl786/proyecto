<?php
/**
 * Definición de rutas de la aplicación
 */

use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

// ============================================================================
// RUTAS PÚBLICAS (sin autenticación requerida)
// ============================================================================

// Página principal
$router->addRoute("GET", "/", "HomeController@index");

// Autenticación
$router->addRoute("GET", "/login", "AuthController@showLogin");
$router->addRoute("POST", "/login", "AuthController@login");
$router->addRoute("GET", "/logout", "AuthController@logout");
$router->addRoute("GET", "/register", "AuthController@showRegister");
$router->addRoute("POST", "/register", "AuthController@register");

// Recuperación de contraseña
$router->addRoute("GET", "/password", "PasswordResetController@showRequestForm");
$router->addRoute("POST", "/password/verify", "PasswordResetController@verifyAndReset");
$router->addRoute("GET", "/password/cancel", "PasswordResetController@cancel");

// ============================================================================
// RUTAS DE CATEGORÍAS
// ============================================================================

$router->addRoute("GET", "/categoria", "CategoriaController@index");
$router->addRoute("GET", "/categoria/crear", "CategoriaController@crear", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("POST", "/categoria/crear", "CategoriaController@crear", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("GET", "/categoria/editar/:id", "CategoriaController@editar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("POST", "/categoria/editar/:id", "CategoriaController@editar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("GET", "/categoria/eliminar/:id", "CategoriaController@eliminar", [AuthMiddleware::class, AdminMiddleware::class]);

// ============================================================================
// RUTAS DE POSTS/SERVICIOS
// ============================================================================

// Lista y paginación de posts
$router->addRoute("GET", "/post", "PostController@index");
$router->addRoute("GET", "/post/paginar/:pagina", "PostController@index", [AuthMiddleware::class]);

// Crear post
$router->addRoute("GET", "/post/crear", "PostController@crear", [AuthMiddleware::class]);
$router->addRoute("POST", "/post/crear", "PostController@crear", [AuthMiddleware::class]);

// Editar post
$router->addRoute("GET", "/post/editar/:id", "PostController@editar", [AuthMiddleware::class]);
$router->addRoute("POST", "/post/editar/:id", "PostController@editar", [AuthMiddleware::class]);

// Eliminar post
$router->addRoute("GET", "/post/eliminar/:id", "PostController@eliminar", [AuthMiddleware::class, AdminMiddleware::class]);

// Sistema de calificaciones
$router->addRoute("POST", "/post/calificar/:id", "PostController@calificar", [AuthMiddleware::class]);
$router->addRoute("GET", "/post/eliminar-calificacion/:id", "PostController@eliminarCalificacion", [AuthMiddleware::class]);

// Sistema de contrataciones
$router->addRoute("GET", "/post/contratar/:id", "PostController@contratar", [AuthMiddleware::class]);
$router->addRoute("GET", "/post/cancelar-contratacion/:id", "PostController@cancelarContratacion", [AuthMiddleware::class]);
$router->addRoute("GET", "/post/eliminar-contratacion/:id", "PostController@eliminarContratacion", [AuthMiddleware::class]);

// Sistema de comentarios
$router->addRoute("POST", "/post/agregar-comentario/:id", "PostController@agregarComentario", [AuthMiddleware::class]);
$router->addRoute("GET", "/post/eliminar-comentario/:id", "PostController@eliminarComentario", [AuthMiddleware::class]);

// Ver detalle del post (DEBE IR AL FINAL)
$router->addRoute("GET", "/post/ver/:id", "PostController@ver");

// ============================================================================
// RUTAS DE USUARIOS
// ============================================================================

$router->addRoute("GET", "/usuarios", "UsuariosController@index");
$router->addRoute("GET", "/usuarios/editar/:id", "UsuariosController@editar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("POST", "/usuarios/editar/:id", "UsuariosController@editar", [AuthMiddleware::class, AdminMiddleware::class]);
$router->addRoute("GET", "/usuarios/eliminar/:id", "UsuariosController@eliminar", [AuthMiddleware::class, AdminMiddleware::class]);

// ============================================================================
// RUTAS DEL DASHBOARD
// ============================================================================

// Editar perfil (ESPECÍFICA - debe ir primero)
$router->addRoute("GET", "/dashboard/editar-perfil", "DashboardController@editarPerfil", [AuthMiddleware::class]);
$router->addRoute("POST", "/dashboard/editar-perfil", "DashboardController@editarPerfil", [AuthMiddleware::class]);

// Dashboard principal
$router->addRoute("GET", "/dashboard", "DashboardController@index", [AuthMiddleware::class]);

// Ruta dinámica (GENÉRICA - debe ir al final)
$router->addRoute("GET", "/dashboard/:id", "DashboardController@show", [AuthMiddleware::class]);

// ============================================================================
// RUTAS DE API
// ============================================================================

$router->addRoute("GET", "/apicategorias", "ApiController@index");
$router->addRoute("POST", "/apicategorias", "ApiController@index");
