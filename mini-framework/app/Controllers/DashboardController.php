<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Contratacion;

class DashboardController extends Controller {
    
    private $postModel;
    private $contratacionModel;
    
    public function __construct() {
        $this->postModel = new Post();
        $this->contratacionModel = new Contratacion();
        parent::__construct();
    }
    
    public function index() {
        // Verificar autenticación
        if (!$this->auth->check()) {
            $this->redirect('/login');
            return;
        }
        
        $user = $this->auth->user();
        
        // Finalizar contrataciones vencidas
        $this->contratacionModel->finalizarVencidas();
        
        // Obtener servicios publicados por el usuario
        $misServicios = $this->postModel->findByUserId($user['user_id']);
        $totalServicios = count($misServicios);
        
        // Obtener contrataciones del usuario (servicios que contrató)
        $misContrataciones = $this->contratacionModel->obtenerPorUsuario($user['user_id']);
        $totalContrataciones = count($misContrataciones);
        $contratacionesActivas = $this->contratacionModel->contarPorUsuario($user['user_id'], 'activo');
        
        // Agregar información de si puede cancelar cada contratación
        foreach ($misContrataciones as &$contratacion) {
            if ($contratacion['estado'] === 'activo' || $contratacion['estado'] === 'pendiente') {
                $validacion = $this->contratacionModel->puedeCancelar(
                    $contratacion['contratacion_id'], 
                    $user['user_id']
                );
                $contratacion['puede_cancelar'] = $validacion['puede'];
                $contratacion['horas_restantes_cancelacion'] = $validacion['horas_restantes'] ?? 0;
                $contratacion['razon_no_cancelar'] = $validacion['razon'];
            } else {
                $contratacion['puede_cancelar'] = false;
            }
        }
        
        // Obtener servicios contratados por otros usuarios (si es proveedor)
        $serviciosContratados = $this->contratacionModel->obtenerPorProveedor($user['user_id']);
        
        return $this->render('dashboard/index', [
            'title' => 'Mi Perfil',
            'user' => $user,
            'misServicios' => $misServicios,
            'totalServicios' => $totalServicios,
            'misContrataciones' => $misContrataciones,
            'totalContrataciones' => $totalContrataciones,
            'contratacionesActivas' => $contratacionesActivas,
            'serviciosContratados' => $serviciosContratados
        ]);
    }

	// Agregar estos métodos al DashboardController.php

public function editarPerfil() {
    // Verificar autenticación
    if (!$this->auth->check()) {
        $this->redirect('/login');
        return;
    }
    
    $user = $this->auth->user();
    $userModel = new \App\Models\User();
    
    // Si es POST, procesar actualización
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $this->input('username');
        $apellido = $this->input('apellido');
        $email = $this->input('email');
        $cedula = $this->input('cedula');
        $pais = $this->input('pais');
        $ciudad = $this->input('ciudad');
        
        $passwordActual = $this->input('password_actual');
        $passwordNueva = $this->input('password_nueva');
        $passwordConfirmar = $this->input('password_confirmar');
        
        // Validar campos básicos
        $errors = $this->validate([
            'username' => 'required|min:3',
            'apellido' => 'required|min:2',
            'email' => 'required|email',
            'cedula' => 'required',
            'pais' => 'required',
            'ciudad' => 'required|min:2'
        ]);
        
        // Verificar si el email ya existe (excepto el del usuario actual)
        $existingUser = $userModel->findByEmail($email);
        if ($existingUser && $existingUser['user_id'] != $user['user_id']) {
            $errors[] = 'El email ya está registrado por otro usuario';
        }
        
        // Verificar si la cédula ya existe (excepto la del usuario actual)
        $existingCedula = $userModel->findByCedula($cedula);
        if ($existingCedula && $existingCedula['user_id'] != $user['user_id']) {
            $errors[] = 'La cédula ya está registrada por otro usuario';
        }
        
        // Validar cambio de contraseña si se proporcionó
        if (!empty($passwordActual) || !empty($passwordNueva) || !empty($passwordConfirmar)) {
            if (empty($passwordActual)) {
                $errors[] = 'Debes ingresar tu contraseña actual para cambiarla';
            } elseif (!password_verify($passwordActual, $user['password'])) {
                $errors[] = 'La contraseña actual es incorrecta';
            }
            
            if (empty($passwordNueva)) {
                $errors[] = 'Debes ingresar una nueva contraseña';
            } elseif (strlen($passwordNueva) < 6) {
                $errors[] = 'La nueva contraseña debe tener al menos 6 caracteres';
            }
            
            if ($passwordNueva !== $passwordConfirmar) {
                $errors[] = 'Las contraseñas nuevas no coinciden';
            }
        }
        
        if (!empty($errors)) {
            return $this->render('dashboard/editar-perfil', [
                'title' => 'Editar Perfil',
                'errors' => $errors,
                'usuario' => array_merge($user, $_POST)
            ]);
        }
        
        // Preparar datos para actualizar
        $datosActualizar = [
            'username' => $username,
            'apellido' => $apellido,
            'email' => $email,
            'cedula' => $cedula,
            'pais' => $pais,
            'ciudad' => $ciudad
        ];
        
        // Actualizar información básica
        $resultado = $userModel->actualizarPerfil($user['user_id'], $datosActualizar);
        
        // Actualizar contraseña si se proporcionó
        if (!empty($passwordNueva) && $resultado) {
            $hashedPassword = password_hash($passwordNueva, PASSWORD_DEFAULT);
            $userModel->actualizarPassword($user['user_id'], $hashedPassword);
        }
        
        if ($resultado) {
            // Actualizar sesión con nuevos datos
            $userActualizado = $userModel->find($user['user_id']);
            $this->session->set('user', $userActualizado);
            
            $this->session->flash('success', 'Perfil actualizado correctamente');
            $this->redirect('/dashboard');
        } else {
            $this->session->flash('error', 'Error al actualizar el perfil');
        }
    }
    
    // Mostrar formulario
    $usuario = $userModel->find($user['user_id']);
    
    return $this->render('dashboard/editar-perfil', [
        'title' => 'Editar Perfil',
        'usuario' => $usuario
    ]);
}
    
    public function show($params = []) {
        if (!$this->auth->check()) {
            $this->redirect('/login');
        }

        return $this->render('dashboard/show', [
            'title' => 'Usuario',
            'user' => $this->auth->user(),
            'userId' => $params['id'] ?? null
        ]);
    }
}
