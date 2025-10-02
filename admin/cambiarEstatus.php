<?php
require_once __DIR__ . '/../backend/config/config.php';
require_once __DIR__ . '/../backend/controllers/AdminController.php';

$controller = new AdminController();
$controller->toggleUserStatus();
?>