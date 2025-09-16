<header>
    <p>Danna, aqui pon un header personalizado solo para esta pag->acerca de nosotros, faqs, contacto, etc, para las demas paginas se usara el header dinamico que esta en templates/header.php</p>
</header>
<div class="container">

    <h1><?php echo $title; ?></h1>
    <p><?php echo $welcome_message; ?></p>
    <p>mazna</p>
    <a href="lista-de-profesores">Ver el directorio completo</a>
</div>

<?php require_once 'frontend/templates/footer.php'; ?>