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
			$categoryId = $this->input('category_id');
			
			// Validar
			$errors = $this->validate([
				'title' => 'required|min:5',
				'content' => 'required|min:20',
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
}
