<?php require_once '../frontend/templates/header.php'; 
// require_once __DIR__ . '/../../templates/header.php'; 
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Registro de Profesor</h2>
                    <p class="text-muted mb-0">Completa tu información para unirte a nuestra plataforma</p>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <p class="mb-0"><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="registro" enctype="multipart/form-data">
                        <h5 class="mb-3 border-bottom pb-2">Información Profesional</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cedula" class="form-label">Cédula Profesional *</label>
                                    <input type="text" class="form-control" id="cedula" name="cedula" 
                                           value="<?php echo isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : ''; ?>" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="especialidad" class="form-label">Especialidad *</label>
                                    <input type="text" class="form-control" id="especialidad" name="especialidad" 
                                           value="<?php echo isset($_POST['especialidad']) ? htmlspecialchars($_POST['especialidad']) : ''; ?>" required>
                                    <div class="form-text">Ej: Matemáticas, Física, Química, etc.</div>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Información Personal</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="apPaterno" class="form-label">Apellido Paterno *</label>
                                    <input type="text" class="form-control" id="apPaterno" name="apPaterno" 
                                           value="<?php echo isset($_POST['apPaterno']) ? htmlspecialchars($_POST['apPaterno']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="apMaterno" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="apMaterno" name="apMaterno" 
                                           value="<?php echo isset($_POST['apMaterno']) ? htmlspecialchars($_POST['apMaterno']) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="celular" class="form-label">Celular *</label>
                                    <input type="tel" class="form-control" id="celular" name="celular" 
                                           value="<?php echo isset($_POST['celular']) ? htmlspecialchars($_POST['celular']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo Electrónico *</label>
                                    <input type="email" class="form-control" id="correo" name="correo" 
                                           value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Foto de perfil -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto de Perfil</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            <div class="form-text">Formatos: JPG, PNG, GIF. Máximo 2MB. Opcional.</div>
                        </div>
                        
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Precios por Hora</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="precioMin" class="form-label">Precio Mínimo ($) *</label>
                                    <input type="number" class="form-control" id="precioMin" name="precioMin" 
                                           value="<?php echo isset($_POST['precioMin']) ? htmlspecialchars($_POST['precioMin']) : '200'; ?>" min="0" step="50" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="precioMax" class="form-label">Precio Máximo ($) *</label>
                                    <input type="number" class="form-control" id="precioMax" name="precioMax" 
                                           value="<?php echo isset($_POST['precioMax']) ? htmlspecialchars($_POST['precioMax']) : '500'; ?>" min="0" step="50" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dirección -->
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Dirección</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado *</label>
                                    <input type="text" class="form-control" id="estado" name="estado" 
                                           value="<?php echo isset($_POST['estado']) ? htmlspecialchars($_POST['estado']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="delegacion" class="form-label">Delegación/Municipio *</label>
                                    <input type="text" class="form-control" id="delegacion" name="delegacion" 
                                           value="<?php echo isset($_POST['delegacion']) ? htmlspecialchars($_POST['delegacion']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="cp" class="form-label">Código Postal *</label>
                                    <input type="text" class="form-control" id="cp" name="cp" 
                                           value="<?php echo isset($_POST['cp']) ? htmlspecialchars($_POST['cp']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="colonia" class="form-label">Colonia *</label>
                                    <input type="text" class="form-control" id="colonia" name="colonia" 
                                           value="<?php echo isset($_POST['colonia']) ? htmlspecialchars($_POST['colonia']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="calle" class="form-label">Calle *</label>
                                    <input type="text" class="form-control" id="calle" name="calle" 
                                           value="<?php echo isset($_POST['calle']) ? htmlspecialchars($_POST['calle']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="noExt" class="form-label">Número Exterior</label>
                                    <input type="text" class="form-control" id="noExt" name="noExt" 
                                           value="<?php echo isset($_POST['noExt']) ? htmlspecialchars($_POST['noExt']) : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="noInt" class="form-label">Número Interior</label>
                                    <input type="text" class="form-control" id="noInt" name="noInt" 
                                           value="<?php echo isset($_POST['noInt']) ? htmlspecialchars($_POST['noInt']) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción Profesional</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4"><?php echo isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : ''; ?></textarea>
                            <div class="form-text">Describe tu experiencia, metodología de enseñanza y enfoque pedagógico</div>
                        </div>
                        
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Seguridad</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña *</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="form-text">Mínimo 6 caracteres</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- MANEJAR ESTO EN EL FOCKING BACK -->
                        <input type="hidden" name="fechaIngreso" value="<?php echo date('Y-m-d'); ?>">
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Registrarse como Profesor</button>
                            <p class="text-center mt-3">
                                ¿Ya tienes cuenta? <a href="login">Inicia sesión aquí</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validación de precios en tiempo real
document.getElementById('precioMin').addEventListener('change', function() {
    const precioMin = parseFloat(this.value);
    const precioMax = parseFloat(document.getElementById('precioMax').value);
    
    if (precioMin > precioMax) {
        document.getElementById('precioMax').value = precioMin;
    }
});

document.getElementById('precioMax').addEventListener('change', function() {
    const precioMin = parseFloat(document.getElementById('precioMin').value);
    const precioMax = parseFloat(this.value);
    
    if (precioMax < precioMin) {
        alert('El precio máximo no puede ser menor al precio mínimo');
        this.value = precioMin;
    }
});

// Vista previa de la imagen
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Crear vista previa si no existe
            let preview = document.getElementById('imagePreview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'imagePreview';
                preview.className = 'mt-3 text-center';
                document.querySelector('form').insertBefore(preview, document.querySelector('.d-grid'));
            }
            
            preview.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeImage()">Eliminar imagen</button>
                </div>
            `;
        }
        reader.readAsDataURL(file);
    }
});

function removeImage() {
    document.getElementById('foto').value = '';
    document.getElementById('imagePreview').remove();
}
</script>

<?php require_once '../frontend/templates/footer.php'; ?>