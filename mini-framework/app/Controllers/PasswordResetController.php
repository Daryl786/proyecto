<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class PasswordResetController extends Controller {
    
    /**
     * Paso 1: Mostrar formulario para ingresar cédula
     */
    public function showRequestForm() {
        // Si ya está autenticado, redirigir al dashboard
        if ($this->auth->check()) {
            $this->redirect('/dashboard');
        }
        
        return $this->render('auth/password_request', [
            'title' => 'Recuperar Contraseña'
        ]);
    }
    
    /**
     * Paso 2: Verificar la cédula y mostrar formulario de nueva contraseña
     */
    public function verifyAndReset() {
        $cedula = $this->input('cedula');
        $newPassword = $this->input('new_password');
        $confirmPassword = $this->input('confirm_password');
        
        $userModel = new User();
        
        // Si solo se envió la cédula (primer paso)
        if ($cedula && !$newPassword) {
            // Validar cédula
            $errors = $this->validate([
                'cedula' => 'required|min:7'
            ]);
            
            if (!empty($errors)) {
                return $this->render('auth/password_request', [
                    'title' => 'Recuperar Contraseña',
                    'errors' => $errors,
                    'input' => ['cedula' => $cedula]
                ]);
            }
            
            // Buscar usuario por cédula
            $user = $userModel->findByCedula($cedula);
            
            if (!$user) {
                $this->session->flash('error', 'No existe un usuario con esa cédula');
                return $this->render('auth/password_request', [
                    'title' => 'Recuperar Contraseña',
                    'input' => ['cedula' => $cedula]
                ]);
            }
            
            // Guardar cédula en sesión temporalmente
            $_SESSION['reset_cedula'] = $cedula;
            $_SESSION['reset_user_id'] = $user['user_id'];
            
            // Mostrar formulario de nueva contraseña
            return $this->render('auth/password_reset', [
                'title' => 'Nueva Contraseña',
                'username' => $user['username'],
                'email' => $user['email']
            ]);
        }
        
        // Si se envió la nueva contraseña (segundo paso)
        if ($newPassword && $confirmPassword) {
            // Verificar que existe la sesión de reset
            if (!isset($_SESSION['reset_cedula']) || !isset($_SESSION['reset_user_id'])) {
                $this->session->flash('error', 'Sesión expirada. Por favor inicia el proceso nuevamente');
                $this->redirect('/password');
                return;
            }
            
            // Validar contraseñas
            $errors = $this->validate([
                'new_password' => 'required|min:4',
                'confirm_password' => 'required'
            ]);
            
            // Verificar que las contraseñas coincidan
            if ($newPassword !== $confirmPassword) {
                $errors['confirm_password'] = 'Las contraseñas no coinciden';
            }
            
            if (!empty($errors)) {
                $user = $userModel->find($_SESSION['reset_user_id']);
                return $this->render('auth/password_reset', [
                    'title' => 'Nueva Contraseña',
                    'errors' => $errors,
                    'username' => $user['username'],
                    'email' => $user['email']
                ]);
            }
            
            // Actualizar contraseña
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updated = $userModel->actualizarPassword($_SESSION['reset_user_id'], $hashedPassword);
            
            if ($updated) {
                // Limpiar sesión de reset
                unset($_SESSION['reset_cedula']);
                unset($_SESSION['reset_user_id']);
                
                $this->session->flash('success', '¡Contraseña actualizada exitosamente! Ya puedes iniciar sesión');
                $this->redirect('/login');
            } else {
                $this->session->flash('error', 'Error al actualizar la contraseña. Intenta nuevamente');
                $this->redirect('/password');
            }
        }
        
        // Si no hay datos, redirigir al formulario inicial
        $this->redirect('/password');
    }
    
    /**
     * Cancelar proceso de recuperación
     */
    public function cancel() {
        unset($_SESSION['reset_cedula']);
        unset($_SESSION['reset_user_id']);
        $this->session->flash('info', 'Proceso de recuperación cancelado');
        $this->redirect('/login');
    }
}
