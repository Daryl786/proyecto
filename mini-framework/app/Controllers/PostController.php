<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Post;

class PostController extends Controller{

	private $modelo;		

	public function __construct(){
		$this->modelo = new Post();
		parent::__construct();
	}

	public function index($parm = []){
		$pagina = $parm["pagina"] ?? 1;
		$categoriaId = $_GET['categoria'] ?? null;
		
		// Construir SQL con filtro opcional
		$sql = "";
		if ($categoriaId) {
			$sql = "SELECT * FROM Posts WHERE category_id = " . intval($categoriaId);
		}
		
		$datos = $this->modelo->sqlPaginado($sql, $pagina);
		$datos["baseUrl"] = "/post/paginar";
		$datos["titulo"] = "Todos los Servicios";
		
		// Obtener todas las categorías para el select
		$categoriaModel = new \App\Models\Categoria();
		$datos["categorias"] = $categoriaModel->all();
		$datos["categoriaSeleccionada"] = $categoriaId;
		
		$this->render("post/index", $datos);
	}
	
	public function ver($params = []) {
    $postId = $params['id'] ?? null;
    
    if (!$postId) {
        $this->session->flash('error', 'Servicio no encontrado');
        $this->redirect('/post');
        return;
    }
    
    // Obtener servicio con información del usuario
    $servicio = $this->modelo->findWithUserInfo($postId);
    
    if (!$servicio) {
        $this->session->flash('error', 'Servicio no encontrado');
        $this->redirect('/post');
        return;
    }
    
    // Obtener calificaciones
    $ratingModel = new \App\Models\Rating();
    $calificaciones = $ratingModel->getCalificacionesPost($postId);
    $usuarioYaCalificó = false;
    $calificacionUsuario = null;
    $usuarioHaContratado = false;
    
    // Obtener comentarios
    $commentModel = new \App\Models\ServiceComment();
    $comentarios = $commentModel->getComentariosPost($postId);
    $totalComentarios = $commentModel->contarComentarios($postId);
    
    if ($this->auth->check()) {
        $usuarioYaCalificó = $ratingModel->usuarioYaCalificó($postId, $this->auth->user()['user_id']);
        $calificacionUsuario = $ratingModel->getCalificacionUsuario($postId, $this->auth->user()['user_id']);
        
        // Verificar si el usuario ha contratado el servicio (activo o finalizado)
        $contratacionModel = new \App\Models\Contratacion();
        $usuarioHaContratado = $contratacionModel->usuarioHaContratado($postId, $this->auth->user()['user_id']);
    }
    
    $this->render('post/ver', [
        'titulo' => $servicio['title'],
        'servicio' => $servicio,
        'calificaciones' => $calificaciones,
        'usuarioYaCalificó' => $usuarioYaCalificó,
        'calificacionUsuario' => $calificacionUsuario,
        'usuarioHaContratado' => $usuarioHaContratado,
        'comentarios' => $comentarios,
        'totalComentarios' => $totalComentarios
    ]);
}
	public function eliminar($params = []) {
		$postId = $params['id'] ?? null;
		
		if (!$postId) {
			$this->session->flash('error', 'ID de servicio no válido');
			$this->redirect('/post');
			return;
		}
		
		$resultado = $this->modelo->eliminar($postId);
		
		if ($resultado) {
			$this->session->flash('success', 'Servicio eliminado correctamente');
		} else {
			$this->session->flash('error', 'Error al eliminar servicio');
		}
		
		$this->redirect('/post');
	}
	
	public function crear($params = []) {
		// Verificar que el usuario esté autenticado
		if (!$this->auth->check()) {
			$this->session->flash('error', 'Debes iniciar sesión para crear un servicio');
			$this->redirect('/login');
			return;
		}
		
		// Obtener categorías para el select
		$categoriaModel = new \App\Models\Categoria();
		$categorias = $categoriaModel->all();
		
		// Si es POST, procesar creación
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$title = $this->input('title');
			$content = $this->input('content');
			$precio = $this->input('precio');
			$duracion = $this->input('duracion');
			$nombreEmpresa = $this->input('nombre_empresa');
			$categoryId = $this->input('category_id');
			
			// Validar
			$errors = $this->validate([
				'title' => 'required|min:5',
				'content' => 'required|min:20',
				'precio' => 'required',
				'duracion' => 'required',
				'category_id' => 'required'
			]);
			
			if (!empty($errors)) {
				return $this->render('post/crear', [
					'titulo' => 'Crear Servicio',
					'errors' => $errors,
					'categorias' => $categorias,
					'input' => $_POST
				]);
			}
			
			// Crear el servicio
			$resultado = $this->modelo->crear([
				'title' => $title,
				'content' => $content,
				'precio' => $precio,
				'duracion' => $duracion,
				'nombre_empresa' => $nombreEmpresa,
				'category_id' => $categoryId,
				'user_id' => $this->auth->user()['user_id']
			]);
			
			if ($resultado) {
				$this->session->flash('success', 'Servicio creado correctamente');
				$this->redirect('/post');
			} else {
				$this->session->flash('error', 'Error al crear servicio');
			}
		}
		
