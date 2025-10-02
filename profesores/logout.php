<?php
    require_once '../backend/controllers/UserController.php';
    $userController = new UserController();
    $userController->logout();
?>