<?php
class TeacherController {
    public function list() {
        require_once __DIR__ . '/../models/TeacherModel.php';
        $pagina ="Lista de Profesores";
        $model = new TeacherModel();
        
        $especialidad = isset($_GET['especialidad']) ? trim($_GET['especialidad']) : '';
        $estado = isset($_GET['estado']) ? trim($_GET['estado']) : '';
        $delegacion = isset($_GET['delegacion']) ? trim($_GET['delegacion']) : '';
        $precio_min = isset($_GET['precio_min']) ? floatval($_GET['precio_min']) : 0;
        $precio_max = isset($_GET['precio_max']) ? floatval($_GET['precio_max']) : 0;
        $busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
        
        
        $pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
        $profesores_por_pagina = 12;
        $offset = ($pagina_actual - 1) * $profesores_por_pagina;
        
        $resultados = $model->getTeachersWithFilters(
            $especialidad, 
            $estado, 
            $delegacion, 
            $precio_min, 
            $precio_max, 
            $busqueda,
            $profesores_por_pagina,
            $offset
        );
        
        $teachers = $resultados['profesores'];
        $total_profesores = $resultados['total'];
        
        // Calcular total de páginas
        $total_paginas = ceil($total_profesores / $profesores_por_pagina);
        
        $especialidades = $model->getAllSpecialties();
        $estados = $model->getAllStates();
        $delegaciones = $model->getAllDelegations($estado);
        
        $page_title = "Profesores Disponibles";
        require_once 'frontend/views/teacher/list.php';
    }
    
    public function detail() {
        if (isset($_GET['correo'])) {
            require_once __DIR__ . '/../models/TeacherModel.php';
            require_once __DIR__ . '/../models/ClassModel.php';
            require_once __DIR__ . '/../models/ReviewModel.php';
            
            $teacherModel = new TeacherModel();
            $classModel = new ClassModel();
            $reviewModel = new ReviewModel();
            
            $teacher = $teacherModel->getTeacherByCedula($_GET['correo']); // SE CAMBIO EL CORREO POR LA CEDULA
            if ($teacher) {
                $classes = $classModel->getClassesByTeacher($_GET['correo']);
                $reviews = $reviewModel->getReviewsByTeacher($_GET['correo']);
                $ratingStats = $reviewModel->getRatingStats($_GET['correo']);
                
                $page_title = $teacher['Nombre'] . " " . $teacher['ApPaterno'] . " - Perfil";
                require_once 'frontend/views/teacher/detail.php';
            } else {
                $_SESSION['error_message'] = "Profesor no encontrado";
                echo "erro 1";
                //header('Location: lista-de-profesores.php');
                exit();
            }
        } else {
            echo "error 2";
            //header('Location: lista-de-profesores.php');
            exit();
        }
    }
}
?>