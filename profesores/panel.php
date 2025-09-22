<?php
    require_once '../backend/config/config.php';
    require_once  '../backend/controllers/TeacherAuthController.php';

    $controller = new TeacherAuthController();
    $controller->showDatosProfesor();
?>