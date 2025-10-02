<?php
class AdminController {
    public function dashboard() {
        $this->checkAdminAccess();
        
        require_once __DIR__ . '/../models/UserModel.php';
        require_once __DIR__ . '/../models/TeacherModel.php';
        
        $userModel = new UserModel();
        $teacherModel = new TeacherModel();
        
        // Obtener datos para el dashboard
        $stats = [
            'total_estudiantes' => $userModel->countAllUsers(),
            'total_profesores' => $teacherModel->countAllTeachers(),
            'estudiantes_activos' => $userModel->countActiveUsers(),
            'profesores_activos' => $teacherModel->countActiveTeachers()
        ];
        
        $estudiantes = $userModel->getAllUsers();
        $profesores = $teacherModel->getAllTeachers();
        
        $page_title = "Panel de Administración";
        require_once __DIR__ . '/../../frontend/views/admin/dashboard.php';
    }
    
    public function toggleUserStatus() {
        $this->checkAdminAccess();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id']) && isset($_POST['user_type'])) {
            require_once __DIR__ . '/../models/UserModel.php';
            require_once __DIR__ . '/../models/TeacherModel.php';
            
            $userId = $_POST['user_id'];
            $userType = $_POST['user_type'];
            $newStatus = $_POST['new_status'];
            
            if ($userType === 'student') {
                $model = new UserModel();
                $result = $model->toggleUserStatus($userId, $newStatus);
            } else if ($userType === 'teacher') {
                $model = new TeacherModel();
                $result = $model->toggleTeacherStatus($userId, $newStatus);
            } else {
                $_SESSION['error_message'] = "Tipo de usuario no válido";
                header('Location: dashboard.php');
                exit();
            }
            
            if ($result) {
                $_SESSION['success_message'] = "Estado actualizado correctamente";
            } else {
                $_SESSION['error_message'] = "Error al actualizar el estado";
            }
        }
        
        header('Location: panel');
        exit();
    }
    
    private function checkAdminAccess() {
        // 1. Verificar sesión activa
        if (!isset($_SESSION['user_id'])) {
           //echo "Debes iniciar sesión para acceder al panel de administración";
            header('Location: ../login.php');
            exit();
        }
        
        // 2. Verificar permisos de administrador
        if (!in_array($_SESSION['user_email'], ADMIN_USERS)) {
            //echo $_SESSION['user_email'];
            //echo "No tienes permisos para acceder al panel de administración";
            header('Location: ../index.php');
            exit();
        }
        
    }
}
?>