<?php require_once '../frontend/templates/header.php'; ?>

<div class="container mt-4">
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

    <h1 class="mb-4">Mis Clases</h1>

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
                                    <h5 class="card-title"><?php echo htmlspecialchars($clase['Materia']); ?></h5>
                                    <p class="card-text">
                                        <strong>Profesor:</strong> <?php echo htmlspecialchars($clase['ProfesorNombre'] . ' ' . $clase['ProfesorApellido']); ?>
                                    </p>
                                    <p class="card-text">
                                        <strong>Inscrito desde:</strong> <?php echo date('d/m/Y', strtotime($clase['FechaIngreso'])); ?>
                                    </p>
                                    <?php if ($clase['CalificacionPromedio'] > 0): ?>
                                        <p class="card-text">
                                            <strong>Calificación del profesor:</strong>
                                            <span class="text-warning">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($i <= floor($clase['CalificacionPromedio'])): ?>
                                                        ★
                                                    <?php elseif ($i - 0.5 <= $clase['CalificacionPromedio']): ?>
                                                        ⭐
                                                    <?php else: ?>
                                                        ☆
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                                (<?php echo number_format($clase['CalificacionPromedio'], 1); ?>)
                                            </span>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100">
                                        <a href="clase_detalle.php?id=<?php echo $clase['IdClase_FK']; ?>" class="btn btn-primary">Ver Clase</a>
                                    </div>
                                    <form method="POST" action="cancelar_inscripcion.php" class="mt-2" onsubmit="return confirm('¿Estás seguro de cancelar esta inscripción?')">
                                        <input type="hidden" name="idClase" value="<?php echo $clase['IdClase_FK']; ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">Cancelar Inscripción</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-book display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">No tienes clases activas</h4>
                    <a href="../teachers.php" class="btn btn-primary mt-3">Buscar Clases</a>
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
                                    <h5 class="card-title"><?php echo htmlspecialchars($clase['Materia']); ?></h5>
                                    <p class="card-text">
                                        <strong>Profesor:</strong> <?php echo htmlspecialchars($clase['ProfesorNombre'] . ' ' . $clase['ProfesorApellido']); ?>
                                    </p>
                                    <?php if ($clase['CalificacionPersonal']): ?>
                                        <p class="card-text">
                                            <strong>Tu calificación:</strong>
                                            <span class="text-warning">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($i <= $clase['CalificacionPersonal']): ?>
                                                        ★
                                                    <?php else: ?>
                                                        ☆
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </span>
                                        </p>
                                        <?php if ($clase['Comentario']): ?>
                                            <p class="card-text">
                                                <strong>Tu comentario:</strong> "<?php echo htmlspecialchars($clase['Comentario']); ?>"
                                            </p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="card-text text-muted">No calificaste esta clase</p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer">
                                    <a href="../profesor_detalle.php?cedula=<?php echo $clase['CedulaProfesional']; ?>" class="btn btn-outline-primary w-100">Ver Profesor</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-check-circle display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">No tienes clases completadas</h4>
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
                                    <h5 class="card-title"><?php echo htmlspecialchars($clase['Materia']); ?></h5>
                                    <p class="card-text">
                                        <strong>Profesor:</strong> <?php echo htmlspecialchars($clase['ProfesorNombre'] . ' ' . $clase['ProfesorApellido']); ?>
                                    </p>
                                    <p class="card-text text-muted">
                                        <strong>Cancelada el:</strong> <?php echo date('d/m/Y', strtotime($clase['FechaIngreso'])); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-x-circle display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">No tienes clases canceladas</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../frontend/templates/header.php'; ?>
