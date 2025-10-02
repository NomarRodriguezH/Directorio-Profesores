<?php
require_once __DIR__ . '/../backend/config/config.php';
require_once __DIR__ . '/../backend/controllers/StudentClassesController.php';

$controller = new StudentClassesController();
$controller->cancelEnrollment();
?>