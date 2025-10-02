
<!-- Fuentes -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jersey+20&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profesores Gengar</title>
  <style>
    
    /* ---- Estilos generales ---- */
    body {
      font-family: 'Jersey 20', 'Arial', sans-serif;
      font-size: 20px;
      margin: 0;
      padding: 0;
      background-color: #1c1c2b;
      color: white;
    }
    h1 {
      color: #9e78d4;
      margin-top: 5px;
      margin-bottom: 10px;
      text-align: center;
      font-size: 60px;

    }
    h2, h3 {
      color: #C7B7E8;
      text-align: center;
      font-size: 35px;
    }

    p {
      line-height: 1.6;
      text-align: center;
    }

    .container {

      width: 90%;
      max-width: 1100px;
      margin: 0 auto;
      padding: 40px 0;
    }

    /* ---- Encabezado ---- */
    header {
      background-color: #2a2342;
      padding: 20px 0;
      text-align: center;
    }

    header img {
      width: 110px;

      display: block;
      margin: 0 auto 0px;

    }

    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: #fff;
      font-weight: bold;
    }

    nav a:hover {
      color: white;
      background-color: #916FBE;
      border-radius: 5px;
      margin-left: 15px;
      text-decoration: none;
      padding: 6px 12px;

    }

    /* ---- Hero ---- */
    .hero {
      text-align: center;
      padding: 60px 20px;
      background: linear-gradient(to right, #1c1c2b, #2a2342);
    }

    .hero h2 {
      margin-bottom: 10px;
    }

    .hero p {
      max-width: 600px;
      margin: 0 auto 20px;
    }

    .hero button {
      font-family: 'Jersey 20', 'Arial', sans-serif; 
      font-size: 20px;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      background-color: #9e78d4;
      color: white;
      font-weight: normal;
      cursor: pointer;
    }

    .hero button:hover {
      background-color: #7a58b8;
    }

    /* ---- Beneficios ---- */
    .benefits {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
    }

    .benefit {
      background-color: #2a2342;
      padding: 20px;
      border-radius: 10px;
      width: 250px;
      text-align: center;
    }

    /* ---- FAQs ---- */
    .faq {
      background-color: #2a2342;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    /* ---- Contacto ---- */
    form {
      display: flex;
      flex-direction: column;
      width: 300px;
      margin: 0 auto;
    }

    form input, form textarea, form button {
      margin: 10px 0;
      padding: 10px;
      border: none;
      border-radius: 5px;
    }

.btn {
    font-size: 20px;
  padding: 10px 20px;
  border-radius: 5px;
  background-color: #9e78d4;
  color: white;
  font-weight: normal;
  text-decoration: none;
  display: inline-block;
  margin-right: 20px;
  margin-left: 20px;
}

.btn:hover {
  background-color: #7a58b8;
}

.btn2 {
  font-size: 20px;
  padding: 10px 20px;
  border-radius: 5px;
  background-color: #9e78d4;
  color: white;
  font-weight: normal;
  text-decoration: none;
  display: block;     
  width: fit-content;  
  margin: 0 auto;  
}

.btn2:hover {
  background-color: #7a58b8;
}



  </style>
</head>
<body>

  <!-- Encabezado -->
  <header>
    <img src="https://www.pngplay.com/wp-content/uploads/11/Gengar-PNG-Photos.png" alt="Logo Gengar">
    <h1>Profesores Gengar</h1>
    <nav>
      <a href="#acerca">Acerca de</a>
      <a href="#nosotros">Sobre Nosotros</a>
      <a href="#beneficios">Beneficios</a>
      <a href="#faq">FAQs</a>
      <a href="#contacto">Contacto</a>
    </nav>
  </header>

  <!-- Hero -->
  <section class="hero">
    <h2>Unete a nuestra plataforma</h2>
    <p>Profesores Gengar conecta alumnos con profesores expertos en diversas áreas. Aprende lo que quieras, cuando quieras. Registrate ahora como alumno o profesor.</p>
    <a href="registro-estudiante" class="btn">Comienza como alumno</a>
    <a href="profesores/registro" class="btn">Comienza como profesor</a>
  </section>

  <section id="profesores" class="container">
    <h2>Encuentra un profesor ideal para ti</h2>
    <p>Visita nuestro catálogo de profesores, encuentra el adecuado para ti y utiliza nuestros filtros de búsqueda para sugerencias personalizadas.</p>
    <a href="lista-de-profesores" class="btn2">Ver catálogo de profesores</a>
    
  </section>

  <!-- Acerca de -->
  <section id="acerca" class="container">
    <h2>Acerca de</h2>
    <p>Somos una plataforma dedicada a ofrecer un espacio donde los profesores pueden dar a conocer sus servicios y los alumnos encontrar apoyo académico fácilmente.</p>
    <p>Si eres profesor tendrás la oportunidad de ofrecer tus servicios al precio y horarios que tu elijas.</p>
    <p>Los alumnos podrán elegir el profesor de su agrado guiandose en los detalles de su información personal. Buscando las especialidades y horraios de tu interes.</p>
  </section>



  <!-- Sobre nosotros -->
  <section id="nosotros" class="container">
    <h2>Sobre Nosotros</h2>
    <p>Somos un grupo de desarrolladores independientes con la finalidad de crear un excelente sistema. Profesores Gengar nació con la idea de simplificar el acceso a la educación personalizada. Creemos que cada estudiante merece un guía adecuado a su ritmo y estilo de aprendizaje.</p>
  </section>

  <!-- Beneficios -->
  <section id="beneficios" class="container">
    <h2>Beneficios</h2>
    <div class="benefits">
      <div class="benefit">
        <h3>🎓 Variedad de Profesores</h3>
        <p>Contamos con gran variedad de maestros especializados en distintas materias, encuentra tu favorito.</p>
      </div>
      <div class="benefit">
        <h3>⚡ Filtros Rápidos</h3>
        <p>Encuentra al profesor ideal aplicando filtros según tus necesidades y tus preferencias.</p>
      </div>
      <div class="benefit">
        <h3>💻 Modalidad Flexible</h3>
        <p>Elige tus clases y tus profesores desde la comodidad de tu casa.</p>
      </div>
    </div>
  </section>

  <!-- FAQs -->
  <section id="faq" class="container">
    <h2>Preguntas Frecuentes</h2>
    <div class="faq">
      <h3>¿Cómo encuentro a un profesor?</h3>
      <p>Usa nuestro buscador y selecciona filtros como especialidad, estado, precios, etc.</p>
    </div>
    <div class="faq">
      <h3>¿Cómo registro mi perfil?</h3>
      <p>Accede a la sección de registro y completa tus datos como alumno o profesor.</p>
    </div>
    <div class="faq">
      <h3>¿El servicio es gratuito?</h3>
      <p>Sí, el uso básico de la plataforma es completamente gratuito tanto para profesores como alumnos.</p>
    </div>
  </section>

  <!-- Contacto -->
  <section id="contacto" class="container">
    <h2>Contacto</h2>
    <form>
      <input type="text" placeholder="Tu nombre">
      <input type="email" placeholder="Tu correo">
      <textarea rows="4" placeholder="Escribe tu mensaje..."></textarea>
      <button type="submit">Enviar</button>
    </form>
  </section>

</body>
</html>

<?php require_once 'frontend/templates/footer.php'; ?>