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
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Archivos</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <!-- Filtros por Clase -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Filtrar por Clase</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="archivos.php" 
                           class="list-group-item list-group-item-action <?php echo !isset($class) ? 'active' : ''; ?>">
                            Todas las clases
                        </a>
                        <?php foreach ($clases as $cls): ?>
                            <a href="archivos.php?clase_id=<?php echo $cls['IdClase']; ?>" 
                               class="list-group-item list-group-item-action <?php echo isset($class) && $class['IdClase'] == $cls['IdClase'] ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($cls['Materia']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Filtros por Tipo -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Filtrar por Tipo</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="archivos.php<?php echo isset($class) ? '?clase_id=' . $class['IdClase'] : ''; ?>" 
                           class="list-group-item list-group-item-action <?php echo !isset($_GET['tipo']) ? 'active' : ''; ?>">
                            Todos los tipos
                        </a>
                        <a href="archivos.php?<?php echo isset($class) ? 'clase_id=' . $class['IdClase'] . '&' : ''; ?>tipo=pdf" 
                           class="list-group-item list-group-item-action <?php echo isset($_GET['tipo']) && $_GET['tipo'] === 'pdf' ? 'active' : ''; ?>">
                            <i class="bi bi-file-pdf text-danger"></i> Documentos PDF
                        </a>
                        <a href="archivos.php?<?php echo isset($class) ? 'clase_id=' . $class['IdClase'] . '&' : ''; ?>tipo=word" 
                           class="list-group-item list-group-item-action <?php echo isset($_GET['tipo']) && $_GET['tipo'] === 'word' ? 'active' : ''; ?>">
                            <i class="bi bi-file-word text-primary"></i> Documentos Word
                        </a>
                        <a href="archivos.php?<?php echo isset($class) ? 'clase_id=' . $class['IdClase'] . '&' : ''; ?>tipo=image" 
                           class="list-group-item list-group-item-action <?php echo isset($_GET['tipo']) && $_GET['tipo'] === 'image' ? 'active' : ''; ?>">
                            <i class="bi bi-image text-success"></i> Imágenes
                        </a>
                        <a href="archivos.php?<?php echo isset($class) ? 'clase_id=' . $class['IdClase'] . '&' : ''; ?>tipo=zip" 
                           class="list-group-item list-group-item-action <?php echo isset($_GET['tipo']) && $_GET['tipo'] === 'zip' ? 'active' : ''; ?>">
                            <i class="bi bi-file-zip text-warning"></i> Archivos ZIP
                        </a>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <?php if ($fileStats['total'] > 0): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Estadísticas</h6>
                </div>
                <div class="card-body">
                    <p><strong>Total archivos:</strong> <?php echo $fileStats['total']; ?></p>
                    <p><strong>Espacio usado:</strong> <?php echo formatFileSize($fileStats['total_size']); ?></p>
                    
                    <?php if (!empty($fileStats['por_tipo'])): ?>
                        <hr>
                        <h6>Por tipo:</h6>
                        <?php foreach ($fileStats['por_tipo'] as $tipo => $cantidad): ?>
                            <p class="mb-1 small">
                                <strong><?php echo strtoupper($tipo); ?>:</strong> <?php echo $cantidad; ?>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Lista de Archivos -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?php echo $pagina; ?></h4>
                    <span class="badge bg-secondary"><?php echo $fileStats['total']; ?> archivos</span>
                </div>
                <div class="card-body">
                    <?php if (!empty($files)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <?php if (!isset($class)): ?>
                                            <th>Clase</th>
                                        <?php endif; ?>
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
                                                    <?php if (!empty($file['Descripcion'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars($file['Descripcion']); ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <?php if (!isset($class)): ?>
                                                <td>
                                                    <a href="clase_detalle.php?id=<?php echo $file['IdClase_FK']; ?>" class="text-decoration-none">
                                                        <?php echo htmlspecialchars($file['Materia']); ?>
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo strtoupper(pathinfo($file['NombreArchivo'], PATHINFO_EXTENSION)); ?>
                                                </span>
                                            </td>
                                            <td><?php echo formatFileSize($file['Tamanio']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($file['FechaSubida'])); ?></td>
                                            <td>
                                                <a href="descargar_archivo.php?id=<?php echo $file['IdArchivo']; ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Descargar">
                                                    <i class="bi bi-download"></i> Descargar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-folder-x display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">No hay archivos disponibles</h4>
                            <p class="text-muted">
                                <?php if (isset($class)): ?>
                                    Esta clase no tiene archivos compartidos aún
                                <?php else: ?>
                                    No tienes archivos en ninguna de tus clases
                                <?php endif; ?>
                            </p>
                            <a href="clases.php" class="btn btn-primary mt-3">Ver Mis Clases</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Vista de Tarjetas (Alternativa) -->
            <?php if (!empty($files)): ?>
            <div class="mt-4">
                <h5>Vista de Tarjetas</h5>
                <div class="row">
                    <?php foreach ($files as $file): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <?php
                                    $extension = strtolower(pathinfo($file['NombreArchivo'], PATHINFO_EXTENSION));
                                    $icon = 'bi-file-earmark';
                                    $color = 'secondary';
                                    
                                    switch ($extension) {
                                        case 'pdf':
                                            $icon = 'bi-file-pdf';
                                            $color = 'danger';
                                            break;
                                        case 'doc':
                                        case 'docx':
                                            $icon = 'bi-file-word';
                                            $color = 'primary';
                                            break;
                                        case 'xls':
                                        case 'xlsx':
                                            $icon = 'bi-file-excel';
                                            $color = 'success';
                                            break;
                                        case 'ppt':
                                        case 'pptx':
                                            $icon = 'bi-file-ppt';
                                            $color = 'warning';
                                            break;
                                        case 'jpg':
                                        case 'jpeg':
                                        case 'png':
                                        case 'gif':
                                            $icon = 'bi-image';
                                            $color = 'info';
                                            break;
                                        case 'zip':
                                        case 'rar':
                                            $icon = 'bi-file-zip';
                                            $color = 'dark';
                                            break;
                                    }
                                    ?>
                                    
                                    <i class="bi <?php echo $icon; ?> display-4 text-<?php echo $color; ?>"></i>
                                    <h6 class="card-title mt-2"><?php echo htmlspecialchars($file['NombreArchivo']); ?></h6>
                                    
                                    <?php if (!isset($class)): ?>
                                        <p class="card-text small text-muted">
                                            Clase: <?php echo htmlspecialchars($file['Materia']); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <p class="card-text small">
                                        <strong>Tamaño:</strong> <?php echo formatFileSize($file['Tamanio']); ?><br>
                                        <strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($file['FechaSubida'])); ?>
                                    </p>
                                    
                                    <?php if (!empty($file['Descripcion'])): ?>
                                        <p class="card-text small"><?php echo htmlspecialchars($file['Descripcion']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer">
                                    <a href="descargar_archivo.php?id=<?php echo $file['IdArchivo']; ?>" 
                                       class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-download"></i> Descargar
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

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