		// Mostrar formulario
		return $this->render('post/crear', [
			'titulo' => 'Crear Servicio',
			'categorias' => $categorias
		]);
	}
	
	public function editar($params = []) {
		// Verificar que el usuario esté autenticado
		if (!$this->auth->check()) {
			$this->session->flash('error', 'Debes iniciar sesión para editar un servicio');
			$this->redirect('/login');
			return;
		}
		
		$postId = $params['id'] ?? null;
		
		if (!$postId) {
			$this->session->flash('error', 'Servicio no encontrado');
			$this->redirect('/post');
			return;
		}
		
		// Obtener el servicio
		$servicio = $this->modelo->find(['post_id' => $postId]);
		
		if (!$servicio) {
			$this->session->flash('error', 'Servicio no encontrado');
			$this->redirect('/post');
			return;
		}
		
		// Verificar que el usuario sea el propietario o admin
		if ($servicio['user_id'] != $this->auth->user()['user_id'] && $this->auth->user()['rol'] !== 'admin') {
			$this->session->flash('error', 'No tienes permiso para editar este servicio');
			$this->redirect('/post');
			return;
		}
		
		// Obtener categorías
		$categoriaModel = new \App\Models\Categoria();
		$categorias = $categoriaModel->all();
		
		// Si es POST, procesar actualización
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$title = $this->input('title');
			$content = $this->input('content');
			$precio = $this->input('precio');
			$duracion = $this->input('duracion');
			$nombreEmpresa = $this->input('nombre_empresa');
			$categoryId = $this->input('category_id');
			
			// Validar
			$errors = $this->validate([
				'title' => 'required|min:5',
				'content' => 'required|min:20',
				'precio' => 'required',
				'duracion' => 'required',
				'category_id' => 'required'
			]);
			
			if (!empty($errors)) {
				return $this->render('post/editar', [
					'titulo' => 'Editar Servicio',
					'errors' => $errors,
					'categorias' => $categorias,
					'servicio' => $servicio,
					'input' => $_POST
				]);
			}
			
			// Actualizar el servicio
			$resultado = $this->modelo->actualizar($postId, [
				'title' => $title,
				'content' => $content,
				'precio' => $precio,
				'duracion' => $duracion,
				'nombre_empresa' => $nombreEmpresa,
				'category_id' => $categoryId
			]);
			
			if ($resultado) {
				$this->session->flash('success', 'Servicio actualizado correctamente');
				$this->redirect('/post/ver/' . $postId);
			} else {
				$this->session->flash('error', 'Error al actualizar servicio');
			}
		}
		
		// Mostrar formulario
		return $this->render('post/editar', [
			'titulo' => 'Editar Servicio',
			'categorias' => $categorias,
			'servicio' => $servicio,
			'input' => $servicio
		]);
	}
	
	public function calificar($params = []) {
		// Verificar que el usuario esté autenticado
		if (!$this->auth->check()) {
			$this->session->flash('error', 'Debes iniciar sesión para calificar un servicio');
			$this->redirect('/login');
			return;
		}
		
		$postId = $params['id'] ?? null;
		
		if (!$postId) {
			$this->session->flash('error', 'Servicio no encontrado');
			$this->redirect('/post');
			return;
		}
		
		// Verificar que el servicio existe
		$servicio = $this->modelo->find(['post_id' => $postId]);
		
		if (!$servicio) {
			$this->session->flash('error', 'Servicio no encontrado');
			$this->redirect('/post');
			return;
		}
		
		// Verificar que no es el propietario del servicio
		if ($servicio['user_id'] == $this->auth->user()['user_id']) {
			$this->session->flash('error', 'No puedes calificar tu propio servicio');
			$this->redirect('/post/ver/' . $postId);
			return;
		}
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$rating = intval($this->input('rating'));
			$comment = $this->input('comment');
			
			// Validar
			if ($rating < 1 || $rating > 5) {
				$this->session->flash('error', 'La calificación debe estar entre 1 y 5 estrellas');
				$this->redirect('/post/ver/' . $postId);
				return;
			}
			
			$ratingModel = new \App\Models\Rating();
			$resultado = $ratingModel->guardarCalificacion(
				$postId, 
				$this->auth->user()['user_id'], 
				$rating, 
				$comment
			);
			
			if ($resultado) {
				$this->session->flash('success', 'Calificación guardada correctamente');
			} else {
				$this->session->flash('error', 'Error al guardar la calificación');
			}
		}
		
		$this->redirect('/post/ver/' . $postId);
	}
	
	/**
	 * NUEVO: Eliminar una calificación
	 */
	public function eliminarCalificacion($params = []) {
		// Verificar autenticación
		if (!$this->auth->check()) {
			$this->session->flash('error', 'Debes iniciar sesión');
			$this->redirect('/login');
			return;
		}
		
		$ratingId = $params['id'] ?? null;
		
		if (!$ratingId) {
			$this->session->flash('error', 'ID de calificación no válido');
			$this->redirect('/post');
			return;
		}
		
		$ratingModel = new \App\Models\Rating();
		
		// Obtener la calificación para verificar permisos
		$rating = $ratingModel->find(['rating_id' => $ratingId]);
		
		if (!$rating) {
			$this->session->flash('error', 'Calificación no encontrada');
			$this->redirect('/post');
			return;
		}
		
		// Obtener el servicio asociado
		$servicio = $this->modelo->find(['post_id' => $rating['post_id']]);
		
		if (!$servicio) {
			$this->session->flash('error', 'Servicio no encontrado');
			$this->redirect('/post');
			return;
		}
		
		$usuarioActual = $this->auth->user();
		
		// Verificar permisos: admin O propietario del servicio
		$esAdmin = $usuarioActual['rol'] === 'admin';
		$esPropietarioServicio = $servicio['user_id'] == $usuarioActual['user_id'];
		
		if (!$esAdmin && !$esPropietarioServicio) {
			$this->session->flash('error', 'No tienes permiso para eliminar esta calificación');
			$this->redirect('/post/ver/' . $servicio['post_id']);
			return;
		}
		
		// Eliminar la calificación
		$resultado = $ratingModel->eliminarCalificacion($ratingId);
		
		if ($resultado) {
			$this->session->flash('success', 'Calificación eliminada correctamente');
		} else {
			$this->session->flash('error', 'Error al eliminar la calificación');
		}
		
		$this->redirect('/post/ver/' . $servicio['post_id']);
	}
	
	/**
	 * Contratar un servicio
	 */
	public function contratar($params = []) {
		// Verificar autenticación
		if (!$this->auth->check()) {
			$this->session->flash('error', 'Debes iniciar sesión para contratar un servicio');
			$this->redirect('/login');
			return;
		}
		
		$postId = $params['id'] ?? null;
		
		if (!$postId) {
			$this->session->flash('error', 'Servicio no encontrado');
			$this->redirect('/post');
			return;
		}
		
		// Verificar que el servicio existe
		$servicio = $this->modelo->findWithUserInfo($postId);
		
		if (!$servicio) {
			$this->session->flash('error', 'Servicio no encontrado');
			$this->redirect('/post');
			return;
		}
		
		// Verificar que no es el propietario del servicio
		if ($servicio['user_id'] == $this->auth->user()['user_id']) {
			$this->session->flash('error', 'No puedes contratar tu propio servicio');
			$this->redirect('/post/ver/' . $postId);
			return;
		}
		
		// Verificar que no lo haya contratado antes (activo)
		$contratacionModel = new \App\Models\Contratacion();
		if ($contratacionModel->usuarioYaContrato($postId, $this->auth->user()['user_id'])) {
			$this->session->flash('error', 'Ya tienes una contratación activa de este servicio');
			$this->redirect('/post/ver/' . $postId);
			return;
		}
		
		// Calcular fecha de finalización basada en la duración
		$fechaFinalizacion = $this->calcularFechaFinalizacion($servicio['duracion']);
		
		if (!$fechaFinalizacion) {
			$this->session->flash('error', 'No se pudo calcular la fecha de finalización. Duración inválida.');
			$this->redirect('/post/ver/' . $postId);
			return;
		}
		
		// Crear la contratación
		$resultado = $contratacionModel->crear(
			$postId,
			$this->auth->user()['user_id'],
			$fechaFinalizacion
		);
		
		if ($resultado) {
			$this->session->flash('success', '¡Servicio contratado exitosamente! Puedes ver el tiempo restante en tu perfil.');
			$this->redirect('/dashboard');
		} else {
			$this->session->flash('error', 'Error al contratar el servicio');
			$this->redirect('/post/ver/' . $postId);
		}
	}
	
	/**
	 * Calcula la fecha de finalización basada en la duración del servicio
	 */
	private function calcularFechaFinalizacion($duracion) {
		if (!$duracion || strtolower($duracion) === 'a definir') {
			// Por defecto 30 días
			return date('Y-m-d H:i:s', strtotime('+30 days'));
		}
		
		$duracion = strtolower(trim($duracion));
		
		// Patrones comunes en español
		if (preg_match('/(\d+)\s*(día|dias|day|days|d)/i', $duracion, $matches)) {
			return date('Y-m-d H:i:s', strtotime("+{$matches[1]} days"));
		}
		
		if (preg_match('/(\d+)\s*(semana|semanas|week|weeks)/i', $duracion, $matches)) {
			return date('Y-m-d H:i:s', strtotime("+{$matches[1]} weeks"));
		}
		
		if (preg_match('/(\d+)\s*(mes|meses|month|months)/i', $duracion, $matches)) {
			return date('Y-m-d H:i:s', strtotime("+{$matches[1]} months"));
		}
		
		if (preg_match('/(\d+)\s*(año|años|year|years)/i', $duracion, $matches)) {
			return date('Y-m-d H:i:s', strtotime("+{$matches[1]} years"));
		}
		
		// Por defecto 30 días si no se puede parsear
		return date('Y-m-d H:i:s', strtotime('+30 days'));
	}
	/**
 * NUEVO MÉTODO: Agregar comentario a un servicio
 */
