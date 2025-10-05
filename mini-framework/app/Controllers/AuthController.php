<?php
namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller {
    public function showLogin() {
        // Si ya está autenticado, redirigir al dashboard
        if ($this->auth->check()) {
            $this->redirect('/dashboard');
        }
        
        return $this->render('auth/login', [
            'title' => 'Iniciar Sesión'
        ]);
    }

    public function login() {
        $email = $this->input('email');
        $password = $this->input('password');
        
        // Validar entradas
        $errors = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (!empty($errors)) {
            $this->session->flash('error', 'Por favor completa todos los campos correctamente');
            return $this->render('auth/login', [
                'title' => 'Iniciar Sesión',
                'errors' => $errors,
                'input' => ['email' => $email]
            ]);
        }
        
        // DEBUG: Verificar si el usuario existe
        $userModel = new \App\Models\User();
        $user = $userModel->findByEmail($email);
        
        if (!$user) {
            $this->session->flash('error', 'No existe un usuario con ese email');
            return $this->render('auth/login', [
                'title' => 'Iniciar Sesión',
                'input' => ['email' => $email]
            ]);
        }
        
        // Verificar la contraseña manualmente
        if (!password_verify($password, $user['password'])) {
            $this->session->flash('error', 'La contraseña es incorrecta');
            return $this->render('auth/login', [
                'title' => 'Iniciar Sesión',
                'input' => ['email' => $email]
            ]);
        }
        
        // Si llegamos aquí, las credenciales son correctas
        // Intentar con el método del Core
        if ($this->auth->attempt($email, $password)) {
            $this->session->flash('success', 'Has iniciado sesión correctamente');
            $this->redirect('/dashboard');
        }
        
        // Si el attempt del Core falla, crear sesión manualmente
        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $user['user_id'];
        $this->session->flash('success', 'Sesión iniciada correctamente');
        $this->redirect('/dashboard');
    }

    public function showRegister() {
        // Si ya está autenticado, redirigir al dashboard
        if ($this->auth->check()) {
            $this->redirect('/dashboard');
        }
        
        return $this->render('auth/register', [
            'title' => 'Registro de Usuario'
        ]);
    }

    public function register() {
        $username = $this->input('username');
        $email = $this->input('email');
        $password = $this->input('password');
        $passwordConfirm = $this->input('password_confirm');
        $cedula = $this->input('cedula');
        $apellido = $this->input('apellido');
        $pais = $this->input('pais');
        $ciudad = $this->input('ciudad');
        $rol = $this->input('rol') ?? 'usuario';
        
        // Validar entradas
        $errors = $this->validate([
            'username' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:4',
            'cedula' => 'required',
            'apellido' => 'required|min:2',
            'pais' => 'required',
            'ciudad' => 'required|min:2'
        ]);
        
        // Validación adicional para la coincidencia de contraseñas
        if ($password !== $passwordConfirm) {
            $errors['password_confirm'] = 'Las contraseñas no coinciden';
        }
        
        // Verificar si el email ya está registrado
        $userModel = new \App\Models\User();
        $user = $userModel->findByEmail($email);
        if ($user) {
            $errors['email'] = 'Este email ya está registrado';
        }
        
        // COMENTADO: Verificar si la cédula ya está registrada
        // (Descomentar cuando el método findByCedula esté implementado)
        /*
        $userByCedula = $userModel->findByCedula($cedula);
        if ($userByCedula) {
            $errors['cedula'] = 'Esta cédula ya está registrada';
        }
        */
        
        if (!empty($errors)) {
            return $this->render('auth/register', [
                'title' => 'Registro de Usuario',
                'errors' => $errors,
                'input' => [
                    'username' => $username,
                    'email' => $email,
                    'cedula' => $cedula,
                    'apellido' => $apellido,
                    'pais' => $pais,
                    'ciudad' => $ciudad,
                    'rol' => $rol
                ]
            ]);
        }
        
        // Crear el usuario usando el modelo directamente
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $userId = $userModel->crear([
            'username' => $username,
            'apellido' => $apellido,
            'email' => $email,
            'cedula' => $cedula,
            'pais' => $pais,
            'ciudad' => $ciudad,
            'password' => $hashedPassword,
            'rol' => $rol
        ]);
        
        if ($userId) {
            // Auto login después del registro
            // COMENTADO TEMPORALMENTE PARA DEBUG
            // $this->auth->attempt($email, $password);
            $this->session->flash('success', 'Te has registrado correctamente. Por favor inicia sesión.');
            $this->redirect('/login');
        }
        
        $this->session->flash('error', 'Error al registrar el usuario');
        return $this->render('auth/register', [
            'title' => 'Registro de Usuario',
            'input' => [
                'username' => $username,
                'email' => $email,
                'cedula' => $cedula,
                'apellido' => $apellido,
                'pais' => $pais,
                'ciudad' => $ciudad
            ]
        ]);
    }

    public function logout() {
        $this->auth->logout();
        $this->session->flash('success', 'Has cerrado sesión correctamente');
        $this->redirect('/');
    }
}
