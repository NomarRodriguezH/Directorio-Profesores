<?php require_once '../frontend/templates/header.php'; ?>

<div class="container">
    <!-- Datos del profesor -->
    <h1>Mis datos</h1>

    <h3>ID Profesor: <?php print($teacherData['IdProfesor']); ?></h3>
    <h3>Correo: <?php print($teacherData['Correo']); ?></h3>
    <h3>Nombre: <?php print($teacherData['Nombre'].' '.$teacherData['ApPaterno'].' '.$teacherData['ApMaterno']); ?></h3>
    <h3>Especialidad: <?php print($teacherData['Especialidad']); ?></h3>
    <h3>Celular: <?php print($teacherData['Celular']); ?></h3>
    <h3>Cédula profesional: <?php print($teacherData['CedulaP']); ?></h3>
    
    <h3>Descripción</h3>
    <p><?php print(nl2br(htmlspecialchars($teacherData['Descripcion']))); ?></p>
    
    <h3>Rango de precio: $<?php print($teacherData['PrecioMin'].' - $'.$teacherData['PrecioMax']); ?></h3>
    
    <h3>Dirección</h3>
    <p>
        <?php
            $direccionBase = $teacherData['Estado'].', '.$teacherData['Delegacion'].', CP '.$teacherData['CP'].', '.$teacherData['Colonia'].', '.$teacherData['Calle'].' '.$teacherData['NoExt'];
            if (!empty($teacherData['NoInt'])) {
                $direccionBase .= ', Int. '.$teacherData['NoInt'];
            }
            print htmlspecialchars($direccionBase);
        ?>
    </p>

    <a href="editar-datos" class="btn2">Editar mis datos</a>
    <hr>

    <!-- Clases -->
    <h1>Mis clases</h1>
    <a href="crear-clase.php" class="btn2">Agregar una clase</a>

    <?php if (empty($clases)): ?>
        <p style="text-align: center; margin-top: 20px;">No tienes clases registradas.</p>
    <?php else: ?>
        <div class="benefits">
            <?php foreach($clases as $clase): ?>
                <div class="benefit class-card">
                    <h2><?php print($clase['IdClase'].'. '.$clase['Materia']); ?></h2>
                    <h3>Fecha de creación: <?php print($clase['FechaCreacion']); ?></h3>
                    <h3>Nivel: <?php print($clase['Nivel']); ?></h3>
                    <h3>Modalidad: <?php print($clase['Modalidad']); ?></h3>
                    <h3>Estudiantes máximos: <?php print($clase['MaxEstudiantes']); ?></h3>
                    
                    <h3>Descripción:</h3>
                    <p><?php print(nl2br(htmlspecialchars($clase['Descripcion']))); ?></p>
                    
                    <h3>Horario:</h3>
                    <?php
                    $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
                    foreach ($dias as $dia) {
                        if (!empty($clase[$dia . 'HI'])) {
                            echo "<p>{$dia}: {$clase[$dia.'HI']} - {$clase[$dia.'HF']}</p>";
                        }
                    }
                    ?>
                    <a href="clase.php?id=<?php echo $clase['IdClase']; ?>" class="btn2" style="margin-top: 10px;">Administrar clase</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>



<?php require_once '../frontend/templates/footer.php'; ?>