<?php require_once '../frontend/templates/header.php'; ?>

<style>
        body {
      margin: 0;
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      background-image: url("https://wallpapersok.com/images/hd/a-gengar-in-an-eerie-patterned-forest-of-purple-pokemons-c8bazu8jid3fpccm-3.jpg");
      background-size: cover;      
      background-position: center; 
      background-repeat: repeat;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    ul#classesTabs {
  list-style: none !important;        
  padding-left: 0 !important;        
  margin: 0 auto !important;         
  display: flex !important;          
  justify-content: center !important; 
  align-items: center;
  gap: 20px;
  margin-bottom: 50px;                           
}

ul#classesTabs > li {
  list-style: none !important;
  margin: 0;
  display: inline-block !important;
}
  /* Panel principal */
  .panel {
    width: 900px;
    height: 520px;
    margin: 40px auto;
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 12px;
    text-align: center;
  }

  /* Títulos */
  .panel h1 {
    color: #9e78d4;
    margin-bottom: 25px;
    font-size: 50px;
  }
  .panel h5, 
  .panel h4, 
  .panel p {
    margin-bottom: 12px;
  }

  /* Tabs */
  .nav-tabs {
    border-bottom: 2px solid #9e78d4;
    justify-content: center;
  }
  .nav-tabs .nav-link {
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
    font-size: 18px;
    color: #555;
    border: none;
    margin: 0 8px;
  }
  .nav-tabs .nav-link.active {
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
    background: #9e78d4;
    color: #fff;
    border-radius: 8px 8px 0 0;
  }

  /* Cards */
  .card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    text-align: center;
  }

  .card-body h5 {
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
    font-size: 22px;
    color: #9e78d4;
    margin-bottom: 15px;
  }

  .card-footer {
    background: none;
    border-top: 1px solid #eee;
    text-align: center;
  }

  /* Botones */
  .btn-primary {
    font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
    background-color: #9e78d4;
    color: white;
    border: none;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    margin-top: 20px;

#classesTabs {
list-style-type: none; 
padding-left: 0; 
}
  }
  .btn-primary:hover {
    background-color: #5d4b95;
  }

  .btn-outline-danger {
    border: 2px solid #dc3545;
    border-radius: 8px;
  }
  .btn-outline-primary {
    border: 2px solid #9e78d4;
    color: #9e78d4;
    border-radius: 8px;
  }
  .btn-outline-primary:hover {
    background: #9e78d4;
    color: #fff;
  }

  /* Mensajes */
  .alert {
    border-radius: 8px;
    font-size: 16px;
    text-align: center;
  }

  /* Iconos vacíos */
  .text-center i {
    color: #9e78d4 !important;
  }
</style>

<div class="panel">
    <!-- Mensajes -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <h1>Mis Clases</h1>

    <!-- Pestañas -->
    <ul class="nav nav-tabs mb-4" id="classesTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
                Activas <span class="badge bg-success"><?php echo count($clasesActivas); ?></span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                Completadas <span class="badge bg-secondary"><?php echo count($clasesCompletadas); ?></span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab">
                Canceladas <span class="badge bg-danger"><?php echo count($clasesCanceladas); ?></span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="classesTabContent">
        <!-- Clases Activas -->
        <div class="tab-pane fade show active" id="active" role="tabpanel">
            <?php if (!empty($clasesActivas)): ?>
                <div class="row">
                    <?php foreach ($clasesActivas as $clase): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5><?php echo htmlspecialchars($clase['Materia']); ?></h5>
                                    <p><strong>Profesor:</strong> <?php echo htmlspecialchars($clase['ProfesorNombre'] . ' ' . $clase['ProfesorApellido']); ?></p>
                                    <p><strong>Inscrito desde:</strong> <?php echo date('d/m/Y', strtotime($clase['FechaIngreso'])); ?></p>
                                    <?php if ($clase['CalificacionPromedio'] > 0): ?>
                                        <p><strong>Calificación del profesor:</strong>
                                            <span class="text-warning">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($i <= floor($clase['CalificacionPromedio'])): ?>★
                                                    <?php elseif ($i - 0.5 <= $clase['CalificacionPromedio']): ?>⭐
                                                    <?php else: ?>☆
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                                (<?php echo number_format($clase['CalificacionPromedio'], 1); ?>)
                                            </span>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="clase_detalle.php?id=<?php echo $clase['IdClase_FK']; ?>" class="btn btn-primary">Ver Clase</a>
                                        <form method="POST" action="cancelar_inscripcion.php" onsubmit="return confirm('¿Estás seguro de cancelar esta inscripción?')">
                                            <input type="hidden" name="idClase" value="<?php echo $clase['IdClase_FK']; ?>">
                                            <button type="submit" class="btn btn-outline-danger">Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-book display-1"></i>
                    <h4>No tienes clases activas</h4>
                    <a href="../lista-de-profesores.php" class="btn btn-primary">Buscar Clases</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Clases Completadas -->
        <div class="tab-pane fade" id="completed" role="tabpanel">
            <?php if (!empty($clasesCompletadas)): ?>
                <div class="row">
                    <?php foreach ($clasesCompletadas as $clase): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5><?php echo htmlspecialchars($clase['Materia']); ?></h5>
                                    <p><strong>Profesor:</strong> <?php echo htmlspecialchars($clase['ProfesorNombre'] . ' ' . $clase['ProfesorApellido']); ?></p>
                                    <?php if ($clase['CalificacionPersonal']): ?>
                                        <p><strong>Tu calificación:</strong>
                                            <span class="text-warning">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($i <= $clase['CalificacionPersonal']): ?>★
                                                    <?php else: ?>☆
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </span>
                                        </p>
                                        <?php if ($clase['Comentario']): ?>
                                            <p><strong>Tu comentario:</strong> "<?php echo htmlspecialchars($clase['Comentario']); ?>"</p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-muted">No calificaste esta clase</p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer">
                                    <a href="../profesor_detalle.php?cedula=<?php echo $clase['CedulaProfesional']; ?>" class="btn btn-outline-primary">Ver Profesor</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-check-circle display-1"></i>
                    <h4>No tienes clases completadas</h4>
                </div>
            <?php endif; ?>
        </div>

        <!-- Clases Canceladas -->
        <div class="tab-pane fade" id="cancelled" role="tabpanel">
            <?php if (!empty($clasesCanceladas)): ?>
                <div class="row">
                    <?php foreach ($clasesCanceladas as $clase): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5><?php echo htmlspecialchars($clase['Materia']); ?></h5>
                                    <p><strong>Profesor:</strong> <?php echo htmlspecialchars($clase['ProfesorNombre'] . ' ' . $clase['ProfesorApellido']); ?></p>
                                    <p class="text-muted"><strong>Cancelada el:</strong> <?php echo date('d/m/Y', strtotime($clase['FechaIngreso'])); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-x-circle display-1"></i>
                    <h4>No tienes clases canceladas</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../frontend/templates/footer.php'; ?>
