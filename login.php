<?php
require_once 'backend/config/config.php';
require_once 'backend/controllers/UserController.php';

$controller = new UserController();
$controller->login();
?>