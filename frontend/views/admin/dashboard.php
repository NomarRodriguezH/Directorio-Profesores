<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #fff;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .col-12 {
            flex: 0 0 100%;
        }

        .col-md-6 {
            flex: 0 0 48%;
        }

        .col-md-3 {
            flex: 0 0 23%;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            background-color: #e0e0e0;
            padding: 0.75rem 1rem;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            margin: 0;
        }

        .card-text {
            font-size: 0.95rem;
            color: #555;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .btn-close {
            float: right;
            border: none;
            background: none;
            font-size: 1rem;
            cursor: pointer;
        }

        .badge {
            display: inline-block;
            padding: 0.25em 0.6em;
            font-size: 0.75em;
            border-radius: 0.25rem;
            font-weight: bold;
        }

        .bg-success {
            background-color: #28a745;
            color: white;
        }

        .bg-danger {
            background-color: #dc3545;
            color: white;
        }

        .bg-primary {
            background-color: #007bff;
            color: white;
        }

        .bg-info {
            background-color: #17a2b8;
            color: white;
        }

        .bg-warning {
            background-color: #ffc107;
            color: black;
        }

        .bg-secondary {
            background-color: #6c757d;
            color: white;
        }

        .bg-light {
            background-color: #f8f9fa;
            color: #212529;
        }

        .btn {
            padding: 0.4rem 0.75rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 0.5rem;
            text-align: left;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #6c757d;
        }

        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }
        .mb-0 { margin-bottom: 0; }
        .mb-3 { margin-bottom: 1rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .py-4 { padding: 2rem 0; }

        .list-unstyled {
            list-style: none;
            padding-left: 0;
        }

        @media (max-width: 768px) {
            .col-md-6, .col-md-3 {
                flex: 0 0 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Mensajes -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none';">×</button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none';">×</button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary">
                <div class="card-body">
                    <h1 class="card-title">Panel de Administración</h1>
                    <p class="card-text">Gestión de estudiantes y profesores del directorio</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h3 class="card-title mt-2"><?php echo $stats['total_estudiantes']; ?></h3>
                    <p class="card-text">Total Estudiantes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h3 class="card-title mt-2"><?php echo $stats['estudiantes_activos']; ?></h3>
                    <p class="card-text">Estudiantes Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <h3 class="card-title mt-2"><?php echo $stats['total_profesores']; ?></h3>
                    <p class="card-text">Total Profesores</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <h3 class="card-title mt-2"><?php echo $stats['profesores_activos']; ?></h3>
                    <p class="card-text">Profesores Activos</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <!-- Lista de Estudiantes -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0">Estudiantes Registrados</h5>
                <span class="badge bg-light">Total: <?php echo count($estudiantes); ?></span>
            </div>
            <div class="card-body">
                <?php if (!empty($estudiantes)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($estudiantes as $estudiante): ?>
                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($estudiante['Nombre'] . ' ' . $estudiante['ApPaterno'] . ' ' . $estudiante['ApMaterno']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($estudiante['Correo']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $estudiante['Activo'] ? 'success' : 'danger'; ?>">
                                                <?php echo $estudiante['Activo'] ? 'Activo' : 'Inactivo'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="cambiarEstatus" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $estudiante['id']; ?>">
                                                <input type="hidden" name="user_type" value="student">
                                                <input type="hidden" name="new_status" value="<?php echo $estudiante['Activo'] ? '0' : '1'; ?>">
                                                <button type="submit" class="btn btn-sm btn-<?php echo $estudiante['Activo'] ? 'warning' : 'success'; ?>">
                                                    <?php echo $estudiante['Activo'] ? 'Desactivar' : 'Activar'; ?>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mt-3">No hay estudiantes registrados</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Lista de Profesores -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="mb-0">Profesores Registrados</h5>
                <span class="badge bg-light">Total: <?php echo count($profesores); ?></span>
            </div>
            <div class="card-body">
                <?php if (!empty($profesores)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Especialidad</th>
                                    <th>Estado</th>
                                    <th>Cédula Profesional</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($profesores as $profesor): ?>
                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($profesor['Nombre'] . ' ' . $profesor['ApPaterno'] . ' ' . $profesor['ApMaterno']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($profesor['Especialidad']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $profesor['Activo'] ? 'success' : 'danger'; ?>">
                                                <?php echo $profesor['Activo'] ? 'Activo' : 'Inactivo'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php echo $profesor['CedulaP'] ?? 'Sin cédula'; ?>
                                        </td>
                                        <td>
                                            <form method="POST" action="cambiarEstatus" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $profesor['IdProfesor']; ?>">
                                                <input type="hidden" name="user_type" value="teacher">
                                                <input type="hidden" name="new_status" value="<?php echo $profesor['Activo'] ? '0' : '1'; ?>">
                                                <button type="submit" class="btn btn-sm btn-<?php echo $profesor['Activo'] ? 'warning' : 'success'; ?>">
                                                    <?php echo $profesor['Activo'] ? 'Desactivar' : 'Activar'; ?>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mt-3">No hay profesores registrados</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


</div>

</body>
</html>
