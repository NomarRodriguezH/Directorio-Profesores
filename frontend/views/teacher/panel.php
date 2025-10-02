<?php require_once '../frontend/templates/header.php'; ?>

<div class="teacher-container">
    <!-- Datos del profesor -->
    <div class="profile-card">
        <h1 class="title">Mis datos personales</h1>

        <div class="info-block">

            <p><span class="Caracteristicas">ID Profesor:</span> <span class="variable"> <?php print($teacherData['IdProfesor']); ?> </span></p>

            <p><span class="Caracteristicas">Correo: </span><span class="variable"> <?php print($teacherData['Correo']); ?></span></p>

            <p><span class="Caracteristicas">Nombre:</span><span class="variable"> <?php print($teacherData['Nombre'].' '.$teacherData['ApPaterno'].' '.$teacherData['ApMaterno']); ?>
            </span></p>

            <p><span class="Caracteristicas">Especialidad:</span> <span class="variable"> <?php print($teacherData['Especialidad']); ?> </span></p>

            <p><span class="Caracteristicas">Celular:</span> <span class="variable"> <?php print($teacherData['Celular']); ?> </span></p>

            <p><span class="Caracteristicas">Cédula profesional: </span><span class="variable"> <?php print($teacherData['CedulaP']); ?> </span></p>

        </div>
        <p> </p>
        <div class="info-block">
            <p> </p>
            <span class="Caracteristicas"> Descripción:</span>
            <p><?php print(nl2br(htmlspecialchars($teacherData['Descripcion']))); ?></p>
        </div>

        <div class="info-block">
            <span class="Caracteristicas">Rango de precio:</span>
            <p>$<?php print($teacherData['PrecioMin'].' - $'.$teacherData['PrecioMax']); ?></p>
        </div>

        <div class="info-block">
            <span class="Caracteristicas">Dirección</span>
            <p>
                <?php
                    $direccionBase = $teacherData['Estado'].', '.$teacherData['Delegacion'].', CP '.$teacherData['CP'].', '.$teacherData['Colonia'].', '.$teacherData['Calle'].' '.$teacherData['NoExt'];
                    if (!empty($teacherData['NoInt'])) {
                        $direccionBase .= ', Int. '.$teacherData['NoInt'];
                    }
                    print htmlspecialchars($direccionBase);
                ?>
            </p>
        </div>

        <a href="editar-datos" class="btn2">✏️ Editar mis datos</a>
    </div>

    <hr class="divider">

    <!-- Clases -->
    <div class="profile-card">
        <h1 class="title">Mis clases</h1>
        <a href="crear-clase.php" class="btn2">➕ Agregar una clase</a>

        <?php if (empty($clases)): ?>
            <p class="no-classes">No tienes clases registradas.</p>
        <?php else: ?>
            <div class="class-list">
                <?php foreach($clases as $clase): ?>
                    <div class="class-card">
                        <h2><?php print($clase['IdClase'].'. '.$clase['Materia']); ?></h2>
                        <h3><strong>Fecha de creación:</strong> <?php print($clase['FechaCreacion']); ?></h3>
                        <h3><strong>Nivel:</strong> <?php print($clase['Nivel']); ?></h3>
                        <h3><strong>Modalidad:</strong> <?php print($clase['Modalidad']); ?></h3>
                        <h3><strong>Estudiantes máximos:</strong> <?php print($clase['MaxEstudiantes']); ?></h3>
                        
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
                        <a href="clase.php?id=<?php echo $clase['IdClase']; ?>" class="btn2">📘 Administrar clase</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>


<style>
/* Fondo general */
body {
    background: url('https://pokewalls.wordpress.com/wp-content/uploads/2011/01/94gengar1920x1200.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Jersey 20', sans-serif;
    color: #222;
}

/* Contenedor principal */
.teacher-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px;
}

/* Tarjeta de perfil */
.profile-card {
    background: #fff;
    padding: 25px;
    margin-bottom: 30px;
    border-radius: 15px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.15);
}

/* Títulos */
.title {
    text-align: center;
    font-size: 50px;
    margin-bottom: 20px;
    color: #9e78d4;
}

.Caracteristicas {
    color: #895F9E;
    font-size: 30px;
    font-weight: bold;
}

.variable {
    color: black;
    font-size: 25px;
    font-weight: normal;
}

.info-block p {
    font-size: 20px;
    margin-bottom: 15px;
}

/* Botones */
.btn2 {
    display: inline-block;
    padding: 10px 20px;
    background: #9e78d4;
    color: #fff;
    border-radius: 8px;
    font-size: 20px;
    text-decoration: none;
    margin-top: 15px;
    text-align: center;
}
.btn2:hover {
    background: #7a5bb3;
}

.divider {
    border: 2px solid #151522;
    margin: 40px 0;
}

.class-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
}

.class-card {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0px 3px 8px rgba(0,0,0,0.1);

}
.class-card:hover {
    transform: translateY(-5px);
}

.class-card h2 {
    color: #9e78d4;
    font-size: 25px;
    margin-bottom: 10px;
}

.class-card h3 {
    font-size: 20px;
    margin-bottom: 8px;
    color: #444;
}

.class-card p {
    font-size: 16px;
    margin-bottom: 10px;
}

/* Mensaje cuando no hay clases */
.no-classes {
    text-align: center;
    font-size: 20px;
    color: #555;
}
</style>

<?php require_once '../frontend/templates/footer.php'; ?>
