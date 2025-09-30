<?php require_once 'frontend/templates/header.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Estudiante</title>
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
      margin-top: 40px;
      margin-bottom: 10px;
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      font-size: 40px;
      color: white;
      text-align: center;
    }

    .caja-registro {
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      background-color: white;
      margin-top: 20px;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
      width: 400px;
      text-align: center;
    }

    .caja-registro input {
      width: 90%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .caja-registro button {
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

    .caja-registro button:hover {
      background-color: #5d4b95;
    }

    .caja-registro a {
      text-decoration: none;
      color: #4B3894;
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

    .alert {
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 5px;
      font-size: 14px;
    }
    .alert-danger { background-color: #f8d7da; color: #721c24; }
    .alert-success { background-color: #d4edda; color: #155724; }

  </style>
</head>
<body>
  <header>
    Profesores Gengar
  </header>

  <div class="titulo">Registro de Estudiante</div>

  <div class="caja-registro">
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
          <p class="mb-0"><?php echo $error; ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="alert alert-success">
        <?php echo $_SESSION['success_message']; ?>
        <?php unset($_SESSION['success_message']); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="registro-estudiante">
      <input type="email" id="email" name="email" placeholder="Correo Electrónico *"
        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>

      <input type="text" id="nombre" name="nombre" placeholder="Nombre *"
        value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>

      <input type="text" id="apPaterno" name="apPaterno" placeholder="Apellido Paterno *"
        value="<?php echo isset($_POST['apPaterno']) ? htmlspecialchars($_POST['apPaterno']) : ''; ?>" required>

      <input type="text" id="apMaterno" name="apMaterno" placeholder="Apellido Materno"
        value="<?php echo isset($_POST['apMaterno']) ? htmlspecialchars($_POST['apMaterno']) : ''; ?>">

      <input type="tel" id="celular" name="celular" placeholder="Celular"
        value="<?php echo isset($_POST['celular']) ? htmlspecialchars($_POST['celular']) : ''; ?>">

      <input type="password" id="password" name="password" placeholder="Contraseña *" required>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña *" required>

      <button type="submit">Registrarse</button>
    </form>


    <div class="text-center mt-3">
        <p>¿Ya tienes cuenta? <a class="olvidada" href="login.php">Inicia sesión aquí</a></p>
        
    </div>


  </div>
</body>
</html>

<?php require_once 'frontend/templates/footer.php'; ?>
