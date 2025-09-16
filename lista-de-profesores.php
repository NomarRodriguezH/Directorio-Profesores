<?php
require_once 'backend/config/config.php';
require_once 'backend/controllers/TeacherController.php';

$controller = new TeacherController();
$controller->list();
?>