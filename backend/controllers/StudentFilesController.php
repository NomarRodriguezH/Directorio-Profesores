<?php
class StudentFilesController {
    public function index() {
      
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
            header('Location: ../login.php');
            exit();
        }
        
        require_once __DIR__ . '/../models/FileModel.php';
        require_once __DIR__ . '/../models/EnrollmentModel.php';
        require_once __DIR__ . '/../models/ClassModel.php';
        
        $fileModel = new FileModel();
        $enrollmentModel = new EnrollmentModel();
        $classModel = new ClassModel();
        
        $correoEstudiante = $_SESSION['user_email'];
        
        
        $idClase = isset($_GET['clase_id']) ? $_GET['clase_id'] : null;
        $tipoArchivo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
        
       
        if ($idClase) {
            if (!$enrollmentModel->isStudentEnrolled($correoEstudiante, $idClase)) {
                $_SESSION['error_message'] = "No tienes acceso a esta clase";
                header('Location: archivos.php');
                exit();
            }
            
            $files = $fileModel->getFilesByClass($idClase);
            $class = $classModel->getClassById($idClase);
            $page_title = "Archivos - " . $class['Materia'];
        } else {
            $files = $fileModel->getRecentFilesForStudent($correoEstudiante, 50);
            $page_title = "Todos mis Archivos";
        }
        
        // Filtrar por tipo si se especifica
        if ($tipoArchivo) {
            $files = array_filter($files, function($file) use ($tipoArchivo) {
                return strpos($file['TipoArchivo'], $tipoArchivo) !== false;
            });
        }
        
      
        $enrollments = $enrollmentModel->getStudentEnrollments($correoEstudiante);
        $clases = [];
        foreach ($enrollments as $enrollment) {
            if ($enrollment['Estado'] === 'activo') {
                $clases[] = [
                    'IdClase' => $enrollment['IdClase_FK'],
                    'Materia' => $enrollment['Materia']
                ];
            }
        }
        
       
        $fileStats = $this->getFileStats($files);
        
        require_once __DIR__ . '/../../frontend/views/student/files.php';
    }
    
    public function download() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
            header('Location: ../login.php');
            exit();
        }
        
        if (!isset($_GET['id'])) {
            header('Location: archivos.php');
            exit();
        }
        
        require_once __DIR__ . '/../models/FileModel.php';
        require_once __DIR__ . '/../models/EnrollmentModel.php';
        
        $fileModel = new FileModel();
        $enrollmentModel = new EnrollmentModel();
        
        $idArchivo = $_GET['id'];
        $correoEstudiante = $_SESSION['user_email'];
        
       
        $file = $fileModel->getFileById($idArchivo);
        
        if (!$file) {
            $_SESSION['error_message'] = "Archivo no encontrado";
            header('Location: archivos.php');
            exit();
        }
        
       
        if (!$enrollmentModel->isStudentEnrolled($correoEstudiante, $file['IdClase_FK'])) {
            $_SESSION['error_message'] = "No tienes acceso a este archivo";
            header('Location: archivos.php');
            exit();
        }
        
        // Descargar el archivo
        $filePath = '../' . $file['ArchivoURL'];
        
        if (file_exists($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file['NombreArchivo']) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit();
        } else {
            $_SESSION['error_message'] = "El archivo no existe en el servidor";
            header('Location: archivos.php');
            exit();
        }
    }
    
    private function getFileStats($files) {
        $stats = [
            'total' => count($files),
            'por_tipo' => [],
            'total_size' => 0
        ];
        
        foreach ($files as $file) {
            $stats['total_size'] += $file['Tamanio'];
            
            $tipo = pathinfo($file['NombreArchivo'], PATHINFO_EXTENSION);
            if (!isset($stats['por_tipo'][$tipo])) {
                $stats['por_tipo'][$tipo] = 0;
            }
            $stats['por_tipo'][$tipo]++;
        }
        
        return $stats;
    }
}
?>