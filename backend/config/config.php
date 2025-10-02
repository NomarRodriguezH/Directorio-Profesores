<?php
define('SITE_NAME', 'Directorio de Profesores');
define('BASE_URL', 'http://localhost/dp/');

define('DB_HOST', 'localhost');
define('DB_NAME', 'directorio_profesores'); //CAMBIAR ESTO DEPENDIENDO EL NOMBRE ASIGNADO, YA SEA EN LOCAL O EN PRODUCCIÓN
define('DB_USER', 'root');
define('DB_PASS', '');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}
//subida de archivos
define('MAX_FILE_SIZE', 4 * 1024 * 1024); // 2MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']);
define('UPLOAD_DIR', '../frontend/assets/images/teachers/');


//ADMINISTRADORES, SI ALGUIEN PUEDE EDITAR ESTO = NOS HACEKEO DESDE EL HOSTING = TODO EL SISTEMA ES SUYO (POCO PROBABLE)
define('ADMIN_USERS', [
    'mazna@gmail.com'
]);
?>