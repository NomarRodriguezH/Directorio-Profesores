<?php require_once 'frontend/templates/header.php'; ?>

<!-- Fuentes -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jersey+20&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<style>

    header {
      width: 100%;
      background-color: #151522; 
      color: white;
      text-align: center;
      padding: 30px;
      font-size: 50px;
      font-weight: bold;
    }

  body {
    margin: 0;
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
    background-image: url("https://preview.redd.it/gengar-and-the-gang-animated-desktop-wallpaper-version-v0-gpir30a1cqud1.gif?format=png8&s=be078482c9ad9e1e011efdb8b24fd3add0a6d2b3");
    background-size: 310%;
    background-position: center;
    background-repeat: repeat;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .page-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 60px 20px 80px;
    box-sizing: border-box;
  }

  .card-white {
    background: #ffffff;
    width: 60%;
    border-radius: 14px;
    padding: 36px;
    box-shadow: 0 18px 40px rgba(8,10,20,0.45);
    box-sizing: border-box;
  }
  h1 {
      margin-top: 50px;
      margin-bottom: 0px;
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      font-size: 43px;
      color: white;
      text-align: center;
      font-weight: normal ;
  }

   h5 {
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
    font-weight: bold;
    font-size: 30px;
    margin-top: 0px;
    margin-bottom: 0px;
    color: #151522;
    text-align: center;
  }

  .form-label {
    color: #151522;     /*Texto afuera de las cajitas*/
    font-size: 16px;    
    font-weight: normal;

  }

  .form-control, .form-select {          /*Texto dentro de las cajitas*/
    width: 100%;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    box-sizing: border-box;
  }


  .btn-primary {
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
    background-color: #9e78d4;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    margin-top: 20px;


  }
  .btn-primary:hover {
    background-color: #5d4b95;
  }

  .btn-secondary {
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
    background-color: #9e78d4;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    margin-top: 20px;
  }
  .btn-secondary:hover {
    background-color: #5d4b95;
  }

 .teacher-card {
  display: flex;               
  flex-direction: row;         
  align-items: center;         
  margin-bottom: 20px;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 6px 18px rgba(8,10,20,0.25);
  font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
  transition: transform 0.2s;
}

  .teacher-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 24px rgba(8,10,20,0.35);
  }

  .card-img-top-container {
    height: 220px;
    width: 200px;
    overflow: hidden;
  }
  .card-img-top {
    /*text-align: ;*/
    height: 100%;
    width: 100%;
    object-fit: cover;
  }
  .card-body {
    padding: 20px;
  }
  .card-title {
    font-size: 22px;
    color: #151522;
    margin-bottom: 10px;
  }
  .card-text {
    font-size: 16px;
    margin-bottom: 8px;
    color: #333;
  }
  .rating {
    font-size: 1.2em;
  }

  .pagination .page-link {
    color: #9e78d4;
    border-radius: 8px;
    margin: 0 3px;
  }
  .pagination .active .page-link {
    background-color: #9e78d4;
    color: white;
    border: none;
  }
</style>
<header>Profesores Gengar</header>

<h1>Profesores Disponibles</h1>

