<?php
class FileController {
    
  public function upload() {
    // Verificar si es profesor
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'teacher') {
        $_SESSION['error_message'] = "Acceso denegado";
        header('Location: gestionar.php');
        exit();
    }
    
    $logMessage = "[" . date('Y-m-d H:i:s') . "] Iniciando upload\n";
    file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $logMessage = "[" . date('Y-m-d H:i:s') . "] Método POST detectado\n";
        file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
        
        require_once __DIR__ . '/../models/FileModel.php';
        require_once __DIR__ . '/../models/ClassModel.php';
        
        $fileModel = new FileModel();
        $classModel = new ClassModel();
        
        $logMessage = "[" . date('Y-m-d H:i:s') . "] POST: " . print_r($_POST, true) . "\n";
        $logMessage .= "[" . date('Y-m-d H:i:s') . "] FILES: " . print_r($_FILES, true) . "\n";
        file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
        
        $idClase = isset($_POST['idClase']) ? $_POST['idClase'] : null;
        $idProfesor = $_SESSION['user_id'];
        
        $logMessage = "[" . date('Y-m-d H:i:s') . "] idClase: $idClase, idProfesor: $idProfesor\n";
        file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
        
        if (!$idClase) {
            $_SESSION['error_message'] = "Clase no especificada";
            header('Location: gestionar.php');
            exit();
        }
        
        if (!$classModel->isClassOwner($idClase, $idProfesor)) {
            $_SESSION['error_message'] = "No tienes permiso para subir archivos a esta clase";
            header("Location: gestionar.php?id=$idClase");
            exit();
        }
        
        if (empty($_FILES['archivo']['name']) || $_FILES['archivo']['error'] == UPLOAD_ERR_NO_FILE) {
            $_SESSION['error_message'] = "Debes seleccionar un archivo";
            header("Location: gestionar.php?id=$idClase");
            exit();
        }
        
        if ($_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño máximo permitido',
                UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño máximo del formulario',
                UPLOAD_ERR_PARTIAL => 'El archivo solo se subió parcialmente',
                UPLOAD_ERR_NO_FILE => 'No se seleccionó ningún archivo',
                UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal',
                UPLOAD_ERR_CANT_WRITE => 'Error al escribir el archivo en el disco',
                UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida del archivo'
            ];
            
