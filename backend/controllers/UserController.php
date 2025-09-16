<?php
class UserController {
    public function register() {
        $errors = [];
        $success = false;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => trim($_POST['email']),
                'nombre' => trim($_POST['nombre']),
                'apPaterno' => trim($_POST['apPaterno']),
                'apMaterno' => trim($_POST['apMaterno']),
                'celular' => trim($_POST['celular']),
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password']
            ];
            
            // Validaciones
            require_once __DIR__ . '/../models/UserModel.php';
            $model = new UserModel();
            
            if (empty($data['email'])) {
                $errors[] = "El correo electrónico es obligatorio";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El formato del correo electrónico no es válido";
            } elseif ($model->emailExists($data['email'])) {
                $errors[] = "Este correo electrónico ya está registrado";
            }
            
            if (empty($data['nombre'])) {
                $errors[] = "El nombre es obligatorio";
            }
            
            if (empty($data['apPaterno'])) {
                $errors[] = "El apellido paterno es obligatorio";
            }
            
            if (empty($data['password'])) {
                $errors[] = "La contraseña es obligatoria";
            } elseif (strlen($data['password']) < 6) {
                $errors[] = "La contraseña debe tener al menos 6 caracteres";
            } elseif ($data['password'] !== $data['confirm_password']) {
                $errors[] = "Las contraseñas no coinciden";
            }
            
            // Si no hay errores, registrar usuario
            if (empty($errors)) {
                if ($model->createUser($data)) {
                    $success = true;
                    $_SESSION['success_message'] = "Registro exitoso. Ahora puedes iniciar sesión.";
                    header('Location: login');
                    exit();
                } else {
                    $errors[] = "Error al registrar. Intente nuevamente.";
                }
            }
        }
        
        $page_title = "Registro de Estudiante";
        require_once 'frontend/views/student/register.php';
    }

    public function registerTeacher() {
        $errors = [];
        $success = false;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => trim($_POST['email']),
                'nombre' => trim($_POST['nombre']),
                'apPaterno' => trim($_POST['apPaterno']),
                'apMaterno' => trim($_POST['apMaterno']),
                'celular' => trim($_POST['celular']),
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password']
            ];
            
           require_once __DIR__ . '/../models/UserModel.php';
            $model = new UserModel();
            
            if (empty($data['email'])) {
                $errors[] = "El correo electrónico es obligatorio";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El formato del correo electrónico no es válido";
            } elseif ($model->emailExists($data['email'])) {
                $errors[] = "Este correo electrónico ya está registrado";
            }
            
            if (empty($data['nombre'])) {
                $errors[] = "El nombre es obligatorio";
            }
            
            if (empty($data['apPaterno'])) {
                $errors[] = "El apellido paterno es obligatorio";
            }
            
            if (empty($data['password'])) {
                $errors[] = "La contraseña es obligatoria";
            } elseif (strlen($data['password']) < 6) {
                $errors[] = "La contraseña debe tener al menos 6 caracteres";
            } elseif ($data['password'] !== $data['confirm_password']) {
                $errors[] = "Las contraseñas no coinciden";
            }
            
            if (empty($errors)) {
                if ($model->createUser($data)) {
                    $success = true;
                    $_SESSION['success_message'] = "Registro exitoso. Ahora puedes iniciar sesión.";
                    header('Location: login');
                    exit();
                } else {
                    $errors[] = "Error al registrar. Intente nuevamente.";
                }
            }
        }
        
        $page_title = "Registro de Estudiante";
        require_once 'frontend/views/student/register.php';
    }

    
    public function login() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
            if (empty($email) || empty($password)) {
                $errors[] = "Correo y contraseña son obligatorios";
            } else {
                require_once __DIR__ . '/../models/UserModel.php';
                $model = new UserModel();
                
                $user = $model->validateUser($email, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['Correo'];
                    $_SESSION['user_name'] = $user['Nombre'] . ' ' . $user['ApPaterno'];
                    $_SESSION['user_type'] = 'student';
                    
                    header('Location: panel.php');
                    exit();
                } else {
                    $errors[] = "Credenciales incorrectas";
                }
            }
        }
        
        $page_title = "Iniciar Sesión";
        require_once 'frontend/views/student/login.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit();
    }
    
    public function profile() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
            header('Location: login.php');
            exit();
        }
        
       require_once __DIR__ . '/../models/UserModel.php';
        $model = new UserModel();
        $user = $model->getUserByEmail($_SESSION['user_email']);
        
        $errors = [];
        $success = false;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'apPaterno' => trim($_POST['apPaterno']),
                'apMaterno' => trim($_POST['apMaterno']),
                'celular' => trim($_POST['celular']),
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password']
            ];
            
            if (empty($data['nombre'])) {
                $errors[] = "El nombre es obligatorio";
            }
            
            if (empty($data['apPaterno'])) {
                $errors[] = "El apellido paterno es obligatorio";
            }
            
            if (!empty($data['password'])) {
                if (strlen($data['password']) < 6) {
                    $errors[] = "La contraseña debe tener al menos 6 caracteres";
                } elseif ($data['password'] !== $data['confirm_password']) {
                    $errors[] = "Las contraseñas no coinciden";
                }
            }
            
            if (empty($errors)) {
                if ($model->updateUser($_SESSION['user_email'], $data)) {
                    $success = true;
                    $_SESSION['user_name'] = $data['nombre'] . ' ' . $data['apPaterno'];
                    $user = $model->getUserByEmail($_SESSION['user_email']);
                } else {
                    $errors[] = "Error al actualizar el perfil";
                }
            }
        }
        
        $page_title = "Mi Perfil";
        require_once 'frontend/views/student/profile.php';
    }
}
?>