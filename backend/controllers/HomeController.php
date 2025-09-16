<?php
class HomeController {
    public function index() {
        $pagina='Inicio | Directorio de Profesores';
        $title = "Página de Inicio";
        $welcome_message = "Bienvenido a nuestro sitio";
        require_once 'frontend/views/home/index.php';
    }
}
?>