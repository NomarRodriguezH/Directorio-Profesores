<?php
require_once __DIR__ . '/../backend/config/config.php';
require_once __DIR__ . '/../backend/controllers/StudentClassesController.php';

$controller = new StudentClassesController();

if (isset($_GET['action']) && $_GET['action'] == 'view' && isset($_GET['id'])) {
    $controller->viewClass();
} else {
    $controller->index();
}
?>