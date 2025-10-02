

<style>
  body {
    font-family: "Jersey 20", sans-serif;
    background: url("https://pokewalls.wordpress.com/wp-content/uploads/2011/01/94gengar1920x1200.jpg")
      no-repeat center center fixed;
    background-size: cover;
    margin: 0;
    padding: 0;
  }

  .container {
    max-width: 1000px;
    margin: 40px auto;
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
  }

  h1{
    font-family: "Jersey 20", sans-serif; 
    text-align: center;
    font-size: 45px;
    color: #9e78d4;
    margin-bottom: 12px;
  } 

  h2, h3, h5, label {
    font-family: "Jersey 20", sans-serif; 
    font-size: 25px;
    color: #895F9E;
    margin-bottom: 12px;
  }



  .divider {
    border-bottom: 3px solid #402D49;
    margin: 25px 0;
  }

  .form-label {
    font-weight: bold;
    color: #444;
    font-size: 25px;
    color: #895F9E;  }



  .form-control,
  .form-select,
  textarea {
    font-family: "Jersey 20", sans-serif; 
    border-radius: 8px;
    border: 2px solid #ccc;
    padding: 10px;
  }

  .form-control:focus,
  .form-select:focus,
  textarea:focus {
    border-color: #9e78d4;
    outline: none;
  }

  .btn-primary {
    font-family: "Jersey 20", sans-serif; 
    background-color: #9e78d4;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-size: 22px;
    font-weight: normal;
    color: #fff;
    margin-top: 50px;
  }

  .btn-primary:hover {
    background-color: #7b5bb0;
  }

  .btn-secondary {
    font-family: "Jersey 20", sans-serif; 
    background-color: #555;
    border: none;
    text-decoration: none;
    border-radius: 8px;
    padding: 12px;
    font-size: 22px;
    font-weight: normal;
    color: #fff;
    margin-left: 40px;
    margin-top: 50px;
  }

  .btn-secondary:hover {
    background-color: #333;
  }

  .alert-danger {
    background: #ffebee;
    border-left: 6px solid #e53935;
    color: #c62828;
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-family: "Jersey 20", sans-serif; 
  }

  .day-checkbox {
    accent-color: #9e78d4;
  }

  .form-text {
    font-size: 13px;
    color: #666;
    font-family: "Jersey 20", sans-serif; 
  }

  .card-header {
    border-bottom: 2px solid #9e78d4;
    margin-bottom: 20px;
    padding-bottom: 10px;
  }
</style>

<div class="container">
  <h1>Crear Nueva Clase</h1>
  <div class="divider"></div>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
        <p class="mb-0"><?php echo $error; ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="crear-clase">
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="mb-3">
          <h2><label for="materia" class="form-label">Materia *</label>
          <input type="text" class="form-control" id="materia" name="materia"
            value="<?php echo isset($_POST['materia']) ? htmlspecialchars($_POST['materia']) : ''; ?>" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="nivel" class="form-label">Nivel *</label>
          <select class="form-select" id="nivel" name="nivel" required>
            <option value="">Seleccionar nivel</option>
            <option value="Primaria" <?php echo (isset($_POST['nivel']) && $_POST['nivel'] === 'Primaria') ? 'selected' : ''; ?>>Primaria</option>
            <option value="Secundaria" <?php echo (isset($_POST['nivel']) && $_POST['nivel'] === 'Secundaria') ? 'selected' : ''; ?>>Secundaria</option>
            <option value="Preparatoria" <?php echo (isset($_POST['nivel']) && $_POST['nivel'] === 'Preparatoria') ? 'selected' : ''; ?>>Preparatoria</option>
            <option value="Universidad" <?php echo (isset($_POST['nivel']) && $_POST['nivel'] === 'Universidad') ? 'selected' : ''; ?>>Universidad</option>
            <option value="Posgrado" <?php echo (isset($_POST['nivel']) && $_POST['nivel'] === 'Posgrado') ? 'selected' : ''; ?>>Posgrado</option>
            <option value="Curso" <?php echo (isset($_POST['nivel']) && $_POST['nivel'] === 'Curso') ? 'selected' : ''; ?>>Curso/Taller</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-6">
        <div class="mb-3">
          <label for="modalidad" class="form-label">Modalidad *</label>
          <select class="form-select" id="modalidad" name="modalidad" required>
            <option value="">Seleccionar modalidad</option>
            <option value="Presencial" <?php echo (isset($_POST['modalidad']) && $_POST['modalidad'] === 'Presencial') ? 'selected' : ''; ?>>Presencial</option>
            <option value="Virtual" <?php echo (isset($_POST['modalidad']) && $_POST['modalidad'] === 'Virtual') ? 'selected' : ''; ?>>Virtual</option>
            <option value="Híbrido" <?php echo (isset($_POST['modalidad']) && $_POST['modalidad'] === 'Híbrido') ? 'selected' : ''; ?>>Híbrido</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="maxEstudiantes" class="form-label">Máximo de Estudiantes</label>
          <input type="number" class="form-control" id="maxEstudiantes" name="maxEstudiantes"
            value="<?php echo isset($_POST['maxEstudiantes']) ? htmlspecialchars($_POST['maxEstudiantes']) : '1'; ?>" min="1" max="50">
          <div class="form-text">Número máximo de estudiantes para esta clase</div>
        </div>
      </div>
    </div>

    <div class="mb-4">
      <label for="descripcion" class="form-label">Descripción *</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required><?php echo isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : ''; ?></textarea>
      <div class="form-text">Describe los objetivos, temas y metodología de la clase</div>
    </div>

    <div class="mb-4">
      <h3>Horarios de la Clase *</h3>
      <p class="form-text">Selecciona los días y horarios en que impartirás esta clase</p>

      <?php
      $dias = [
        'lu' => 'Lunes',
        'ma' => 'Martes',
        'mi' => 'Miércoles',
        'ju' => 'Jueves',
        'vi' => 'Viernes',
        'sa' => 'Sábado',
        'do' => 'Domingo'
      ];
      ?>

      <?php foreach ($dias as $code => $nombre): ?>
        <div class="row mb-2">
          <div class="col-md-3">
            <div class="form-check">
              <input type="checkbox" class="form-check-input day-checkbox"
                id="<?php echo $code; ?>_check" data-day="<?php echo $code; ?>">
              <label class="form-check-label" for="<?php echo $code; ?>_check">
                <?php echo $nombre; ?>
              </label>
            </div>
          </div>
          <div class="col-md-4">
            <input type="time" class="form-control time-input"
              id="<?php echo $code; ?>HI" name="<?php echo $code; ?>HI"
              value="<?php echo isset($_POST[$code.'HI']) ? htmlspecialchars($_POST[$code.'HI']) : ''; ?>"
              disabled>
          </div>
          <div class="col-md-4">
            <input type="time" class="form-control time-input"
              id="<?php echo $code; ?>HF" name="<?php echo $code; ?>HF"
              value="<?php echo isset($_POST[$code.'HF']) ? htmlspecialchars($_POST[$code.'HF']) : ''; ?>"
              disabled>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary btn-lg">Crear Clase</button>
      <a href="panel" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const checkboxes = document.querySelectorAll('.day-checkbox');

  checkboxes.forEach(checkbox => {
    const day = checkbox.getAttribute('data-day');
    const hiInput = document.getElementById(day + 'HI');
    const hfInput = document.getElementById(day + 'HF');

    checkbox.addEventListener('change', function() {
      hiInput.disabled = !this.checked;
      hfInput.disabled = !this.checked;

      if (!this.checked) {
        hiInput.value = '';
        hfInput.value = '';
      }
    });

    if (hiInput.value || hfInput.value) {
      checkbox.checked = true;
      hiInput.disabled = false;
      hfInput.disabled = false;
    }
  });
});
</script>

<?php require_once '../frontend/templates/footer.php'; ?>
