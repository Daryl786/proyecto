<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Categoria;

class CategoriaController extends Controller {

    private $modelo;

    public function __construct() {
        $this->modelo = new Categoria();
        parent::__construct();
    }

    public function index() {
        // Obtener todas las categorías con conteo de posts
        $categorias = $this->modelo->all();
        
        // Agregar conteo de posts a cada categoría
        foreach ($categorias as &$categoria) {
            $categoria['total_posts'] = $this->modelo->contarPosts($categoria['category_id']);
        }
        
        return $this->render("categoria/index", [
            "titulo" => "Gestión de Categorías",
            "categorias" => $categorias
        ]);
    }

    public function crear() {
        // Verificar que sea admin
        if (!$this->auth->check() || $this->auth->user()['rol'] !== 'admin') {
            $this->session->flash('error', 'No tienes permisos para realizar esta acción');
            $this->redirect('/categoria');
            return;
        }

        // Si es POST, procesar creación
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->input('name');
            $description = $this->input('description');

            // Validar
            $errors = $this->validate([
                'name' => 'required|min:3'
            ]);

            if (!empty($errors)) {
                return $this->render('categoria/crear', [
                    'titulo' => 'Crear Categoría',
                    'errors' => $errors,
                    'input' => $_POST
                ]);
            }

            // Crear categoría
            $resultado = $this->modelo->crear([
                'name' => $name,
                'description' => $description
            ]);

            if ($resultado) {
                $this->session->flash('success', 'Categoría creada correctamente');
                $this->redirect('/categoria');
            } else {
                $this->session->flash('error', 'Error al crear categoría');
            }
        }

        // Mostrar formulario
        return $this->render('categoria/crear', [
            'titulo' => 'Crear Categoría'
        ]);
    }

    public function editar($params = []) {
        // Verificar que sea admin
        if (!$this->auth->check() || $this->auth->user()['rol'] !== 'admin') {
            $this->session->flash('error', 'No tienes permisos para realizar esta acción');
            $this->redirect('/categoria');
            return;
        }

        $categoryId = $params['id'] ?? null;

        if (!$categoryId) {
            $this->session->flash('error', 'ID de categoría no válido');
            $this->redirect('/categoria');
            return;
        }

        // Obtener categoría
        $categoria = $this->modelo->findById($categoryId);

        if (!$categoria) {
            $this->session->flash('error', 'Categoría no encontrada');
            $this->redirect('/categoria');
            return;
        }

        // Si es POST, procesar actualización
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->input('name');
            $description = $this->input('description');

            // Validar
            $errors = $this->validate([
                'name' => 'required|min:3'
            ]);

            if (!empty($errors)) {
                return $this->render('categoria/editar', [
                    'titulo' => 'Editar Categoría',
                    'errors' => $errors,
                    'categoria' => array_merge($categoria, $_POST)
                ]);
            }

            // Actualizar categoría
            $resultado = $this->modelo->actualizar($categoryId, [
                'name' => $name,
                'description' => $description
            ]);

            if ($resultado) {
                $this->session->flash('success', 'Categoría actualizada correctamente');
                $this->redirect('/categoria');
            } else {
                $this->session->flash('error', 'Error al actualizar categoría');
            }
        }

        // Mostrar formulario
        return $this->render('categoria/editar', [
            'titulo' => 'Editar Categoría',
            'categoria' => $categoria
        ]);
    }

    public function eliminar($params = []) {
        // Verificar que sea admin
        if (!$this->auth->check() || $this->auth->user()['rol'] !== 'admin') {
            $this->session->flash('error', 'No tienes permisos para realizar esta acción');
            $this->redirect('/categoria');
            return;
        }

        $categoryId = $params['id'] ?? null;

        if (!$categoryId) {
            $this->session->flash('error', 'ID de categoría no válido');
            $this->redirect('/categoria');
            return;
        }

        // Verificar si tiene posts asociados
        $totalPosts = $this->modelo->contarPosts($categoryId);
        
        if ($totalPosts > 0) {
            $this->session->flash('error', "No se puede eliminar la categoría porque tiene $totalPosts servicio(s) asociado(s)");
            $this->redirect('/categoria');
            return;
        }

        $resultado = $this->modelo->eliminar($categoryId);

        if ($resultado) {
            $this->session->flash('success', 'Categoría eliminada correctamente');
        } else {
            $this->session->flash('error', 'Error al eliminar categoría');
        }

        $this->redirect('/categoria');
    }
}
