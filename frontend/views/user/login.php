<?php require_once 'frontend/templates/header.php'; ?>

<div class="container">
    <h1>Iniciar Sesión</h1>
    
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="login.php">
        <div>
            <label>Usuario:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Ingresar</button>
    </form>
</div>

<?php require_once 'frontend/templates/footer.php'; ?>