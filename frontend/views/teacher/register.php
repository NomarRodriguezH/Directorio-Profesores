<?php require_once '../frontend/templates/header.php'; 
// require_once __DIR__ . '/../../templates/header.php'; 
?>

<!-- Fuentes (Jersey 20 + Urbanist) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jersey+20&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<style>
 
  body {
    margin: 0;
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      background-image: url("https://preview.redd.it/gengar-and-the-gang-animated-desktop-wallpaper-version-v0-gpir30a1cqud1.gif?format=png8&s=be078482c9ad9e1e011efdb8b24fd3add0a6d2b3");
      background-size: 340%;
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
      font-weight: normal;
    }

    .titulo {
      margin-top: 100px;
      margin-bottom: 0px;
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      font-size: 50px;
      color: white;
      text-align: center;
    }

  /* Wrapper para centrar el contenido y dejar espacio respecto al header */
  .page-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 60px 20px 80px;
    box-sizing: border-box;
  }

  /* Contenedor blanco principal*/
  .card-white {
    background: #ffffff;
    width: 680px;
    max-width: 95%;
    border-radius: 14px;
    padding: 36px;
    box-shadow: 0 18px 40px rgba(8,10,20,0.45);
    box-sizing: border-box;
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
  }

  /* Cabecera dentro del contenedor */
  .card-white .card-header {
    text-align: center;
    margin-bottom: 18px;
  }

  .card-white .card-header p {
    margin: 8px 0 0;
    color: #151522;
    font-size: 23px;
  }

  /* Grid responsive simple */
  .row { display: flex; flex-wrap: wrap; gap: 16px; margin: 0 -8px; }
  .col-md-6 { width: calc(50% - 8px); box-sizing: border-box; padding: 0 8px; }
  .col-md-4 { width: calc(33.333% - 10.666px); box-sizing: border-box; padding: 0 8px; }
  .col-md-3 { width: calc(25% - 12px); box-sizing: border-box; padding: 0 8px; }
  .col-md-5 { width: calc(41.666% - 10.666px); box-sizing: border-box; padding: 0 8px; }
  .col-md-10 { width: calc(83.333% - 13.333px); box-sizing: border-box; padding: 0 8px; }

/*Texto negro*/
  .form-label {
    display: block;
    margin-bottom: 5px;
    margin-top: 5px;
    color: black;
    font-weight: normal;
    font-size: 16px;
  }

/*Cajitas de información*/
  .form-control {
    width: 100%;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #dfdfe3;
    font-size: 14px;
    box-sizing: border-box;
    transition: box-shadow .18s, border-color .18s;
  }

/*Comentarios */
  .form-text {
    font-size: 14px;
    color: #7a728b;
    margin-top: 6px;
  }

  
  .btn-primary {
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
  .btn-primary:hover {
    background-color: #5d4b95;
  }

  
  .alert-danger {
    background: #fff0f2;
    color: #7a1f2a;
    padding: 10px 12px;
    border-radius: 8px;
    margin-bottom: 14px;
    font-size: 14px;
  }

  .mb-3 {
    color: #5F4373;
    font-size: 20px;
    margin-bottom: 10px;

  }


  .alert-danger p { margin: 6px 0; }

  #vinculo {
    text-align: center;
  }
  
  a { color: 
    #916fbe; 
    text-decoration: none; 
    font-weight: normal; 
    }

  a:hover { 
    color: black; 
    text-decoration: no-underline; 
    }

    #login_:hover { 
    color: black; 
    text-decoration: underline; 
    }
  
  #imagePreview img { max-width: 200px; max-height: 200px; border-radius: 8px; display:block; margin: 0 auto; }
</style>
<header>Profesores Gengar</header>
<div class="titulo">Registro de Profesor</div>

<div class="page-wrapper">
  <div class="card-white">

    <div class="card-header">
      
      <p>Completa tu información para unirte a nuestra plataforma.</p>
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

        <input type="hidden" name="fechaIngreso" value="<?php echo date('Y-m-d'); ?>">

        <div class="d-grid gap-2 mt-4">
          <button type="submit" class="btn-primary btn-lg">Registrarse como Profesor</button>
          <p class="text-center mt-3" id="vinculo">
            ¿Ya tienes cuenta? <a href="login" id="login_">Inicia sesión aquí</a>
          </p>
        </div>
      </form>
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

document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
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
    const prev = document.getElementById('imagePreview');
    if(prev) prev.remove();
}
</script>

<?php require_once '../frontend/templates/footer.php'; ?>
