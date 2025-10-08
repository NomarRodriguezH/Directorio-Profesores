<?php require_once '../frontend/templates/header.php'; ?>

<div class="teacher-container">
    <!-- Datos del profesor -->
    <div class="profile-card" id="datos">
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

        <a onclick="editar()" class="btn2">✏️ Editar mis datos</a>
    </div>

    <div class="profile-card" style="display: none;" id="nuevos-datos">
        <form action="panel" method="POST">
            <h1 class="title">Mis datos personales</h1>

            <div class="info-block">

                <p><span class="Caracteristicas">ID Profesor:</span> <span class="variable"> <?php print($teacherData['IdProfesor']); ?> </span></p>

                <p><span class="Caracteristicas">Correo: </span><input type="text" name="correo" class="variable form-control" value="<?php print($teacherData['Correo']); ?>"></p>

                <p>
                    <span class="Caracteristicas">Nombre:</span>
                    <input type="text" name="nombre" class="variable form-control" value="<?php print($teacherData['Nombre']); ?>" placeholder="Nombre(s)">
                    <input type="text" name="apPaterno" class="variable form-control" value="<?php print($teacherData['ApPaterno']); ?>" placeholder="Apellido paterno">
                    <input type="text" name="apMaterno" class="variable form-control" value="<?php print($teacherData['ApMaterno']); ?>" placeholder="Apellido materno">
                </p>

                <p><span class="Caracteristicas">Especialidad:</span><input type="text" name="especialidad" class="variable form-control" value="<?php print($teacherData['Especialidad']); ?>"></p>

                <p><span class="Caracteristicas">Celular:</span><input type="tel" name="celular" class="variable form-control" value="<?php print($teacherData['Celular']); ?>"></p>

                <p><span class="Caracteristicas">Cédula profesional: </span><input type="text" name="cedula" class="variable form-control" value="<?php print($teacherData['CedulaP']); ?>"></p>

            </div>
            <p> </p>
            <div class="info-block">
                <p> </p>
                <span class="Caracteristicas"> Descripción:</span>
                <p><textarea name="descripcion" class="form-control"><?php print(nl2br(htmlspecialchars($teacherData['Descripcion']))); ?></textarea></p>
            </div>

            <div class="info-block">
                <span class="Caracteristicas">Rango de precio:</span>
                <p>$<input type="number" name="precioMin" class="normal form-control" value="<?php print($teacherData['PrecioMin']) ?>">-$<input type="number" name="precioMax" class="normal form-control" value="<?php print($teacherData['PrecioMax']) ?>"></p>
            </div>

            <div class="info-block">
                <span class="Caracteristicas">Dirección</span>
                <p>
                    <input type="text" name="estado" class="normal form-control" value="<?php print($teacherData['Estado']); ?>" placeholder="Estado">
                    <input type="text" name="delegacion" class="normal form-control" value="<?php print($teacherData['Delegacion']); ?>" placeholder="Delegación">
                    <input type="text" name="cp" class="normal form-control" value="<?php print($teacherData['CP']); ?>" placeholder="Código postal">
                    <input type="text" name="colonia" class="normal form-control" value="<?php print($teacherData['Colonia']); ?>" placeholder="Colonia">
                    <input type="text" name="calle" class="normal form-control" value="<?php print($teacherData['Calle']); ?>" placeholder="Calle">
                    <input type="text" name="noExt" class="normal form-control" value="<?php print($teacherData['NoExt']); ?>" placeholder="Numero exterior">
                    <input type="text" name="noInt" class="normal form-control" value="<?php (!empty($teacherData['NoInt']))? print($teacherData['NoInt']) : ""; ?>" placeholder="Numero interior">
                </p>
            </div>

            <a onclick="editar()" class="btn2-alt">✏️ Cancelar cambios</a>
            <button type="submit" class="btn btn-primary btn-lg">Guardar cambios</button>
        </form>
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

