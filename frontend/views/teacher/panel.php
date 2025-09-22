<?php require_once '../frontend/templates/header.php'; ?>

<form method="GET" action="panel">
    <!-- Datos del profesor -->
    <h1>Mis datos</h1>
    <h3>ID Profesor: <?php print($teacherData['IdProfesor']); ?></h3>
    <h3>Correo: <?php print($teacherData['Correo']); ?></h3>
    <h3>Nombre: <?php print($teacherData['Nombre'].' '.$teacherData['ApPaterno'].' '.$teacherData['ApMaterno'].' '); ?></h3>
    <h3>Especialidad: <?php print($teacherData['Especialidad']); ?></h3>
    <h3>Celular: <?php print($teacherData['Celular']); ?></h3>
    <h3>Cédula profesional: <?php print($teacherData['CedulaP']); ?></h3>
    <h3>Descripción</h3>
    <p><?php print($teacherData['Descripcion']); ?></p>
    <h3>Rango de precio: $<?php print($teacherData['PrecioMin'].' - $'.$teacherData['PrecioMax']); ?></h3>
    <h3>Dirección</h3>
    <p>
        <?php
            $direccionBase = $teacherData['Estado'].', '.$teacherData['Delegacion'].', '.$teacherData['CP'].', '.$teacherData['Colonia'].', '.$teacherData['Calle'].' '.$teacherData['NoExt'];
            (!empty($teacherData['NoInt'])) ? print($direccionBase.', '.$teacherData['NoInt']) : print($direccionBase);
        ?>
    </p>
    <hr>

    <!-- Clases -->
    <h1>Mis clases</h1>
    <?php foreach($clases as $clase): ?>
        <div class="class-card">
            <h2><?php print($clase['IdClase'].'. '.$clase['Materia']); ?></h2>
            <h3>Fecha de creación: <?php print($clase['FechaCreacion']); ?></h3>
            <h3>Nivel: <?php print($clase['Nivel']); ?></h3>
            <h3>Modalidad: <?php print($clase['Modalidad']); ?></h3>
            <h3>Estudiantes máximos: <?php print($clase['MaxEstudiantes']); ?></h3>
            <h3>Descripcion:</h3>
            <p><?php print($clase['Descripcion']); ?></p>
            <h3>Horario:</h3>
            <?php foreach($horarios as $dia): ?>
                <p>
                    <?php (!empty($clase[$dia.'HI'])) ? print($dia.': '.$clase[$dia.'HI'].' - '.$clase[$dia.'HF']) : '' ?>
                </p>
            <?php endforeach ?>
        </div>
    <?php endforeach; ?>
</form>

<style>
    .class-card {
        transition: transform 0.2s;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding-left: 10px;
        padding-right: 10px;
    }
</style>

<?php require_once '../frontend/templates/footer.php'; ?>