<div class="page-wrapper">
  <div class="card-white">
    
    <!-- Filtros -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0">Filtros de Búsqueda</h5>
      </div>
      <div class="card-body">
        <form method="GET" action="lista-de-profesores" class="row g-3">
          <div class="col-md-3">
            <label for="busqueda" class="form-label">Búsqueda general</label>
            <input type="text" class="form-control" id="busqueda" name="busqueda" 
                  value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Nombre, apellido o especialidad">
          </div>
          
          <div class="col-md-3">
            <label for="especialidad" class="form-label">Especialidad</label>
            <select class="form-select" id="especialidad" name="especialidad">
              <option value="">Todas las especialidades</option>
              <?php foreach ($especialidades as $esp): ?>
                <option value="<?php echo htmlspecialchars($esp); ?>" 
                  <?php echo $especialidad === $esp ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($esp); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div class="col-md-2">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado">
              <option value="">Todos los estados</option>
              <?php foreach ($estados as $est): ?>
                <option value="<?php echo htmlspecialchars($est); ?>" 
                  <?php echo $estado === $est ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($est); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div class="col-md-2">
            <label for="delegacion" class="form-label">Delegación/Municipio</label>
            <select class="form-select" id="delegacion" name="delegacion" <?php echo empty($estado) ? 'disabled' : ''; ?>>
              <option value="">Todas las delegaciones</option>
              <?php foreach ($delegaciones as $del): ?>
                <option value="<?php echo htmlspecialchars($del); ?>" 
                  <?php echo $delegacion === $del ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($del); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div class="col-md-2">
            <label for="precio_min" class="form-label">Precio Mínimo</label>
            <input type="number" class="form-control" id="precio_min" name="precio_min" 
                  value="<?php echo $precio_min > 0 ? $precio_min : ''; ?>" placeholder="$ Mínimo" min="0">
          </div>
          
          <div class="col-md-2">
            <label for="precio_max" class="form-label">Precio Máximo</label>
            <input type="number" class="form-control" id="precio_max" name="precio_max" 
                  value="<?php echo $precio_max > 0 ? $precio_max : ''; ?>" placeholder="$ Máximo" min="0">
          </div>
          
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
            <a href="lista-de-profesores" class="btn btn-secondary">Limpiar Filtros</a>
          </div>
        </form>
      </div>
    </div>
    
    <!-- Resultados -->
    <div class="row">
      <?php if (count($teachers) > 0): ?>
        <?php foreach ($teachers as $teacher): ?>
          <div class="col-md-4 mb-4">
            <div class="card h-100 teacher-card">
              <div class="card-img-top-container">
                <img src="<?php echo !empty($teacher['FotoURL']) ? 'frontend/assets/images/' . htmlspecialchars($teacher['FotoURL']) : 'frontend/assets/images/default-teacher.jpg'; ?>" 
                      class="card-img-top" alt="<?php echo htmlspecialchars($teacher['Nombre'] . ' ' . $teacher['ApPaterno']); ?>">
              </div>
              <div class="card-body">
                <h5 class="card-title">
                  <?php echo htmlspecialchars($teacher['Nombre'] . ' ' . $teacher['ApPaterno'] . ' ' . $teacher['ApMaterno']); ?>
                </h5>
                
                <p class="card-text">
                  <strong>Especialidad:</strong> <?php echo htmlspecialchars($teacher['Especialidad']); ?>
                </p>
                
                <p class="card-text">
                  <strong>Ubicación:</strong> <?php echo htmlspecialchars($teacher['Delegacion'] . ', ' . $teacher['Estado']); ?>
                </p>
                
                <p class="card-text">
                  <strong>Precio:</strong> $<?php echo number_format($teacher['PrecioMin'], 2); ?> - $<?php echo number_format($teacher['PrecioMax'], 2); ?> /hora
                </p>
                
                <?php if ($teacher['CalificacionPromedio'] > 0): ?>
                  <div class="rating mb-2">
                    <span class="text-warning">
                      <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= floor($teacher['CalificacionPromedio'])): ?>
                          ★
                        <?php elseif ($i - 0.5 <= $teacher['CalificacionPromedio']): ?>
                          ⭐
                        <?php else: ?>
                          ☆
                        <?php endif; ?>
                      <?php endfor; ?>
                    </span>
                    <span class="text-muted ms-1">
                      (<?php echo number_format($teacher['CalificacionPromedio'], 1); ?> · <?php echo $teacher['TotalCalificaciones']; ?> calificaciones)
                    </span>
                  </div>
                <?php else: ?>
                  <span class="text-muted">Sin calificaciones aún</span>
                <?php endif; ?>
                
                <p></p>
                
                <a href="ver-profesor?correo=<?php echo urlencode($teacher['Correo']); ?>" 
                  class="btn btn-primary mt-2">Ver Perfil</a>
              




              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-info text-center">
            <h4>No se encontraron profesores</h4>
            <p>Intenta ajustar los filtros de búsqueda o <a href="lista-de-profesores">ver todos los profesores</a></p>
          </div>
        </div>
      <?php endif; ?>
    </div>
    
    <!-- Paginación -->
    <?php if ($total_paginas > 1): ?>
      <nav aria-label="Paginación de profesores" class="mt-4">
        <ul class="pagination justify-content-center">
          <?php if ($pagina_actual > 1): ?>
            <li class="page-item">
              <a class="page-link" href="<?php echo getPaginationUrl(1); ?>">Primera</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="<?php echo getPaginationUrl($pagina_actual - 1); ?>">Anterior</a>
            </li>
          <?php endif; ?>
          
          <?php for ($i = max(1, $pagina_actual - 2); $i <= min($total_paginas, $pagina_actual + 2); $i++): ?>
            <li class="page-item <?php echo $i == $pagina_actual ? 'active' : ''; ?>">
              <a class="page-link" href="<?php echo getPaginationUrl($i); ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>
          
          <?php if ($pagina_actual < $total_paginas): ?>
            <li class="page-item">
              <a class="page-link" href="<?php echo getPaginationUrl($pagina_actual + 1); ?>">Siguiente</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="<?php echo getPaginationUrl($total_paginas); ?>">Última</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
</div>

<?php 
function getPaginationUrl($pagina) {
  $params = $_GET;
  $params['pagina'] = $pagina;
  return 'teachers.php?' . http_build_query($params);
}
?>

<script>
// cambiar delegaciones según el estado seleccionado
document.getElementById('estado').addEventListener('change', function() {
  const estado = this.value;
  const delegacionSelect = document.getElementById('delegacion');
  
  if (estado) {
    delegacionSelect.disabled = false;
    delegacionSelect.value = '';
  } else {
    delegacionSelect.disabled = true;
    delegacionSelect.value = '';
  }
});
</script>

<?php require_once 'frontend/templates/footer.php'; ?>
