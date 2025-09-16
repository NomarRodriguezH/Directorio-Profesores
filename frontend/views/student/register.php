<?php require_once 'frontend/templates/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Registro de Estudiante</h2>
                </div>
                <div class="card-body">
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
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apPaterno" class="form-label">Apellido Paterno *</label>
                                <input type="text" class="form-control" id="apPaterno" name="apPaterno" 
                                       value="<?php echo isset($_POST['apPaterno']) ? htmlspecialchars($_POST['apPaterno']) : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="apMaterno" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="apMaterno" name="apMaterno" 
                                   value="<?php echo isset($_POST['apMaterno']) ? htmlspecialchars($_POST['apMaterno']) : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="tel" class="form-control" id="celular" name="celular" 
                                   value="<?php echo isset($_POST['celular']) ? htmlspecialchars($_POST['celular']) : ''; ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña *</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'frontend/templates/footer.php'; ?>