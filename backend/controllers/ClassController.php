<?php
class ClassController {
    public function create() {
        $pagina ="Crear Clase";
        if (!isset($_SESSION['teacher_email']) || $_SESSION['user_type'] !== 'teacher') {
            $_SESSION['error_message'] = "Debes ser profesor para crear clases";
            echo $_SESSION['error_message'];    
                exit();
        }
        
        $errors = [];
        $success = false;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../models/ClassModel.php';
            $model = new ClassModel();
            
            $data = $this->validateClassData($_POST);
            
            if (empty($data['errors'])) {
                if ($model->createClass($data['data'])) {
                    $_SESSION['success_message'] = "Clase creada exitosamente";
                    header('Location: panel');
                    exit();
                } else {
                    $errors[] = "Error al crear la clase. Intenta nuevamente.";
                }
            } else {
                $errors = $data['errors'];
            }
        }
        
        require_once '../frontend/views/teacher/create_class.php';
    }
    
    public function edit() {
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
        
        if (!$model->isClassOwner($idClase, $cedulaProfesor)) {
            $_SESSION['error_message'] = "No tienes permiso para editar esta clase";
            header('Location: panel.php');
            exit();
        }
        
        $alumnos = $model->getClassEnrollments($idClase, $cedulaProfesor);
        $class = $model->getClassById($idClase);
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->validateClassData($_POST);
            if (empty($data['errors'])) {
                $data['data']['cedula'] = $cedulaProfesor;
                
                if ($model->updateClass($idClase, $data['data'])) {
                    $_SESSION['success_message'] = "Clase actualizada exitosamente";
                    header('Location: clase?id='.$idClase.'.php');
                    exit();
                } else {
                    $errors[] = "Error al actualizar la clase";
                }
            } else {
                $errors = $data['errors'];
            }
        }
        
        $page_title = "Editar Clase";
        require_once '../frontend/views/teacher/edit_class.php';
    }
    
    public function delete() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'teacher') {
            header('Location: ../login.php');
            exit();
        }
        
        if (!isset($_GET['id'])) {
            header('Location: teacher_dashboard.php');
            exit();
        }
        
        require_once __DIR__ . '/../models/ClassModel.php';
        $model = new ClassModel();
        
        $idClase = $_GET['id'];
        $cedulaProfesor = $_SESSION['user_cedula'];
        
        if ($model->deleteClass($idClase, $cedulaProfesor)) {
            $_SESSION['success_message'] = "Clase eliminada exitosamente";
        } else {
            $_SESSION['error_message'] = "Error al eliminar la clase";
        }
        
        header('Location: teacher_dashboard.php');
        exit();
    }
    
    private function validateClassData($postData) {
        $errors = [];
        $data = [];
        
        $data['idProfesor']=$_SESSION['user_id'];
        
        $required = ['materia', 'descripcion', 'nivel', 'modalidad'];
        foreach ($required as $field) {
            if (empty(trim($postData[$field]))) {
                $errors[] = "El campo " . ucfirst($field) . " es obligatorio";
            } else {
                $data[$field] = trim($postData[$field]);
            }
        }
        
        $data['maxEstudiantes'] = !empty($postData['maxEstudiantes']) ? 
            max(1, intval($postData['maxEstudiantes'])) : 1;
        
        $dias = ['lu', 'ma', 'mi', 'ju', 'vi', 'sa', 'do'];
        $hasSchedule = false;
        
        foreach ($dias as $dia) {
            if (isset($postData[$dia . 'HI']) && isset($postData[$dia . 'HF'])) {
                $hi = trim($postData[$dia . 'HI']);
                $hf = trim($postData[$dia . 'HF']);

                if (!empty($hi) && !empty($hf)) {
                    $hasSchedule = true;
                    
                    // Validar formato de horas
                    if (!preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', substr($hi, 0, 5)) || 
                        !preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', substr($hf, 0, 5))) {
                        $errors[] = "Formato de hora inválido para " . $this->getDiaNombre($dia);
                    } elseif (strtotime($hf) <= strtotime($hi)) {
                        $errors[] = "La hora de fin debe ser mayor a la de inicio para " . $this->getDiaNombre($dia);
                    }
                    
                    $data[$dia . 'HI'] = $hi;
                    $data[$dia . 'HF'] = $hf;

                } else {
                    $data[$dia . 'HI'] = null;
                    $data[$dia . 'HF'] = null;
                }
            }
        }
        
        if (!$hasSchedule) {
            $errors[] = "Debes especificar al menos un horario para la clase";
        }
        
        return ['data' => $data, 'errors' => $errors];
    }
    
    private function getDiaNombre($diaCode) {
        $dias = [
            'lu' => 'Lunes',
            'ma' => 'Martes',
            'mi' => 'Miércoles',
            'ju' => 'Jueves',
            'vi' => 'Viernes',
            'sa' => 'Sábado',
            'do' => 'Domingo'
        ];
        
        return $dias[$diaCode] ?? $diaCode;
    }
}
?>