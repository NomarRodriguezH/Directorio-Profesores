<?php require_once '../frontend/templates/header.php'; ?>

<!--Datos de la clase-->
<form method="POST" action="clase?id=<?php echo $_GET['id'] ?>">
    <h1>Clase: <?php echo $_GET['id'] ?></h1>
    <h3>Fecha de creación: <?php echo $class['FechaCreacion'] ?></h3>
    <label for="materia">Materia:</label>
    <input class="classData" id="materia" name="materia" type="text" readonly value="<?php echo isset($class['Materia']) ? htmlspecialchars($class['Materia']) : ''; ?>" required>
    <br>
    <label for="nivel">Nivel:</label>
    <input class="classData" id="nivel" name="nivel" type="text" readonly value="<?php echo isset($class['Nivel']) ? htmlspecialchars($class['Nivel']) : ''; ?>" required>
    <br>
    <label for="modalidad">Modalidad:</label>
    <input class="classData" id="modalidad" name="modalidad" type="text" readonly value="<?php echo isset($class['Modalidad']) ? htmlspecialchars($class['Modalidad']) : ''; ?>" required>
    <br>
    <label for="maxEstudiantes">Límite de estudiantes:</label>
    <input class="classData" id="maxEstudiantes" name="maxEstudiantes" type="text" readonly value="<?php echo isset($class['MaxEstudiantes']) ? htmlspecialchars($class['MaxEstudiantes']) : ''; ?>" required>
    <br>
    <label for="descripcion">Descripción:</label>
    <textarea class="classData" name="descripcion" id="descripcion" readonly required><?php echo isset($class['Descripcion']) ? htmlspecialchars($class['Descripcion']) : ''; ?></textarea>
    <br>
    <h3>Horario</h3>
    <?php
    $dias = [
        'lu' => 'Lunes',
        'ma' => 'Martes', 
        'mi' => 'Miércoles',
        'ju' => 'Jueves',
        'vi' => 'Viernes',
        'sa' => 'Sábado',
        'do' => 'Domingo'
    ];
    ?>
    <?php foreach ($dias as $code => $nombre): ?>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input day-checkbox" disabled 
                            id="<?php echo $code; ?>_check" data-day="<?php echo $code; ?>"
                            <?php echo (isset($class[strtoupper($code[0]).$code[1].'HI'])) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="<?php echo $code; ?>_check">
                        <?php echo $nombre; ?>
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <input type="time" class="form-control time-input" 
                        id="<?php echo $code; ?>HI" name="<?php echo $code; ?>HI" 
                        value="<?php echo isset($class[strtoupper($code[0]).$code[1].'HI']) ? htmlspecialchars($class[strtoupper($code[0]).$code[1].'HI']) : ''; ?>"
                        disabled>
            </div>
            <div class="col-md-4">
                <input type="time" class="form-control time-input" 
                        id="<?php echo $code; ?>HF" name="<?php echo $code; ?>HF" 
                        value="<?php echo isset($class[strtoupper($code[0]).$code[1].'HF']) ? htmlspecialchars($class[strtoupper($code[0]).$code[1].'HF']) : ''; ?>"
                        disabled>
            </div>
        </div>
    <?php endforeach; ?>
    <button type="button" id="editBtn" onclick="activarCambios()">Editar datos</button>
    <input type="submit" disabled id="saveBtn" value="Guardar cambios">
</form>

<!--Alumnos-->
<h2>Alumnos</h2>
<h3>Inscritos</h3>
<?php foreach($alumnos as $alumno): ?>
    <?php if ($alumno['Estado'] == 'activo'): ?>
        <h4><?php echo $alumno['id']." | ".$alumno['Correo']." | ".$alumno['Celular'] ?></h4>
        <h5><?php echo $alumno['FechaIngreso'] ?></h5>
        <p><?php echo $alumno['Nombre']." ".$alumno['ApPaterno']." ".$alumno['ApMaterno'] ?></p>
    <?php endif; ?>
<?php endforeach; ?>
<h3>Pendientes</h3>
<?php foreach($alumnos as $alumno): ?>
    <?php if ($alumno['Estado'] == 'pendiente'): ?>
    <form action="aceptar-estudiante?id=<?php echo $_GET['id'] ?>" method="POST">
        <input type="hidden" name="aluCorreo" value="<?php echo $alumno['id'] ?>">
        <h4><?php echo $alumno['id']." | ".$alumno['Correo']." | ".$alumno['Celular'] ?></h4>
        <h5><?php echo $alumno['FechaIngreso'] ?></h5>
        <p><?php echo $alumno['Nombre']." ".$alumno['ApPaterno']." ".$alumno['ApMaterno'] ?></p>
        <input type="submit" value="Aceptar en la clase">
    </form>
    <?php endif; ?>
<?php endforeach; ?>
<h3>Completados</h3>
<?php foreach($alumnos as $alumno): ?>
    <?php if ($alumno['Estado'] == 'completado'): ?>
        <h4><?php echo $alumno['id']." | ".$alumno['Correo']." | ".$alumno['Celular'] ?></h4>
        <h5><?php echo $alumno['FechaIngreso'] ?></h5>
        <p><?php echo $alumno['Nombre']." ".$alumno['ApPaterno']." ".$alumno['ApMaterno'] ?></p>
    <?php endif; ?>
<?php endforeach; ?>
<h3>Cancelados</h3>
<?php foreach($alumnos as $alumno): ?>
    <?php if ($alumno['Estado'] == 'cancelado'): ?>
        <h4><?php echo $alumno['id']." | ".$alumno['Correo']." | ".$alumno['Celular'] ?></h4>
        <h5><?php echo $alumno['FechaIngreso'] ?></h5>
        <p><?php echo $alumno['Nombre']." ".$alumno['ApPaterno']." ".$alumno['ApMaterno'] ?></p>
    <?php endif; ?>
<?php endforeach; ?>

<!--Archivos-->
<h2>Archivos</h2>

<script>
function activarCambios(){
    const dataInput = document.getElementsByClassName('classData')
    for(let i=0; i<dataInput.length; i++){
        dataInput[i].removeAttribute('readonly')
    }
    const saveBtn = document.getElementById("saveBtn")
    saveBtn.removeAttribute('disabled')
    const editBtn = document.getElementById("editBtn")
    editBtn.setAttribute('disabled', 'disabled')
    const timeInput = document.getElementsByClassName("time-input")
    for(let i=0; i<timeInput.length; i++){
        timeInput[i].removeAttribute('disabled')
    }
    const dayCheckbox = document.getElementsByClassName("day-checkbox")
    for(let i=0; i<dayCheckbox.length; i++){
        dayCheckbox[i].removeAttribute('disabled')
    }
}

</script>
<?php require_once '../frontend/templates/footer.php'; ?>