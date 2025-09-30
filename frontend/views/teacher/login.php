<?php require_once '../frontend/templates/header.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - Profesor</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jersey+20&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  
  <style>
    body {
      margin: 0;
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      background-image: url("https://preview.redd.it/gengar-and-the-gang-animated-desktop-wallpaper-version-v0-gpir30a1cqud1.gif?format=png8&s=be078482c9ad9e1e011efdb8b24fd3add0a6d2b3");
      background-size: cover;      
      background-position: center; 
      background-repeat: repeat;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    header {
      width: 100%;
      background-color: #151522; 
      color: white;
      text-align: center;
      padding: 30px;
      font-size: 50px;
      font-weight: bold;
    }

    .titulo {
      margin-top: 60px;
      margin-bottom: 10px;
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      font-size: 40px;
      color: white;
      text-align: center;
    }

    .caja-sesion {
      background-color: white;
      margin-top: 20px;
      margin-bottom: 120px;
      padding: 30px;
      border-radius: 10px;
      width: 350px;
      text-align: center;
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
    }

    .caja-sesion input {
      width: 90%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .caja-sesion button {
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      background-color: #9e78d4;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 18px;
      margin-top: 10px;
      width: 100%;
    }

    .caja-sesion button:hover {
      background-color: #5d4b95;
    }

    .caja-sesion a {
      text-decoration: none;
      color: #4B3894;
      font-size: 14px;
    }

    .alert {
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 5px;
      font-size: 14px;
    }

    .olvidada {
      text-decoration: none; 
      color: #4B3894;
      font-size: 14px;
    }

    .olvidada:hover {
      color: black;
      text-decoration: underline;
    }



    .alert-danger { background-color: #f8d7da; color: #721c24; }
  </style>
</head>

<body>
  <header>Profesores Gengar</header>

  <div class="titulo">Inicia Sesión - Profesor</div>

  <div class="caja-sesion">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p class="mb-0"><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login">
        <input type="text" id="cedula" name="cedula" placeholder="Cédula Profesional"
               value="<?php echo isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : ''; ?>" required>

        <input type="password" id="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Continuar</button>
    </form>

    <div class="text-center mt-3">
        <p>¿No tienes cuenta? <a class="olvidada" href="registro">Regístrate como profesor</a></p>
        <p>¿Eres estudiante? <a class="olvidada" href="../login">Inicia sesión aquí</a></p>
    </div>
  </div>
</body>
</html>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/Directorio-Profesores-main/frontend/templates/footer.php'; ?>
