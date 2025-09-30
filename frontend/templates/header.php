<?php
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
$userType = $isLoggedIn ? $_SESSION['user_type'] : '';
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $page_title ?></title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        
        <a class="navbar-brand" href="index.php"><?php echo "   DP"; ?></a>
        
        <div class="navbar-nav ms-auto">
           <?php if ($isLoggedIn && $userType === 'student'): ?>
            <a class="nav-link" href="../estudiantes/dashboard.php">Dashboard</a>
            <a class="nav-link" href="../estudiantes/clases.php">Mis Clases</a>
            <a class="nav-link" href="../estudiantes/archivos.php">Archivos</a>
            <?php endif; ?>
        </div>
    </div>
</nav>