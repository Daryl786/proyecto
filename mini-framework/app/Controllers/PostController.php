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
		
		if ($this->auth->check()) {
			$usuarioYaCalificó = $ratingModel->usuarioYaCalificó($postId, $this->auth->user()['user_id']);
			$calificacionUsuario = $ratingModel->getCalificacionUsuario($postId, $this->auth->user()['user_id']);
		}
		
		$this->render('post/ver', [
			'titulo' => $servicio['title'],
			'servicio' => $servicio,
			'calificaciones' => $calificaciones,
			'usuarioYaCalificó' => $usuarioYaCalificó,
			'calificacionUsuario' => $calificacionUsuario
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
}
