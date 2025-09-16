<?php require_once 'frontend/templates/header.php'; ?>

<div class="container mt-4">
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error_message']; ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <!-- Columna izquierda - Información del profesor -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="<?php echo !empty($teacher['FotoURL']) ? 'frontend/assets/images/' . htmlspecialchars($teacher['FotoURL']) : 'frontend/assets/images/default-teacher.jpg'; ?>" 
                         class="rounded-circle mb-3" alt="Foto del profesor" style="width: 150px; height: 150px; object-fit: cover;">
                    
                    <h2 class="card-title"><?php echo htmlspecialchars($teacher['Nombre'] . ' ' . $teacher['ApPaterno'] . ' ' . $teacher['ApMaterno']); ?></h2>
                    
                    <p class="text-muted"><?php echo htmlspecialchars($teacher['Especialidad']); ?></p>
                    
                    <?php if ($teacher['CalificacionPromedio'] > 0): ?>
                        <div class="rating mb-2">
                            <span class="text-warning" style="font-size: 1.5em;">
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
                    
                    <div class="mt-3">
                        <p><strong>Precio por hora:</strong><br>
                        $<?php echo number_format($teacher['PrecioMin'], 2); ?> - $<?php echo number_format($teacher['PrecioMax'], 2); ?></p>
                    </div>
                </div>
            </div>
            
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Información de Contacto</h5>
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
                    <h5 class="mb-0">Sobre mí</h5>
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
                    <h5 class="mb-0">Clases Disponibles</h5>
                </div>
                <div class="card-body">
                    <?php if (count($classes) > 0): ?>
                        <div class="row">
                            <?php foreach ($classes as $class): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
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
                                                <button class="btn btn-sm btn-success mt-2" data-bs-toggle="modal" data-bs-target="#inscribirModal" 
                                                        data-clase-id="<?php echo $class['IdClase']; ?>"
                                                        data-clase-name="<?php echo htmlspecialchars($class['Materia']); ?>">
                                                    Inscribirse
                                                </button>
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
            
            <!-- Reseñas y calificaciones -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Reseñas y Calificaciones</h5>
                </div>
                <div class="card-body">
                    <?php if ($ratingStats['total_reviews'] > 0): ?>
                        <!-- Estadísticas de calificaciones -->
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <h2 class="text-primary"><?php echo number_format($ratingStats['average_rating'], 1); ?></h2>
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= floor($ratingStats['average_rating'])): ?>
                                            ★
                                        <?php elseif ($i - 0.5 <= $ratingStats['average_rating']): ?>
                                            ⭐
                                        <?php else: ?>
                                            ☆
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-muted small"><?php echo $ratingStats['total_reviews']; ?> calificaciones</p>
                            </div>
                            
                            <div class="col-md-9">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <div class="row align-items-center mb-1">
                                        <div class="col-2 text-end">
                                            <span class="small"><?php echo $i; ?> estrellas</span>
                                        </div>
                                        <div class="col-7">
                                            <div class="progress" style="height: 8px;">
                                                <?php 
                                                $percentage = $ratingStats['total_reviews'] > 0 ? 
                                                    (${$i . '_stars'} / $ratingStats['total_reviews']) * 100 : 0;
                                                ?>
                                                <div class="progress-bar bg-warning" style="width: <?php echo $percentage; ?>%"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <span class="small text-muted"><?php echo ${$i . '_stars'}; ?></span>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <!-- Lista de reseñas -->
                        <h6>Reseñas recientes</h6>
                        <?php foreach ($reviews as $review): ?>
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong><?php echo htmlspecialchars($review['Nombre'] . ' ' . $review['ApPaterno']); ?></strong>
                                    <span class="text-warning">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $review['CalificacionPersonal']): ?>
                                                ★
                                            <?php else: ?>
                                                ☆
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y', strtotime($review['FechaCalificacion'])); ?>
                                </small>
                                <?php if (!empty($review['Comentario'])): ?>
                                    <p class="mt-2 mb-0"><?php echo nl2br(htmlspecialchars($review['Comentario'])); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Este profesor aún no tiene calificaciones.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal  -->
<?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'student'): ?>
<div class="modal fade" id="inscribirModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inscribirse a clase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres inscribirte a la clase: <strong id="claseNombre"></strong>?</p>
                <p>El profesor se pondrá en contacto contigo para confirmar los detalles.</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="backend/handlers/enroll_handler">
                    <input type="text" name="clase_id" id="claseId">
                    <input type="text" name="profesor_id" value="<?php echo htmlspecialchars($teacher['IdProfesor']); ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar inscripción</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inscribirModal = document.getElementById('inscribirModal');
    inscribirModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const claseId = button.getAttribute('data-clase-id');
        const claseNombre = button.getAttribute('data-clase-name');
        
        document.getElementById('claseId').value = claseId;
        document.getElementById('claseNombre').textContent = claseNombre;
    });
});
</script>
<?php endif; ?>

<style>
.rating {
    font-size: 1.2em;
}
.progress {
    background-color: #e9ecef;
}
.badge {
    font-size: 0.75em;
}
</style>

<?php require_once 'frontend/templates/footer.php'; ?>