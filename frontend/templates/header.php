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
	<title><?php echo $pagina ?></title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        
        <a class="navbar-brand" href="index.php"><?php echo SITE_NAME; ?></a>
        
        <div class="navbar-nav ms-auto">
            <?php if ($isLoggedIn): ?>
                <span class="navbar-text me-3">Hola, <?php echo $userName; ?></span>
                <a class="nav-link" href="profile.php">Mi Perfil</a>
                <?php if ($userType === 'student'): ?>
                    <a class="nav-link" href="my_classes.php">Mis Clases</a>
                <?php endif; ?>
                <a class="nav-link" href="logout">Cerrar Sesión</a>
            <?php else: ?>
                <a class="nav-link" href="login">Iniciar Sesión</a>
                <a class="nav-link" href="registro-estudiante">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</nav>