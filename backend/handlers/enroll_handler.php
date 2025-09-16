<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'student') {
    require_once '../models/ClassModel.php';
    require_once '../models/EnrollmentModel.php';
    
    $claseId = $_POST['clase_id'];
    $profesorCedula = $_POST['profesor_id'];
    $estudianteEmail = $_SESSION['user_email'];
    
    $enrollmentModel = new EnrollmentModel();
    
    if ($enrollmentModel->enrollStudent($estudianteEmail, $claseId, $profesorCedula)) {
        $_SESSION['success_message'] = "¡Inscripción exitosa! El profesor se pondrá en contacto contigo.";
    } else {
        $_SESSION['error_message'] = "Error al inscribirse. Intenta nuevamente.";
    }
    
    header('Location: ../../teacher_detail.php?cedula=' . urlencode($profesorCedula));
    exit();
} else {
    echo "error login";
    //header('Location: ../../login.php');
    exit();
}
?>