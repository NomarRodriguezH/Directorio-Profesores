<?php
require_once 'backend/config/config.php';
require_once 'backend/controllers/StudentDashboardController.php';

$controller = new StudentDashboardController();
$controller->index();
?>