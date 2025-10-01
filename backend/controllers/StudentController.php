<?php
class StudentController {
    public function acceptInClass() {
        $page_title = "Editar Clase";

        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'teacher') {
            header('Location: ../login.php');
            exit();
        }
        
        if (!isset($_GET['id'])) {
            header('Location: panel.php');
            exit();
        }

        require_once __DIR__ . '/../models/ClassModel.php';
        $model = new ClassModel();
        
        $idClase = $_GET['id'];
        $cedulaProfesor = $_SESSION['user_id'];
        
        // Verificar que el profesor sea dueño de la clase
        if (!$model->isClassOwner($idClase, $cedulaProfesor)) {
            $_SESSION['error_message'] = "No tienes permiso para editar esta clase";
            header('Location: panel.php');
            exit();
        }

        require_once '../frontend/views/teacher/edit_class.php';
    }
}
?>