<?php require_once __DIR__ . '/../../templates/header.php'; ?>

<div class="container mt-4">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Mis Clases</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                            <a href="gestionar.php" 
                           class="list-group-item list-group-item-action <?php echo !isset($class) ? 'active' : ''; ?>">
                            Todas las clases
                        </a>
                        <?php 
                        if (empty($classes)): 
                        ?>
                            <div class="alert alert-warning">
                                No tienes clases creadas
                            </div>
                        <?php else: ?>
                            <?php foreach ($classes as $cls): ?>
                                <!-- CORREGIR: Usar ruta directa -->
                                <a href="gestionar.php?id=<?php echo $cls['IdClase']; ?>" 
                                   class="list-group-item list-group-item-action <?php echo isset($class) && $class['IdClase'] == $cls['IdClase'] ? 'active' : ''; ?>">
                                    <?php echo htmlspecialchars($cls['Materia']); ?>
                                    <span class="badge bg-primary float-end">
                                        <?php 
                                        $fileCount = 0;
                                        if (!empty($files)) {
                                            foreach ($files as $item) {
                                                if ($item['IdClase_FK'] == $cls['IdClase']) {
                                                    $fileCount++;
                                                }
                                            }
                                        }
                                        echo $fileCount;
                                        ?>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <?php if (isset($class)): ?>
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Subir nuevo archivo</h6>
                </div>
                <div class="card-body">
                    <!-- CORREGIR: Usar ruta directa -->
                    <form action="subir" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="idClase" value="<?php echo $class['IdClase']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Archivo *</label>
                            <input type="file" class="form-control" name="archivo" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif,.zip,.rar" required>
                            <div class="form-text">Máximo 20MB. Formatos: PDF, Office, imágenes, ZIP, RAR</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3" placeholder="Describe el contenido del archivo..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-upload"></i> Subir Archivo
                        </button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Lista de archivos -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?php echo $pagina; ?></h4>
                    <span class="badge bg-secondary">
                        <?php echo count($files); ?> archivo(s)
                    </span>
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
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($files as $file): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($file['NombreArchivo']); ?></strong>
                                                    <?php if (!isset($class)): ?>
                                                        <br>
                                                        <small class="text-muted">
                                                            Clase: <?php echo htmlspecialchars($file['Materia']); ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (!empty($file['Descripcion'])): ?>
                                                    <small class="text-muted file-description">
                                                        <?php echo htmlspecialchars($file['Descripcion']); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo strtoupper(pathinfo($file['NombreArchivo'], PATHINFO_EXTENSION)); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                // CORREGIR: Llamar a la función directamente
                                                echo formatFileSize($file['Tamanio']); 
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo date('d/m/Y H:i', strtotime($file['FechaSubida'])); ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <!-- CORREGIR: Usar ruta directa -->
                                                    <a href="descargar.php?id=<?php echo $file['IdArchivo']; ?>" 
                                                       class="btn btn-outline-primary" title="Descargar">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                    <button class="btn btn-outline-secondary edit-description" 
                                                            data-id="<?php echo $file['IdArchivo']; ?>"
                                                            data-descripcion="<?php echo htmlspecialchars($file['Descripcion']); ?>"
                                                            title="Editar descripción">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <!-- CORREGIR: Usar ruta directa -->
                                                    <a href="eliminar.php?id=<?php echo $file['IdArchivo']; ?>" 
                                                       class="btn btn-outline-danger" 
                                                       onclick="return confirm('¿Estás seguro de eliminar este archivo?')"
                                                       title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-folder-x display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">No hay archivos</h4>
                            <p class="text-muted">
                                <?php if (isset($class)): ?>
                                    Sube tu primer archivo usando el formulario de la izquierda
                                <?php else: ?>
                                    No hay archivos en ninguna de tus clases
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar descripción -->
<div class="modal fade" id="editDescriptionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Descripción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editDescriptionForm">
                    <input type="hidden" id="editFileId" name="idArchivo">
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" id="editDescription" name="descripcion" rows="4"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveDescription">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
// Modal de edición de descripción
document.querySelectorAll('.edit-description').forEach(button => {
    button.addEventListener('click', function() {
        const fileId = this.getAttribute('data-id');
        const descripcion = this.getAttribute('data-descripcion');
        
        document.getElementById('editFileId').value = fileId;
        document.getElementById('editDescription').value = descripcion;
        
        const modal = new bootstrap.Modal(document.getElementById('editDescriptionModal'));
        modal.show();
    });
});

// Guardar descripción
document.getElementById('saveDescription').addEventListener('click', function() {
    const formData = new FormData(document.getElementById('editDescriptionForm'));
    
    // CORREGIR: Usar ruta directa
    fetch('actualizar_descripcion.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
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

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
