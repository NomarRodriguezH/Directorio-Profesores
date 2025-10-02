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

    <!-- Navegación -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="clases.php">Mis Clases</a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($class['Materia']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Información Principal -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="mb-0"><?php echo htmlspecialchars($class['Materia']); ?></h2>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Profesor:</strong> 
                                    <?php echo htmlspecialchars($teacher['Nombre'] . ' ' . $teacher['ApPaterno'] . ' ' . $teacher['ApMaterno']); ?>
                                </a>
                            </p>
                            <p><strong>Especialidad:</strong> <?php echo htmlspecialchars($teacher['Especialidad']); ?></p>
                            <p><strong>Nivel:</strong> <?php echo htmlspecialchars($class['Nivel']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Modalidad:</strong> 
                                <span class="badge bg-primary"><?php echo htmlspecialchars($class['Modalidad']); ?></span>
                            </p>
                            <p><strong>Estado:</strong> 
                                <span class="badge bg-<?php echo $enrollment['Estado'] === 'activo' ? 'success' : 'secondary'; ?>">
                                    <?php echo ucfirst($enrollment['Estado']); ?>
                                </span>
                            </p>
                            <p><strong>Inscrito desde:</strong> <?php echo date('d/m/Y', strtotime($enrollment['FechaIngreso'])); ?></p>
                        </div>
                    </div>

                    <?php if (!empty($class['Descripcion'])): ?>
                        <div class="mb-3">
                            <h5>Descripción de la Clase</h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($class['Descripcion'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Horarios -->
                    <div class="mb-3">
                        <h5>Horarios</h5>
                        <?php
                        $dias = ['Lu' => 'Lunes', 'Ma' => 'Martes', 'Mi' => 'Miércoles', 'Ju' => 'Jueves', 'Vi' => 'Viernes', 'Sa' => 'Sábado', 'Do' => 'Domingo'];
                        $horarios = [];
                        
                        foreach ($dias as $diaCode => $diaNombre) {
                            $horaInicio = $class[$diaCode . 'HI'];
                            $horaFin = $class[$diaCode . 'HF'];
                            
                            if (!empty($horaInicio) && !empty($horaFin)) {
                                $horarios[] = $diaNombre . ': ' . substr($horaInicio, 0, 5) . ' - ' . substr($horaFin, 0, 5);
                            }
                        }
                        
                        if (!empty($horarios)): ?>
                            <ul class="list-unstyled">
                                <?php foreach ($horarios as $horario): ?>
                                    <li><i class="bi bi-clock text-primary"></i> <?php echo $horario; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Horarios flexibles</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Material de la Clase</h5>
                    <span class="badge bg-secondary"><?php echo count($files); ?> archivos</span>
                </div>
                <div class="card-body">
                    <?php if (!empty($files)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Tamaño</th>
                                        <th>Fecha</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($files as $file): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($file['NombreArchivo']); ?></strong>
                                                <?php if (!empty($file['Descripcion'])): ?>
                                                    <br><small class="text-muted"><?php echo htmlspecialchars($file['Descripcion']); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo strtoupper(pathinfo($file['NombreArchivo'], PATHINFO_EXTENSION)); ?>
                                                </span>
                                            </td>
                                            <td><?php echo formatFileSize($file['Tamanio']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($file['FechaSubida'])); ?></td>
                                            <td>
                                                <a href="descargar_archivo.php?id=<?php echo $file['IdArchivo']; ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Descargar">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-folder-x display-1 text-muted"></i>
                            <p class="text-muted mt-3">No hay archivos disponibles para esta clase</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Información del Profesor</h5>
                </div>
                <div class="card-body text-center">
                    <img src="<?php echo !empty($teacher['FotoURL']) ? '../frontend/assets/images/' . htmlspecialchars($teacher['FotoURL']) : '../frontend/assets/images/default-teacher.jpg'; ?>" 
                         class="rounded-circle mb-3" alt="Foto del profesor" style="width: 100px; height: 100px; object-fit: cover;">
                    
                    <h6><?php echo htmlspecialchars($teacher['Nombre'] . ' ' . $teacher['ApPaterno']); ?></h6>
                    <p class="text-muted"><?php echo htmlspecialchars($teacher['Especialidad']); ?></p>
                    
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
                            <span class="d-block small">
                                <?php echo number_format($teacher['CalificacionPromedio'], 1); ?> · <?php echo $teacher['TotalCalificaciones']; ?> calificaciones
                            </span>
                        </div>
                    <?php else: ?>
                        <span class="text-muted small">Sin calificaciones aún</span>
                    <?php endif; ?>
                    
                   
                </div>
            </div>

            <!-- Calificación -->
            <?php if ($enrollment['Estado'] === 'activo' || ($enrollment['Estado'] === 'completado' && !$enrollment['CalificacionPersonal'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Calificar Clase</h5>
                </div>
                <div class="card-body">
                    <?php if ($enrollment['CalificacionPersonal']): ?>
                        <div class="text-center">
                            <p class="text-success"><strong>Ya calificaste esta clase</strong></p>
                            <div class="rating mb-2">
                                <span class="text-warning fs-4">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $enrollment['CalificacionPersonal']): ?>
                                            ★
                                        <?php else: ?>
                                            ☆
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </span>
                            </div>
                            <?php if ($enrollment['Comentario']): ?>
                                <p class="text-muted">"<?php echo htmlspecialchars($enrollment['Comentario']); ?>"</p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <form id="ratingForm">
                            <input type="hidden" name="idClase" value="<?php echo $class['IdClase']; ?>">
                            
                            <div class="mb-3 text-center">
                                <label class="form-label">Calificación</label>
                                <div class="rating-stars mb-3">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star" data-rating="<?php echo $i; ?>" style="cursor: pointer; font-size: 2rem;">
                                            ☆
                                        </span>
                                    <?php endfor; ?>
                                </div>
                                <input type="hidden" name="calificacion" id="calificacion" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Comentario (opcional)</label>
                                <textarea class="form-control" name="comentario" rows="3" placeholder="Comparte tu experiencia..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Enviar Calificación</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Acciones</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="archivos.php?clase_id=<?php echo $class['IdClase']; ?>" class="btn btn-outline-primary">
                            <i class="bi bi-folder"></i> Ver Archivos
                        </a>
                        
                        <?php if ($enrollment['Estado'] === 'activo'): ?>
                            <form method="POST" action="cancelar_inscripcion.php" onsubmit="return confirm('¿Estás seguro de cancelar esta inscripción?')">
                                <input type="hidden" name="idClase" value="<?php echo $class['IdClase']; ?>">
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-x-circle"></i> Cancelar Inscripción
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <a href="clases.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Volver a Mis Clases
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Sistema de calificación con estrellas
document.querySelectorAll('.star').forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.getAttribute('data-rating');
        document.getElementById('calificacion').value = rating;
        
        document.querySelectorAll('.star').forEach(s => {
            const starRating = s.getAttribute('data-rating');
            s.textContent = starRating <= rating ? '★' : '☆';
        });
    });
});

// Envío del formulario de calificación
document.getElementById('ratingForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    if (!formData.get('calificacion')) {
        alert('Por favor selecciona una calificación');
        return;
    }
    
    fetch('calificar_clase', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Calificación enviada correctamente');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error de conexión');
    });
});
</script>

<?php 
// Función helper para formatear tamaño de archivo
function formatFileSize($bytes) {
    if ($bytes == 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return number_format($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}
?>

<?php require_once '../frontend/templates/header.php'; ?>
