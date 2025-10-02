<?php
class StudentClassesController {
    public function index() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
            header('Location: ../login.php');
            exit();
        }
        
        require_once __DIR__ . '/../models/EnrollmentModel.php';
        require_once __DIR__ . '/../models/ClassModel.php';
        require_once __DIR__ . '/../models/TeacherModel.php';
        
        $enrollmentModel = new EnrollmentModel();
        $classModel = new ClassModel();
        $teacherModel = new TeacherModel();
        
        $correoEstudiante = $_SESSION['user_email'];
        
        $enrollments = $enrollmentModel->getStudentEnrollments($correoEstudiante);
        
        // Separar por estado
        $clasesActivas = [];
        $clasesCompletadas = [];
        $clasesCanceladas = [];
        
        foreach ($enrollments as $enrollment) {
            switch ($enrollment['Estado']) {
                case 'activo':
                    $clasesActivas[] = $enrollment;
                    break;
                case 'completado':
                    $clasesCompletadas[] = $enrollment;
                    break;
                case 'cancelado':
                    $clasesCanceladas[] = $enrollment;
                    break;
            }
        }
        
        $pagina = "Mis Clases";
        require_once __DIR__ . '/../../frontend/views/student/classes.php';
    }
    
    public function viewClass() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
            header('Location: ../login.php');
            exit();
        }
        
        if (!isset($_GET['id'])) {
            header('Location: clases.php');
            exit();
        }
        
        require_once __DIR__ . '/../models/EnrollmentModel.php';
        require_once __DIR__ . '/../models/ClassModel.php';
        require_once __DIR__ . '/../models/TeacherModel.php';
        require_once __DIR__ . '/../models/FileModel.php';
        
        $enrollmentModel = new EnrollmentModel();
        $classModel = new ClassModel();
        $teacherModel = new TeacherModel();
        $fileModel = new FileModel();
        
        $idClase = $_GET['id'];
        $correoEstudiante = $_SESSION['user_email'];
        
       
        if (!$enrollmentModel->isStudentEnrolled($correoEstudiante, $idClase)) {
            $_SESSION['error_message'] = "No estás inscrito en esta clase";
            header('Location: clases.php');
            exit();
        }
        
        $class = $classModel->getClassById($idClase);
        $teacher = $teacherModel->getTeacherByCedula($class['IdProfesor_FK']);
        $files = $fileModel->getFilesByClass($idClase);
        $enrollment = $enrollmentModel->getEnrollmentDetails($correoEstudiante, $idClase);
        
        $pagina = "Clase - " . $class['Materia'];
        require_once __DIR__ . '/../../frontend/views/student/class_detail.php';
    }
    
    public function cancelEnrollment() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
            header('Location: ../login.php');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idClase'])) {
            require_once __DIR__ . '/../models/EnrollmentModel.php';
            
            $enrollmentModel = new EnrollmentModel();
            $idClase = $_POST['idClase'];
            $correoEstudiante = $_SESSION['user_id'];
            
            if ($enrollmentModel->cancelEnrollment($correoEstudiante, $idClase)) {
                $_SESSION['success_message'] = "Inscripción cancelada correctamente";
            } else {
                $_SESSION['error_message'] = "Error al cancelar la inscripción";
            }
        }
        
        header('Location: clases.php');
        exit();
    }
    
    public function rateClass() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
            echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../models/EnrollmentModel.php';
            
            $enrollmentModel = new EnrollmentModel();
            $correoEstudiante = $_SESSION['user_email'];
            
            $idClase = $_POST['idClase'];
            $calificacion = $_POST['calificacion'];
            $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';
            
            if ($enrollmentModel->rateClass($correoEstudiante, $idClase, $calificacion, $comentario)) {
                echo json_encode(['success' => true, 'message' => 'Calificación enviada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al enviar la calificación']);
            }
        }
        
        exit();
    }
}// FIN DE LA CLASE
?>