<script>
    function editar() {
        datos = document.getElementById("datos")
        nuevosDatos = document.getElementById("nuevos-datos")
        if(nuevosDatos.style.display == 'none') {
            datos.style.display = 'none'
            nuevosDatos.style.display = 'block'
        } else {
            datos.style.display = 'block'
            nuevosDatos.style.display = 'none'
        }
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Jersey+20&display=swap');

body {
    background: url('https://pokewalls.wordpress.com/wp-content/uploads/2011/01/94gengar1920x1200.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Jersey 20', sans-serif;
    color: #222;
}

.teacher-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px;
}

.profile-card {
    background: #fff;
    padding: 30px;
    margin-bottom: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

.profile-header {
    display: flex;
    align-items: flex-start;
    gap: 30px;
    margin-bottom: 25px;
}

.profile-photo {
    width: 180px;
    height: 180px;
    border-radius: 20px;
    background: linear-gradient(135deg, #9e78d4, #7a5bb3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 60px;
    border: 5px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    flex-shrink: 0;
}

.profile-info {
    flex: 1;
}

.title {
    text-align: center;
    font-size: 42px;
    margin-bottom: 25px;
    color: #9e78d4;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
}

.info-block {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid #9e78d4;
    transition: all 0.3s ease;
}
.info-block:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.Caracteristicas {
    color: #895F9E;
    font-size: 24px;
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.variable {
    color: #333;
    font-size: 22px;
    font-weight: normal;
}

.info-block p {
    font-size: 18px;
    margin-bottom: 12px;
    line-height: 1.4;
}

.btn2 {
    display: inline-block;
    padding: 12px 25px;
    background: #9e78d4;
    color: #fff;
    border-radius: 10px;
    font-size: 20px;
    text-decoration: none;
    margin-top: 15px;
    text-align: center;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}
.btn2:hover {
    background: #7a5bb3;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.btn2-alt {
    display: inline-block;
    padding: 12px 25px;
    background: #6c757d;
    color: #fff;
    border-radius: 10px;
    font-size: 20px;
    text-decoration: none;
    margin-top: 15px;
    text-align: center;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}
.btn2-alt:hover {
    background: #545b62;
    transform: translateY(-2px);
}

.btn-primary {
    font-family: "Jersey 20", sans-serif; 
    background-color: #9e78d4;
    border: none;
    border-radius: 10px;
    padding: 12px 25px;
    margin-left: 15px;
    font-size: 20px;
    color: #fff;
    margin-top: 15px;
    transition: all 0.3s ease;
}
.btn-primary:hover {
    background-color: #7b5bb0;
    transform: translateY(-2px);
}

.divider {
    border: 2px solid #151522;
    margin: 40px 0;
}

.class-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 25px;
}

.class-card {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border-top: 4px solid #9e78d4;
}
.class-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.class-card h2 {
    color: #9e78d4;
    font-size: 24px;
    margin-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 8px;
}

.class-card h3 {
    font-size: 18px;
    margin-bottom: 8px;
    color: #444;
}

.class-card p {
    font-size: 16px;
    margin-bottom: 10px;
    line-height: 1.4;
}

.no-classes {
    text-align: center;
    font-size: 20px;
    color: #555;
    padding: 40px;
}

.form-control,
.form-select,
textarea {
    font-family: "Jersey 20", sans-serif; 
    border-radius: 8px;
    border: 2px solid #ddd;
    padding: 12px;
    transition: all 0.3s ease;
    font-size: 18px;
}
.form-control:focus,
.form-select:focus,
textarea:focus {
    border-color: #9e78d4;
    box-shadow: 0 0 0 3px rgba(158, 120, 212, 0.1);
    outline: none;
}

textarea {
    font-size: 18px;
    width: 98%;
    min-height: 100px;
    resize: vertical;
}

.normal {
    font-size: 18px;
}

.form-row {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.form-row input {
    flex: 1;
}

.photo-upload {
    text-align: center;
    margin-top: 10px;
}

.photo-upload input {
    margin-top: 10px;
}
</style>

<?php require_once '../frontend/templates/footer.php'; ?>
