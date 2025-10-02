<?php
require_once  '../backend/config/config.php';
require_once  '../backend/controllers/AdminController.php';

$controller = new AdminController();
$controller->dashboard();
?>