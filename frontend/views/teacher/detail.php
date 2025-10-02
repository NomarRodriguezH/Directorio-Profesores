<?php require_once 'frontend/templates/header.php'; ?>
<body>
<header>
    Profesores Gengar
  </header>

<div class="teacher-page">
    <div class="container mt-4 content-box">
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <!-- Columna izquierda - Información del profesor -->
            <div class="col-md-4">
                <div class="card mb-4 text-center profile-card">
                    <div class="card-body">
                        <img src="<?php echo !empty($teacher['FotoURL']) ? 'frontend/assets/images/' . htmlspecialchars($teacher['FotoURL']) : 'frontend/assets/images/default-teacher.jpg'; ?>" 
                             class="rounded-circle mb-3 profile-img" 
                             alt="Foto del profesor">
                        
                        <h2 class="card-title"><?php echo htmlspecialchars($teacher['Nombre'] . ' ' . $teacher['ApPaterno'] . ' ' . $teacher['ApMaterno']); ?></h2>
                        
                        <p class="specialty"><?php echo htmlspecialchars($teacher['Especialidad']); ?></p>
                        
                        <?php if ($teacher['CalificacionPromedio'] > 0): ?>
                            <div class="rating mb-2">
                                <span class="stars">
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
                                <span class="d-block">
                                    <?php echo number_format($teacher['CalificacionPromedio'], 1); ?> · <?php echo $teacher['TotalCalificaciones']; ?> calificaciones
                                </span>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">Sin calificaciones aún</span>
                        <?php endif; ?>
                        
                        <div class="mt-3 price-box">
                            <p><strong>Precio por hora:</strong><br>
                            $<?php echo number_format($teacher['PrecioMin'], 2); ?> - $<?php echo number_format($teacher['PrecioMax'], 2); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4 contact-card">
                    <div class="card-header">
                        <h5 class="mb-0">--> Información de Contacto</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>📧 Email:</strong><br>
                        <?php echo htmlspecialchars($teacher['Correo']); ?></p>
                        
                        <p><strong>📞 Teléfono:</strong><br>
                        <?php echo htmlspecialchars($teacher['Celular']); ?></p>
                        
                        <p><strong>📍 Ubicación:</strong><br>
                        <?php echo htmlspecialchars($teacher['Calle']); ?> 
                        <?php echo !empty($teacher['NoExt']) ? '#' . $teacher['NoExt'] : ''; ?>
                        <?php echo !empty($teacher['NoInt']) ? 'Int. ' . $teacher['NoInt'] : ''; ?><br>
                        <?php echo htmlspecialchars($teacher['Colonia']); ?>, 
                        <?php echo htmlspecialchars($teacher['Delegacion']); ?><br>
                        <?php echo htmlspecialchars($teacher['Estado']); ?>, 
                        C.P. <?php echo htmlspecialchars($teacher['CP']); ?></p>
                        
                        <p><strong>📅 Miembro desde:</strong><br>
                        <?php echo date('d/m/Y', strtotime($teacher['FechaIngreso'])); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Columna derecha - Contenido principal -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">--> Sobre mí</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($teacher['Descripcion'])): ?>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($teacher['Descripcion'])); ?></p>
                        <?php else: ?>
                            <p class="text-muted">El profesor no ha agregado una descripción aún.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Clases disponibles -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">--> Clases Disponibles</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($classes) > 0): ?>
                            <div class="row">
                                <?php foreach ($classes as $class): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 class-card">
                                            <div class="card-body">
                                                <h6 class="card-title"><?php echo htmlspecialchars($class['Materia']); ?></h6>
                                                
                                                <?php if (!empty($class['Nivel'])): ?>
                                                    <span class="badge bg-primary mb-2"><?php echo htmlspecialchars($class['Nivel']); ?></span>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($class['Modalidad'])): ?>
                                                    <span class="badge bg-secondary mb-2"><?php echo htmlspecialchars($class['Modalidad']); ?></span>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($class['Descripcion'])): ?>
                                                    <p class="card-text small"><?php echo nl2br(htmlspecialchars(substr($class['Descripcion'], 0, 100) . '...')); ?></p>
                                                <?php endif; ?>
                                                
                                                <!-- Horarios -->
                                                <div class="mt-2">
                                                    <strong>Horarios:</strong>
                                                    <div class="small">
                                                        <?php
                                                        $dias = ['Lu' => 'Lun', 'Ma' => 'Mar', 'Mi' => 'Mié', 'Ju' => 'Jue', 'Vi' => 'Vie', 'Sa' => 'Sáb', 'Do' => 'Dom'];
                                                        $horarios = [];
                                                        
                                                        foreach ($dias as $diaCode => $diaNombre) {
                                                            $horaInicio = $class[$diaCode . 'HI'];
                                                            $horaFin = $class[$diaCode . 'HF'];
                                                            
                                                            if (!empty($horaInicio) && !empty($horaFin)) {
                                                                $horarios[] = $diaNombre . ' ' . substr($horaInicio, 0, 5) . '-' . substr($horaFin, 0, 5);
                                                            }
                                                        }
                                                        
                                                        if (!empty($horarios)) {
                                                            echo implode('<br>', $horarios);
                                                        } else {
                                                            echo 'Horarios flexibles';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                
                                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'student'): ?>
                                                    <?php if (in_array($class['IdClase'], $userClasses)): ?>
                                                        <h4>Ya estas inscrito en la clase</h4>
                                                        <a href="panel.php">Ver panel</a>
                                                    <?php else: ?>
                                                        <form action="ver-profesor?correo=<?php echo urlencode($teacher['Correo']); ?>" method="POST">
                                                            <input type="submit" class="btn btn-sm btn-success mt-2" data-bs-toggle="modal" data-bs-target="#inscribirModal" value="Inscribirse"
                                                                data-clase-id="<?php echo $class['IdClase']; ?>"
                                                                data-clase-name="<?php echo htmlspecialchars($class['Materia']); ?>">
                                                            <input type="hidden" name="IdClase" value="<?php echo $class['IdClase']; ?>">
                                                            <input type="hidden" name="Correo" value="<?php echo $_GET['correo']; ?>">
                                                        </form>
                                                    <?php endif; ?>
                                                <?php elseif (!isset($_SESSION['user_id'])): ?>
                                                    <a href="login.php" class="btn btn-sm btn-outline-primary mt-2">Iniciar sesión para inscribirse</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">El profesor no tiene clases disponibles en este momento.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Reseñas -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">--> Reseñas y Calificaciones</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($ratingStats['total_reviews'] > 0): ?>
                            <!-- estadísticas -->
                            ...
                        <?php else: ?>
                            <p class="text-muted">Este profesor aún no tiene calificaciones.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>

