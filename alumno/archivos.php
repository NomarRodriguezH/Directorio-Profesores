<?php
require_once __DIR__ . '/../backend/config/config.php';
require_once __DIR__ . '/../backend/controllers/StudentFilesController.php';

$controller = new StudentFilesController();

if (isset($_GET['action']) && $_GET['action'] == 'download' && isset($_GET['id'])) {
    $controller->download();
} else {
    $controller->index();
}
?>