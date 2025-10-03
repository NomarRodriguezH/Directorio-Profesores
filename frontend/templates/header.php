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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+20&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        
        .navbar {
            background-color: #151522;  
            margin: 0;
            font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
            font-size: 20px;
            width: 100%;    
            height: 90px;
            text-align: left;
            box-sizing: border-box; 
        }

        .navbar-brand {                 /* Directorio de Profesores */
            color: #9e78d4;
            font-size: 50px;
            font-weight: bold;
            text-decoration: none;

        }
        .navbar-brand:hover {
            color: #c8aef2;
        }

        .navbar-text {                /* Hola, user */
            color: #D2C5E6;
            margin-top: 5px;
            margin-right: 50px;
            font-size: 18px;

        }

        .nav-link {                 /* Mi Perfil  |  Mis Clases | Cerrar Sesión */
            color: #ffffff;
            margin-left: 15px;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
        }

        .nav-link:hover {
            background-color: #916FBE;
            color: white;
        }
    </style>
</head>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        
        <a class="navbar-brand" href="index.php"><?php echo SITE_NAME; ?></a>
        
        <div class="navbar-nav ms-auto">
            <?php if ($isLoggedIn): ?>
                <span class="navbar-text me-3">Hola, <?php echo $userName; ?></span>
                <a class="nav-link" href="panel.php">Mi Perfil</a>
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
