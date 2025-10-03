<?php require_once '../frontend/templates/header.php'; ?>

<style>

    body {
      margin: 0;
      font-family: 'Jersey 20', Bodoni MT, Arial, sans-serif;
      background-image: url("https://instagram.fmex33-1.fna.fbcdn.net/v/t39.30808-6/469581462_17858755593311960_8195469585033840512_n.jpg?stp=dst-jpg_e35_tt6&efg=eyJ2ZW5jb2RlX3RhZyI6InRocmVhZHMuQ0FST1VTRUxfSVRFTS5pbWFnZV91cmxnZW4uMTQ0MHgxODAwLnNkci5mMzA4MDguZGVmYXVsdF9pbWFnZS5jMiJ9&_nc_ht=instagram.fmex33-1.fna.fbcdn.net&_nc_cat=108&_nc_oc=Q6cZ2QFdpZJlpQMu0HBeJo-vU09R6t93IarTUjPs9i4aEIc8oAGx0iQ3VGIM0qtaKrwbxug3aM6TRzdsx-yEgKc1Zl9q&_nc_ohc=IZcomAOr-40Q7kNvwFzx5pv&_nc_gid=TJIoz0ayBCW_vu27pIiqsQ&edm=AKr904kAAAAA&ccb=7-5&ig_cache_key=MzQ3MjcwMzA5NzE1MzY5NTkxOA%3D%3D.3-ccb7-5&oh=00_AfewALLbGsh8sTvT9GiVQByQJ-BZVPa7T7P5fZV6Fdk18g&oe=68E4EBEB&_nc_sid=23467f");
      background-size: cover;      
      background-position: center; 
      background-repeat: repeat;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    /* Contenedor general */
    .page-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        text-align: center;
    }

    .page-container h1 {
        font-family: 'Jersey 20', sans-serif;
        font-size: 50px;
        color: #9e78d4;

    }
    .page-container h2 {
        font-family: 'Jersey 20', sans-serif;
        font-size: 30px;
        color: #9e78d4;

    }
    .page-container h3 {
        font-family: 'Jersey 20', sans-serif;
        font-size: 25px;
        color: #151522;

    }
    .page-container h4 {
        font-family: 'Jersey 20', sans-serif;
        font-size: 30px;
        color: #9e78d4;

    }


    .page-container h5 {
        font-family: 'Jersey 20', sans-serif;
        margin-bottom: 15px;
        color: #333;
    }

    .page-container p {
        font-size: 15px;
        color: #555;
    }

    /* Inputs y textarea */
    .classData, .form-control, textarea {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        background: #fafafa;
        text-align: left;
        font-size: 13px;
    }

    textarea {
        min-height: 100px;
        resize: none;
    }

    /* Botones */
    button, input[type="submit"] {
        background: #9e78d4;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        margin: 8px;
        cursor: pointer;
        transition: 0.3s ease;
        font-weight: bold;
    }

    button:hover, input[type="submit"]:hover {
        background: #7a5fb0;
    }

    button:disabled, input:disabled {
        background: #ccc !important;
        cursor: not-allowed;
    }

    /* Secciones separadas */
    .section-box {

        margin-top: 30px;
        padding: 20px;
        background: #fdfdfd;
        border-radius: 10px;
        border: 1px solid #eee;
        text-align: center;
    }

    /* Horario */
    .row {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 12px;
    }
    .row .col-md-3, 
    .row .col-md-4 {
        margin: 5px;
    }

    /* Estilo alumnos */
    .alumno-card {
        background: #f8f8f8;
        border: 1px solid #ddd;
        padding: 15px;
        margin: 12px 0;
        border-radius: 8px;
    }
    .Des    {
        font-family: 'Jersey 20', sans-serif;
        font-size: 25px;

        color: #9e78d4;
        text-align: left;
    }

</style>

<div class="page-container">
    <!--Datos de la clase-->
    <form method="POST" action="clase?id=<?php echo $_GET['id'] ?>">
        <h1>Clase: <?php echo $_GET['id'] ?></h1>
        <h3>Fecha de creación: <?php echo $class['FechaCreacion'] ?></h3>

        <label for="materia" class="Des">Materia:</label>
        <input class="classData" id="materia" name="materia" type="text" readonly 
               value="<?php echo isset($class['Materia']) ? htmlspecialchars($class['Materia']) : ''; ?>" required>

        <label for="nivel" class="Des">Nivel:</label>
        <input class="classData" id="nivel" name="nivel" type="text" readonly 
               value="<?php echo isset($class['Nivel']) ? htmlspecialchars($class['Nivel']) : ''; ?>" required>

        <label for="modalidad" class="Des">Modalidad:</label>
        <input class="classData" id="modalidad" name="modalidad" type="text" readonly 
               value="<?php echo isset($class['Modalidad']) ? htmlspecialchars($class['Modalidad']) : ''; ?>" required>

        <label for="maxEstudiantes" class="Des">Límite de estudiantes:</label>
        <input class="classData" id="maxEstudiantes" name="maxEstudiantes" type="text" readonly 
               value="<?php echo isset($class['MaxEstudiantes']) ? htmlspecialchars($class['MaxEstudiantes']) : ''; ?>" required>

        <label for="descripcion" class="Des">Descripción:</label>
        <textarea class="classData" name="descripcion" id="descripcion" readonly required>
            <?php echo isset($class['Descripcion']) ? htmlspecialchars($class['Descripcion']) : ''; ?>
        </textarea>

        <div class="section-box">
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
                <div class="row">
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
        </div>

        <button type="button" id="editBtn" onclick="activarCambios()">Editar datos</button>
        <input type="submit" disabled id="saveBtn" value="Guardar cambios">
    </form>

    <!--Alumnos-->
    <div class="section-box">
        <h2>Alumnos</h2>
        <h3>Inscritos</h3>
        <?php foreach($alumnos as $alumno): ?>
            <?php if ($alumno['Estado'] == 'activo'): ?>
                <div class="alumno-card">
                    <h4><?php echo $alumno['id']." | ".$alumno['Correo']." | ".$alumno['Celular'] ?></h4>
                    <h5><?php echo $alumno['FechaIngreso'] ?></h5>
                    <p><?php echo $alumno['Nombre']." ".$alumno['ApPaterno']." ".$alumno['ApMaterno'] ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <h3>Pendientes</h3>
        <?php foreach($alumnos as $alumno): ?>
            <?php if ($alumno['Estado'] == 'pendiente'): ?>
                <form action="aceptar-estudiante?id=<?php echo $_GET['id'] ?>" method="POST" class="alumno-card">
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
                <div class="alumno-card">
                    <h4><?php echo $alumno['id']." | ".$alumno['Correo']." | ".$alumno['Celular'] ?></h4>
                    <h5><?php echo $alumno['FechaIngreso'] ?></h5>
                    <p><?php echo $alumno['Nombre']." ".$alumno['ApPaterno']." ".$alumno['ApMaterno'] ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <h3>Cancelados</h3>
        <?php foreach($alumnos as $alumno): ?>
            <?php if ($alumno['Estado'] == 'cancelado'): ?>
                <div class="alumno-card">
                    <h4><?php echo $alumno['id']." | ".$alumno['Correo']." | ".$alumno['Celular'] ?></h4>
                    <h5><?php echo $alumno['FechaIngreso'] ?></h5>
                    <p><?php echo $alumno['Nombre']." ".$alumno['ApPaterno']." ".$alumno['ApMaterno'] ?></p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!--Archivos-->
    <div class="section-box">
        <h2>Archivos</h2>
    </div>
</div>

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
