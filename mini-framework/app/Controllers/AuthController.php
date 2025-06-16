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
            return $this->render('auth/login', [
                'title' => 'Iniciar Sesión',
                'errors' => $errors,
                'input' => ['email' => $email]
            ]);
        }
        
        if ($this->auth->attempt($email, $password)) {
            $this->session->flash('success', 'Has iniciado sesión correctamente');
            $this->redirect('/dashboard');
        }
        
        $this->session->flash('error', 'Credenciales incorrectas');
        return $this->render('auth/login', [
            'title' => 'Iniciar Sesión',
            'input' => ['email' => $email]
        ]);
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
        $name = $this->input('name');
        $email = $this->input('email');
        $password = $this->input('password');
        $passwordConfirm = $this->input('password_confirm');
        
        // Validar entradas
        $errors = $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);
        
        // Validación adicional para la coincidencia de contraseñas
        if ($password !== $passwordConfirm) {
            $errors['password_confirm'] = 'Las contraseñas no coinciden';
        }
        
        // Verificar si el email ya está registrado
        $user = (new \App\Models\User())->findByEmail($email);
        if ($user) {
            $errors['email'] = 'Este email ya está registrado';
        }
        
        if (!empty($errors)) {
            return $this->render('auth/register', [
                'title' => 'Registro de Usuario',
                'errors' => $errors,
                'input' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);
        }
        
        // Crear el usuario
        $userId = $this->auth->register([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => 'user'
        ]);
        
        if ($userId) {
            // Auto login después del registro
            $this->auth->attempt($email, $password);
            $this->session->flash('success', 'Te has registrado correctamente');
            $this->redirect('/dashboard');
        }
        
        $this->session->flash('error', 'Error al registrar el usuario');
        return $this->render('auth/register', [
            'title' => 'Registro de Usuario',
            'input' => [
                'name' => $name,
                'email' => $email
            ]
        ]);
    }

    public function logout() {
        $this->auth->logout();
        $this->session->flash('success', 'Has cerrado sesión correctamente');
        $this->redirect('/');
    }
}
