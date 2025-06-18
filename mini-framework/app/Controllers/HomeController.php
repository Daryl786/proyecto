<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        return $this->render('home', [
            'title' => 'Bienvenidos al proyecto 3333'
        ]);
    }
}
