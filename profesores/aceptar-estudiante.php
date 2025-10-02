<?php
    require_once '../backend/config/config.php';
    require_once  '../backend/controllers/StudentController.php';
    $controller = new StudentController();
    $controller->acceptInClass();
?>