public function agregarComentario($params = []) {
    // Verificar autenticación
    if (!$this->auth->check()) {
        $this->session->flash('error', 'Debes iniciar sesión para comentar');
        $this->redirect('/login');
        return;
    }
    
    $postId = $params['id'] ?? null;
    
    if (!$postId) {
        $this->session->flash('error', 'Servicio no encontrado');
        $this->redirect('/post');
        return;
    }
    
    // Verificar que el servicio existe
    $servicio = $this->modelo->find(['post_id' => $postId]);
    
    if (!$servicio) {
        $this->session->flash('error', 'Servicio no encontrado');
        $this->redirect('/post');
        return;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $commentText = trim($this->input('comment_text'));
        
        // Validar
        if (empty($commentText)) {
            $this->session->flash('error', 'El comentario no puede estar vacío');
            $this->redirect('/post/ver/' . $postId);
            return;
        }
        
        if (strlen($commentText) < 3) {
            $this->session->flash('error', 'El comentario debe tener al menos 3 caracteres');
            $this->redirect('/post/ver/' . $postId);
            return;
        }
        
        if (strlen($commentText) > 1000) {
            $this->session->flash('error', 'El comentario no puede exceder 1000 caracteres');
            $this->redirect('/post/ver/' . $postId);
            return;
        }
        
        $commentModel = new \App\Models\ServiceComment();
        $resultado = $commentModel->crear(
            $postId, 
            $this->auth->user()['user_id'], 
            $commentText
        );
        
        if ($resultado) {
            $this->session->flash('success', 'Comentario publicado correctamente');
        } else {
            $this->session->flash('error', 'Error al publicar el comentario');
        }
    }
    
    $this->redirect('/post/ver/' . $postId);
}