            $errorMsg = $uploadErrors[$_FILES['archivo']['error']] ?? 'Error desconocido al subir el archivo';
            $_SESSION['error_message'] = $errorMsg;
            header("Location: gestionar.php?id=$idClase");
            exit();
        }
        
        $logMessage = "[" . date('Y-m-d H:i:s') . "] Archivo válido detectado\n";
        file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
        
        $data = [
            'idClase' => $idClase,
            'idProfesor' => $idProfesor,
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : ''
        ];
        
        $result = $fileModel->uploadFile($data, $_FILES['archivo']);
        
        $logMessage = "[" . date('Y-m-d H:i:s') . "] Resultado uploadFile: " . print_r($result, true) . "\n";
        file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
        
        if ($result['success']) {
            $_SESSION['success_message'] = "Archivo subido exitosamente";
            header("Location: gestionar.php?id=$idClase");
            exit();
        } else {
            $errorMsg = implode('<br>', $result['errors']);
            $_SESSION['error_message'] = $errorMsg;
            header("Location: gestionar.php?id=$idClase");
            exit();
        }
    } else {
        $logMessage = "[" . date('Y-m-d H:i:s') . "] No es método POST\n";
        file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
        $_SESSION['error_message'] = "Método no permitido";
        header('Location: gestionar.php');
        exit();
    }
}   



   public function manage() {
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'teacher') {
        header('Location: ' . base_url('profesores/login'));
        exit();
    }
    
    require_once __DIR__ . '/../models/FileModel.php';
    require_once __DIR__ . '/../models/ClassModel.php';
    
    $fileModel = new FileModel();
    $classModel = new ClassModel();
    $idProfesor = $_SESSION['user_id'];
    
    echo "<!-- DEBUG: user_id = " . $idProfesor . " -->\n";
    
    $idClase = isset($_GET['id']) ? $_GET['id'] : null;
    
    $classes = $classModel->getClassesByTeacher($idProfesor);
    
    echo "<!-- DEBUG: count(classes) = " . count($classes) . " -->\n";
    echo "<!-- DEBUG: classes = " . print_r($classes, true) . " -->\n";
    
    if ($idClase) {
        echo "<!-- DEBUG: idClase = " . $idClase . " -->\n";
        
        if (!$classModel->isClassOwner($idClase, $idProfesor)) {
            $_SESSION['error_message'] = "No tienes permiso para ver estos archivos";
            header('Location: ' . base_url('profesores/archivos'));
            exit();
        }
        
        $files = $fileModel->getFilesByClass($idClase, $idProfesor);
        $class = $classModel->getClassById($idClase);
        $pagina = "Archivos - " . $class['Materia'];
    } else {
        $files = $fileModel->getFilesByTeacher($idProfesor);
        $pagina = "Todos mis Archivos";
    }
    
    require_once __DIR__ . '/../../frontend/views/teacher/files.php';
}


    
    public function delete() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'teacher') {
            header('Location: ' . base_url('profesores/login'));
            exit();
        }
        
        if (!isset($_GET['id'])) {
            $_SESSION['error_message'] = "Archivo no especificado";
            header('Location: ' . base_url('profesores/archivos'));
            exit();
        }
        
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();
        
        $idArchivo = $_GET['id'];
        $cedulaProfesor = $_SESSION['teacher_cedula'];
        
        if ($fileModel->deleteFile($idArchivo, $cedulaProfesor)) {
            $_SESSION['success_message'] = "Archivo eliminado exitosamente";
        } else {
            $_SESSION['error_message'] = "Error al eliminar el archivo";
        }
        
        // Redirigir a la página anterior
        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url('profesores/archivos');
        header('Location: ' . $redirectUrl);
        exit();
    }
    
    public function download() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . base_url('login'));
            exit();
        }
        
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();
        
        $idArchivo = $_GET['id'];
        
        // Para estudiantes, verificar que estén inscritos en la clase
        if ($_SESSION['user_type'] === 'student') {
            require_once __DIR__ . '/../models/EnrollmentModel.php';
            $enrollmentModel = new EnrollmentModel();
            
            $file = $fileModel->getFileById($idArchivo);
            $isEnrolled = $enrollmentModel->isStudentEnrolled($_SESSION['user_email'], $file['IdClase_FK']);
            
            if (!$isEnrolled) {
                $_SESSION['error_message'] = "No tienes acceso a este archivo";
                header('Location: ' . base_url('estudiante/clases'));
                exit();
            }
        } else if ($_SESSION['user_type'] === 'teacher') {
            $file = $fileModel->getFileById($idArchivo, $_SESSION['teacher_cedula']);
            
            if (!$file) {
                $_SESSION['error_message'] = "Archivo no encontrado";
                header('Location: ' . base_url('profesores/archivos'));
                exit();
            }
        } else {
            header('Location: ' . base_url('login'));
            exit();
        }
        
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
            $_SESSION['error_message'] = "El archivo no existe";
            header('Location: ' . base_url('profesores/archivos'));
            exit();
        }
    }
    
    public function updateDescription() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'teacher') {
            echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../models/FileModel.php';
            $fileModel = new FileModel();
            
            $idArchivo = $_POST['idArchivo'];
            $descripcion = trim($_POST['descripcion']);
            $cedulaProfesor = $_SESSION['teacher_cedula'];
            
            if ($fileModel->updateFileDescription($idArchivo, $cedulaProfesor, $descripcion)) {
                echo json_encode(['success' => true, 'message' => 'Descripción actualizada']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
            }
        }
        
        exit();
    }
}
?>