<?php
require_once 'backend/config/config.php';
require_once 'backend/controllers/HomeController.php';

$controller = new HomeController();
$controller->index();
?>