/**
 * NUEVO MÉTODO: Eliminar comentario
 */
public function eliminarComentario($params = []) {
    // Verificar autenticación
    if (!$this->auth->check()) {
        $this->session->flash('error', 'Debes iniciar sesión');
        $this->redirect('/login');
        return;
    }
    
    $commentId = $params['id'] ?? null;
    
    if (!$commentId) {
        $this->session->flash('error', 'Comentario no encontrado');
        $this->redirect('/post');
        return;
    }
    
    $commentModel = new \App\Models\ServiceComment();
    
    // Obtener el comentario para saber a qué post pertenece
    $postId = $commentModel->getPostId($commentId);
    
    if (!$postId) {
        $this->session->flash('error', 'Comentario no encontrado');
        $this->redirect('/post');
        return;
    }
    
    // Obtener información del servicio
    $servicio = $this->modelo->find(['post_id' => $postId]);
    
    if (!$servicio) {
        $this->session->flash('error', 'Servicio no encontrado');
        $this->redirect('/post');
        return;
    }
    
    $userId = $this->auth->user()['user_id'];
    $isAdmin = $this->auth->user()['rol'] === 'admin';
    $isOwner = $servicio['user_id'] == $userId;
    $isCommentAuthor = $commentModel->perteneceAUsuario($commentId, $userId);
    
    // Puede eliminar si es: admin, dueño del servicio, o autor del comentario
    if ($isAdmin || $isOwner || $isCommentAuthor) {
        $resultado = $commentModel->eliminar($commentId, $userId, $isAdmin || $isOwner);
        
        if ($resultado) {
            $this->session->flash('success', 'Comentario eliminado correctamente');
        } else {
            $this->session->flash('error', 'Error al eliminar el comentario');
        }
    } else {
        $this->session->flash('error', 'No tienes permiso para eliminar este comentario');
    }
    
    $this->redirect('/post/ver/' . $postId);
}
}
