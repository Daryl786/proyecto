<?php 
namespace App\Controllers;
use App\Core\Controller;
use App\Models\User;

class UsuariosController extends Controller{

    private $modelo;

    public function __construct(){
        $this->modelo = new User();
        parent::__construct();
    }

    public function index(){
        $datos = $this->modelo->all();
        return $this->render( "usuarios/index", ["titulo" => "Usuarios Registrados" , "datosTabla" => $datos]  );
    }

    public function paginado(){
        $datos = $this->modelo->sqlPaginado();
        $datos["baseUrl"] = "/usuarios/pagina";
        return $this->render( "usuarios/paginar", $datos );
    }
    
    public function editar($params = []){
        // Extraer el ID del array de parámetros
        $userId = $params['id'] ?? null;
        
        if (!$userId) {
            $this->session->flash('error', 'ID de usuario no válido');
            $this->redirect('/usuarios');
            return;
        }
        
        // Obtener datos del usuario
        $usuario = $this->modelo->find($userId);
        
        if (!$usuario) {
            $this->session->flash('error', 'Usuario no encontrado con ID: ' . $userId);
            $this->redirect('/usuarios');
            return;
        }
        
        // Si es POST, procesar actualización
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->input('username');
            $email = $this->input('email');
            $apellido = $this->input('apellido');
            $cedula = $this->input('cedula');
            $pais = $this->input('pais');
            $ciudad = $this->input('ciudad');
            $rol = $this->input('rol');
            
            // Validar
            $errors = $this->validate([
                'username' => 'required|min:3',
                'email' => 'required|email',
                'apellido' => 'required|min:2',
                'cedula' => 'required',
                'pais' => 'required',
                'ciudad' => 'required|min:2',
                'rol' => 'required'
            ]);
            
            if (!empty($errors)) {
                return $this->render('usuarios/editar', [
                    'titulo' => 'Editar Usuario',
                    'errors' => $errors,
                    'usuario' => array_merge($usuario, $_POST)
                ]);
            }
            
            // Actualizar usuario
            $resultado = $this->modelo->actualizar($userId, [
                'username' => $username,
                'email' => $email,
                'apellido' => $apellido,
                'cedula' => $cedula,
                'pais' => $pais,
                'ciudad' => $ciudad,
                'rol' => $rol
            ]);
            
            if ($resultado) {
                $this->session->flash('success', 'Usuario actualizado correctamente');
                $this->redirect('/usuarios');
            } else {
                $this->session->flash('error', 'Error al actualizar usuario');
            }
        }
        
        // Mostrar formulario
        return $this->render('usuarios/editar', [
            'titulo' => 'Editar Usuario',
            'usuario' => $usuario
        ]);
    }
    
    public function eliminar($params = []){
        // Extraer el ID del array de parámetros
        $userId = $params['id'] ?? null;
        
        if (!$userId) {
            $this->session->flash('error', 'ID de usuario no válido');
            $this->redirect('/usuarios');
            return;
        }
        
        // No permitir eliminar al propio usuario admin
        if ($this->auth->user()['user_id'] == $userId) {
            $this->session->flash('error', 'No puedes eliminarte a ti mismo');
            $this->redirect('/usuarios');
            return;
        }
        
        $resultado = $this->modelo->eliminar($userId);
        
        if ($resultado) {
            $this->session->flash('success', 'Usuario eliminado correctamente');
        } else {
            $this->session->flash('error', 'Error al eliminar usuario');
        }
        
        $this->redirect('/usuarios');
    }

}