header {
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      width: 100%;
      background-color: #151522; 
      color: white;
      text-align: center;
      padding: 30px;
      font-size: 50px;
      font-weight: bold;
    }

body {

      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      background-image: url("https://preview.redd.it/gengar-and-the-gang-animated-desktop-wallpaper-version-v0-gpir30a1cqud1.gif?format=png8&s=be078482c9ad9e1e011efdb8b24fd3add0a6d2b3");
      background-size: cover;      
      background-position: center; 
      background-repeat: repeat;
      display: flex;
      flex-direction: column;
      align-items: center;
  }


/* Recuadro principal */
.content-box {
    width: 800px;
    margin-top: 50px;
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0px 4px 15px rgba(0,0,0,0.25);
}

/* Imagen y nombre centrados */
.profile-img {
    width: 150px;
    height: 200px;
    object-fit: cover;
    border: 4px solid #9e78d4;
    display: block;        
    margin: 0 auto;       

}

.card-title {                   /* NOMBRE PROFESOR */
    font-size: 30px;
    text-align: center;
    color: #4b2e83;
    margin-bottom: 5px;
}

.specialty {
    color: #9286A3;
    text-align: center;
    font-size: 30px;
}

/* Tarjetas */
.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card-header {
    background: #9e78d4;
    color: #fff;
    margin-bottom: 0px;
    font-size: 30px;
    font-weight: bold;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

/* Rating */
.stars {
    font-size: 15px;
    color: #f5c518;
}

/* Botones */
.btn-primary {
    background: #9e78d4;
    border: none;
}

.btn-primary:hover {
    background: #7c5cbf;
}
</style>
</body>
<?php require_once 'frontend/templates/footer.php'; ?>