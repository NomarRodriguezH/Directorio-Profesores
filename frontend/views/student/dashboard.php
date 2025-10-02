<?php require_once __DIR__.'/../../templates/header.php'; ?>

<div class="dashboard-container mt-4">
    <!-- Bienvenida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card text-white text-center">
                <div class="card-body">
                    <h1 class="card-title">¡Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h1>
                    <p class="card-text">Bienvenido a tu dashboard de estudiante</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4 text-center">
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="bi bi-book display-4 text-primary"></i>
                    <h3 class="card-title mt-2"><?php echo $stats['total_clases']; ?></h3>
                    <p class="card-text">Clases Inscritas</p>
                </div>
            </div>
        </div>



        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="bi bi-check-circle display-4 text-success"></i>
                    <h3 class="card-title mt-2"><?php echo $stats['clases_activas']; ?></h3>
                    <p class="card-text">Clases Activas</p>
                </div>
            </div>
        </div>


        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="bi bi-people display-4 text-info"></i>
                    <h3 class="card-title mt-2"><?php echo $stats['profesores']; ?></h3>
                    <p class="card-text">Profesores</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="bi bi-clock display-4 text-warning"></i>
                    <h5 class="card-title mt-2">Próxima Clase</h5>
                    <p class="card-text small"><?php echo $stats['proximo_horario']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Clases y Próximas -->
    <div class="row text-center">
        <div class="col-md-6 mb-4">
            <div class="card content-card">
                <div class="card-header">
                    <h5 class="mb-0">Mis Clases</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($enrollments)): ?>
                        <div class="list-group text-start">
                            <?php foreach (array_slice($enrollments, 0, 5) as $enrollment): ?>
                                <div class="list-group-item">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($enrollment['Materia']); ?></h6>
                                    <span class="badge bg-<?php echo $enrollment['Estado'] === 'activo' ? 'success' : 'secondary'; ?>">
                                        <?php echo ucfirst($enrollment['Estado']); ?>
                                    </span>
                                    <p class="mb-1">
                                        <small>Profesor: <?php echo htmlspecialchars($enrollment['ProfesorNombre'] . ' ' . $enrollment['ProfesorApellido']); ?></small>
                                    </p>
                                    <small class="text-muted">
                                        Inscrito el: <?php echo date('d/m/Y', strtotime($enrollment['FechaIngreso'])); ?>
                                    </small>
                                    <div class="mt-2">
                                        <a href="../ver-profesor.php?cedula=<?php echo $enrollment['idProfesor_FK']; ?>" 
                                           class="btn btn-sm btn-outline-primary">Ver Profesor</a>
                                        <?php if ($enrollment['Estado'] === 'activo'): ?>
                                            <a href="clase.php?id=<?php echo $enrollment['IdClase_FK']; ?>" 
                                               class="btn btn-sm btn-outline-success">Ir a Clase</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-book display-1 text-muted"></i>
                            <p class="text-muted mt-3">No estás inscrito en ninguna clase</p>
                            <a href="lista-de-profesores.php" class="btn btn-primary">Buscar Clases</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card content-card">
                <div class="card-header">
                    <h5 class="mb-0">Próximas Clases</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($upcomingClasses)): ?>
                        <div class="list-group text-start">
                            <?php foreach ($upcomingClasses as $upcoming): ?>
                                <div class="list-group-item">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($upcoming['clase']['Materia']); ?></h6>
                                    <small class="text-primary">
                                        <?php echo date('d/m', strtotime($upcoming['proxima_sesion']['fecha'])); ?>
                                    </small>
                                    <p class="mb-1">
                                        <i class="bi bi-clock"></i>
                                        <?php echo substr($upcoming['proxima_sesion']['hora_inicio'], 0, 5); ?> - 
                                        <?php echo substr($upcoming['proxima_sesion']['hora_fin'], 0, 5); ?>
                                    </p>
                                    <small class="text-muted">
                                        Profesor: <?php echo htmlspecialchars($upcoming['clase']['ProfesorNombre'] . ' ' . $upcoming['clase']['ProfesorApellido']); ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-calendar display-1 text-muted"></i>
                            <p class="text-muted mt-3">No hay clases programadas</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="row text-center">
        <div class="col-12">
            <div class="card content-card">
                <div class="card-header">
                    <h5 class="mb-0">Actividad Reciente</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentActivity)): ?>
                        <div class="list-group text-start">
                            <?php foreach ($recentActivity as $activity): ?>
                                <div class="list-group-item">
                                    <i class="<?php echo $activity['icono']; ?> text-primary me-3 fs-4"></i>
                                    <p class="mb-1"><?php echo htmlspecialchars($activity['mensaje']); ?></p>
                                    <small class="text-muted">
                                        Clase: <?php echo htmlspecialchars($activity['clase']); ?> • 
                                        <?php echo date('d/m/Y H:i', strtotime($activity['fecha'])); ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-activity display-1 text-muted"></i>
                            <p class="text-muted mt-3">No hay actividad reciente</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row mt-4 text-center">
        <div class="col-12">
            <div class="card content-card">
                <div class="card-header">
                    <h5 class="mb-0">Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="lista-de-profesores.php" class="btn btn-primary">
                            <i class="bi bi-search"></i> Buscar Profesores
                        </a>
                        <a href="alumno/clases.php" class="btn btn-success">
                            <i class="bi bi-list-ul"></i> Mis Clases
                        </a>
                        <a href="alumno/archivos.php" class="btn btn-info">
                            <i class="bi bi-folder"></i> Archivos
                        </a>
                        <a href="perfil.php" class="btn btn-secondary">
                            <i class="bi bi-person"></i> Mi Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Jersey+20&display=swap');

body {
    font-family: 'Jersey 20', sans-serif;
    text-align: center;
    background: url("https://wallpapercat.com/w/full/f/6/f/1193592-3840x2160-desktop-4k-gengar-background-image.jpg") no-repeat center center fixed;
    background-size: cover;
    color: #151522;
}

.dashboard-container {
    max-width: 1000px;
    margin: auto;

}

.card {
    border-radius: 15px;
    background: #fff;
    height: fit-content;
    font-size: 20px;
    margin-top: 0px;
    margin-bottom: 15px;

}
.card:hover {
    transform: translateY(-3px);
}


.card-header {
    background-color: #684E83;
    color: white;
    font-size: 35px;
    font-weight: bold;
    border-radius: 15px 15px 0 0 !important;
    text-align: center;


}

.welcome-card {
    background: #524269;
    color: white;
    border: none;
    border-radius: 15px;
    height: 110px;
}

.stat-card {
    background: white;
    border: none;
    text-align: center;

}

.list-group-item {
    border: none;
    border-bottom: 1px solid #eee;
    padding: 15px;

}
.list-group-item:last-child {
    border-bottom: none;
}

.btn {
    font-family: "Jersey 20", sans-serif; 
    background-color: #9e78d4;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-size: 20px;
    font-weight: normal;
    color: #fff;
    margin-right: 15px;
    margin-bottom: 15px;
    text-decoration: none;
}

 .btn-primary:hover {
    background-color: #7b5bb0;
  }

</style>

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
