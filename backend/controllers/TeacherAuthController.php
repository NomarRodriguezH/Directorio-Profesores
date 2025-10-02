<?php
class TeacherAuthController {
    public function register() {
        $errors = [];
        $success = false;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
               require_once __DIR__ . '/../models/TeacherModel.php';


            $model = new TeacherModel();
            
            $validationResult = $this->validateTeacherData($_POST, $_FILES);
            
            if (empty($validationResult['errors'])) {
                $photoResult = $this->processPhoto($_FILES['foto']);
                
                if ($photoResult['success']) {
                    if ($model->createTeacherWithPhoto($validationResult['data'], $photoResult['photoName'])) {
                        $_SESSION['success_message'] = "Registro exitoso. Ahora puedes iniciar sesión.";
                        header('Location: login.php');
                        exit();
                    } else {
                        $errors[] = "Error al registrar el profesor. Intente nuevamente.";
                    }
                } else {
                    $errors = array_merge($errors, $photoResult['errors']);
                }
            } else {
                $errors = $validationResult['errors'];
            }
        }
        
        $pagina = "Registro de Profesor";
        require_once '../frontend/views/teacher/register.php';
    }
    
    public function login() {
        if (isset($_SESSION['teacher_email']) || $_SESSION['user_type'] == 'teacher') {
            echo "Ya inciaste sesión";  
                //        require_once '../frontend/views/teacher/panel.php';

            exit();
        }
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cedula = trim($_POST['cedula']);
            $password = $_POST['password'];
            
            if (empty($cedula) || empty($password)) {
                $errors[] = "Correo y contraseña son obligatorios";
            } else {
                require_once __DIR__ . '/../models/TeacherModel.php';
                $model = new TeacherModel();
                
                $teacher = $model->getTeacherByCedula($cedula);
                
                if ($teacher && password_verify($password, $teacher['pass'])) {
                    $_SESSION['user_id'] = $teacher['IdProfesor'];
                    $_SESSION['teacher_email'] = $teacher['Correo'];
                    $_SESSION['user_name'] = $teacher['Nombre'] . ' ' . $teacher['ApPaterno'];
                    $_SESSION['user_type'] = 'teacher';
                    
                    header('Location: panel.php');
                    exit();
                } else {
                    $errors[] = "Cédula o contraseña incorrectos";
                }
            }
        }
        
        $pagina = "Iniciar Sesión - Profesor";
        require_once '../frontend/views/teacher/login.php';
    }
    
    private function validateTeacherData($postData, $filesData) {
        $errors = [];
        $data = [];

        $data['cedula'] = trim($postData['cedula']);
        
        
        $personalFields = ['nombre', 'apPaterno', 'especialidad', 'celular', 'correo'];
        foreach ($personalFields as $field) {
            if (empty(trim($postData[$field]))) {
                $errors[] = "El campo " . ucfirst($field) . " es obligatorio";
            } else {
                $data[$field] = trim($postData[$field]);
            }
        }
        
        $data['apMaterno'] = !empty(trim($postData['apMaterno'])) ? trim($postData['apMaterno']) : '';
        
        if (!empty($data['correo']) && !filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El formato del correo electrónico no es válido";
        }
        
        $data['precioMin'] = !empty($postData['precioMin']) ? max(0, floatval($postData['precioMin'])) : 0;
        $data['precioMax'] = !empty($postData['precioMax']) ? max($data['precioMin'], floatval($postData['precioMax'])) : $data['precioMin'];
        
        if ($data['precioMax'] < $data['precioMin']) {
            $errors[] = "El precio máximo no puede ser menor al precio mínimo";
        }
        
        $addressFields = ['estado', 'delegacion', 'cp', 'colonia', 'calle'];
        foreach ($addressFields as $field) {
            if (empty(trim($postData[$field]))) {
                $errors[] = "El campo " . ucfirst($field) . " es obligatorio";
            } else {
                $data[$field] = trim($postData[$field]);
            }
        }
        
        $data['noExt'] = !empty(trim($postData['noExt'])) ? trim($postData['noExt']) : '';
        $data['noInt'] = !empty(trim($postData['noInt'])) ? trim($postData['noInt']) : '';
        
        $data['descripcion'] = !empty(trim($postData['descripcion'])) ? trim($postData['descripcion']) : '';
        
        if (empty($postData['password'])) {
            $errors[] = "La contraseña es obligatoria";
        } elseif (strlen($postData['password']) < 6) {
            $errors[] = "La contraseña debe tener al menos 6 caracteres";
        } elseif ($postData['password'] !== $postData['confirm_password']) {
            $errors[] = "Las contraseñas no coinciden";
        } else {
            $data['password'] = $postData['password'];
        }
        
        $data['fechaIngreso'] = !empty($postData['fechaIngreso']) ? $postData['fechaIngreso'] : date('Y-m-d');
        
        if (empty($errors)) {
            require_once __DIR__.'/../models/TeacherModel.php';
            $model = new TeacherModel();
            
            if ($model->cedulaExists($data['cedula'])) {
                $errors[] = "La cédula profesional ya está registrada";
            }
            
            if ($model->emailExists($data['correo'])) {
                $errors[] = "El correo electrónico ya está registrado";
            }
        }
        
        return ['data' => $data, 'errors' => $errors];
    }
    
    private function processPhoto($file) {
        $errors = [];
        $photoName = '';
        
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            $photoName = 'default-teacher.jpg';
            return ['success' => true, 'photoName' => $photoName];
        }
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Error al subir la foto: " . $this->getUploadError($file['error']);
            return ['success' => false, 'errors' => $errors];
        }
        
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($file['tmp_name']);
        
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Solo se permiten archivos JPG, PNG o GIF";
            return ['success' => false, 'errors' => $errors];
        }
        
        // Validar tamaño (máximo 2MB)
        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $errors[] = "La imagen no debe pesar más de 2MB";
            return ['success' => false, 'errors' => $errors];
        }
        
        // Crear directorio si no existe
        $uploadDir = '../frontend/assets/images/teachers/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $photoName = 'teacher_' . time() . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $photoName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $this->resizeImage($targetPath, 500, 500);
            return ['success' => true, 'photoName' => 'teachers/' . $photoName];
        } else {
            $errors[] = "Error al guardar la imagen";
            return ['success' => false, 'errors' => $errors];
        }
    }
    
    private function getUploadError($errorCode) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño máximo permitido',
            UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño máximo del formulario',
            UPLOAD_ERR_PARTIAL => 'El archivo solo se subió parcialmente',
            UPLOAD_ERR_NO_FILE => 'No se seleccionó ningún archivo',
            UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal',
            UPLOAD_ERR_CANT_WRITE => 'Error al escribir el archivo en el disco',
            UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida del archivo'
        ];
        
        return $errors[$errorCode] ?? 'Error desconocido';
    }
    
    private function resizeImage($filePath, $maxWidth, $maxHeight) {
        list($width, $height, $type) = getimagesize($filePath);
        
        if ($width <= $maxWidth && $height <= $maxHeight) {
            return false; // No necesita redimensionar
        }
        
        $ratio = $width / $height;
        
        if ($maxWidth / $maxHeight > $ratio) {
            $newWidth = $maxHeight * $ratio;
            $newHeight = $maxHeight;
        } else {
            $newWidth = $maxWidth;
            $newHeight = $maxWidth / $ratio;
        }
        
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($filePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($filePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($filePath);
                break;
            default:
                return false;
        }
        
        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
        }
        
        // Redimensionar
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($thumb, $filePath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumb, $filePath, 9);
                break;
            case IMAGETYPE_GIF:
                imagegif($thumb, $filePath);
                break;
        }
        
        // Liberar memoria
        imagedestroy($source);
        imagedestroy($thumb);
        
        return true;
    }

    public function showDatosProfesor() {
        $pagina = 'Datos personales';
        require_once __DIR__ . '/../models/TeacherModel.php';
        require_once __DIR__ . '/../models/ClassModel.php';
        $classModel = new ClassModel();
        $teacherModel = new TeacherModel();

        $teacherData = $teacherModel->getTeacherByCedula($_SESSION['teacher_email']);
        $clases = $classModel->getClassesByTeacher($_SESSION['user_id']);
        $horarios = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];

        require_once '../frontend/views/teacher/panel.php';
    }

    public function edit() { //Falta completar
        $pagina = 'Editar mis datos';
        require_once __DIR__ . '/../models/TeacherModel.php';
        $teacherData = $teacherModel->getTeacherByCedula($_SESSION['teacher_email']);
    }
}
?> 