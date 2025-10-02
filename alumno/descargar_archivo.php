<?php
require_once __DIR__ . '/../backend/config/config.php';
require_once __DIR__ . '/../backend/controllers/StudentFilesController.php';

$controller = new StudentFilesController();
$controller->download();
?>