	<?php
require_once __DIR__ . '/../../backend/config/config.php';
require_once __DIR__ . '/../../backend/controllers/FileController.php';

$controller = new FileController();
$controller->download();
?>