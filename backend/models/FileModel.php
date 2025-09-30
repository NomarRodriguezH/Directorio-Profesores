<?php
class FileModel {
    private $conn;
    private $table_name = "archivos";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    
    public function uploadFile($data, $file) {
    $logMessage = "[" . date('Y-m-d H:i:s') . "] uploadFile iniciado\n";
    file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
    
    $errors = [];
    
    $fileProcess = $this->processUploadedFile($file);
    
    $logMessage = "[" . date('Y-m-d H:i:s') . "] fileProcess: " . print_r($fileProcess, true) . "\n";
    file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
    
    if (!$fileProcess['success']) {
        return ['success' => false, 'errors' => $fileProcess['errors']];
    }
    
    // Obtener el siguiente número de archivo para esta clase
    $nextFileNumber = $this->getNextFileNumber($data['idClase']);
    
    $logMessage = "[" . date('Y-m-d H:i:s') . "] nextFileNumber: $nextFileNumber\n";
    file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
    
    $query = "INSERT INTO Archivos 
              (IdClase_FK, IdProfesor_FK, NoArchivo, NombreArchivo, 
               ArchivoURL, TipoArchivo, Tamanio, Descripcion, fechaSubida)
              VALUES 
              (:idClase, :idProfesor, :noArchivo, :nombreArchivo, 
               :archivoURL, :tipoArchivo, :tamanio, :descripcion, :fechaSubida)";
    
    $logMessage = "[" . date('Y-m-d H:i:s') . "] Query: $query\n";
    file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
    $hoy= date("Y-m-d H:i:s");

    try {
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':idClase', $data['idClase'], PDO::PARAM_INT);
        $stmt->bindParam(':idProfesor', $data['idProfesor'], PDO::PARAM_STR);
        $stmt->bindParam(':noArchivo', $nextFileNumber, PDO::PARAM_INT);
        $stmt->bindParam(':nombreArchivo', $fileProcess['fileName'], PDO::PARAM_STR);
        $stmt->bindParam(':archivoURL', $fileProcess['filePath'], PDO::PARAM_STR);
        $stmt->bindParam(':tipoArchivo', $fileProcess['fileType'], PDO::PARAM_STR);
        $stmt->bindParam(':tamanio', $fileProcess['fileSize'], PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
         $stmt->bindParam(':fechaSubida', $hoy, PDO::PARAM_STR);
        
        $result = $stmt->execute();
        
        $logMessage = "[" . date('Y-m-d H:i:s') . "] Execute result: " . ($result ? 'true' : 'false') . "\n";
        file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
        
        if ($result) {
            $lastId = $this->conn->lastInsertId();
            $logMessage = "[" . date('Y-m-d H:i:s') . "] lastInsertId: $lastId\n";
            file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
            return ['success' => true, 'fileId' => $lastId];
        } else {
            $errorInfo = $stmt->errorInfo();
            $logMessage = "[" . date('Y-m-d H:i:s') . "] Error info: " . print_r($errorInfo, true) . "\n";
            file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
            return ['success' => false, 'errors' => ['Error al guardar en la base de datos: ' . $errorInfo[2]]];
        }
    } catch (PDOException $e) {
        $logMessage = "[" . date('Y-m-d H:i:s') . "] PDOException: " . $e->getMessage() . "\n";
        file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
        return ['success' => false, 'errors' => ['Error de base de datos: ' . $e->getMessage()]];
    }
}


    public function getFilesByClass($idClase, $cedulaProfesor = null) {
        $query = "SELECT a.*, c.Materia, p.Nombre as ProfesorNombre, p.ApPaterno as ProfesorApellido
                  FROM " . $this->table_name . " a
                  INNER JOIN Clases c ON a.IdClase_FK = c.IdClase
                  INNER JOIN Profesores p ON a.IdProfesor_FK = p.IdProfesor
                  WHERE a.IdClase_FK = :idClase";
        
        if ($cedulaProfesor) {
            $query .= " AND a.IdProfesor_FK = :cedula";
        }
        
        $query .= " ORDER BY a.FechaSubida DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        
        if ($cedulaProfesor) {
            $stmt->bindParam(':cedula', $cedulaProfesor, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getFilesByTeacher($cedulaProfesor) {
        $query = "SELECT a.*, c.Materia, c.IdClase
                  FROM " . $this->table_name . " a
                  INNER JOIN Clases c ON a.IdClase_FK = c.IdClase
                  WHERE a.IdProfesor_FK = :cedula
                  ORDER BY c.Materia DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedulaProfesor, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    

    public function getFileById($idArchivo, $cedulaProfesor = null) {
        $query = "SELECT a.*, c.Materia, p.Nombre as ProfesorNombre, p.ApPaterno as ProfesorApellido
                  FROM " . $this->table_name . " a
                  INNER JOIN Clases c ON a.IdClase_FK = c.IdClase
                  INNER JOIN Profesores p ON a.IdProfesor_FK = p.id
                  WHERE a.IdArchivo = :idArchivo";
        
        if ($cedulaProfesor) {
            $query .= " AND a.IdProfesor_FK = :cedula";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idArchivo', $idArchivo, PDO::PARAM_INT);
        
        if ($cedulaProfesor) {
            $stmt->bindParam(':cedula', $cedulaProfesor, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetch();
    }
    


    public function deleteFile($idArchivo, $cedulaProfesor) {
        $file = $this->getFileById($idArchivo, $cedulaProfesor);
        
        if (!$file) {
            return false;
        }
        
        // Eliminar archivo físico
        if ($file['ArchivoURL'] && file_exists('../' . $file['ArchivoURL'])) {
            unlink('../' . $file['ArchivoURL']);
        }
        
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE IdArchivo = :idArchivo AND IdProfesor_FK = :cedula";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idArchivo', $idArchivo, PDO::PARAM_INT);
        $stmt->bindParam(':cedula', $cedulaProfesor, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    public function updateFileDescription($idArchivo, $cedulaProfesor, $descripcion) {
        $query = "UPDATE " . $this->table_name . " 
                  SET Descripcion = :descripcion 
                  WHERE IdArchivo = :idArchivo AND IdProfesor_FK = :cedula";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':idArchivo', $idArchivo, PDO::PARAM_INT);
        $stmt->bindParam(':cedula', $cedulaProfesor, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    private function processUploadedFile($file) {
    echo "<!-- DEBUG: processUploadedFile iniciado -->\n";
    $errors = [];
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Error al subir el archivo: " . $this->getUploadError($file['error']);
        return ['success' => false, 'errors' => $errors];
    }
    
    echo "<!-- DEBUG: Archivo subido sin errores -->\n";
    
    //  tamaño máximo 20MB
    $maxSize = 20 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        $errors[] = "El archivo no debe pesar más de 20MB";
        return ['success' => false, 'errors' => $errors];
    }
    
    echo "<!-- DEBUG: Tamaño válido = " . $file['size'] . " bytes -->\n";
    
    // Validar tipo de archivo
    $allowedTypes = [
        'application/pdf' => 'pdf',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.ms-powerpoint' => 'ppt',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        'text/plain' => 'txt',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'application/zip' => 'zip',
        'application/x-rar-compressed' => 'rar'
    ];
    
    $fileType = mime_content_type($file['tmp_name']);
    echo "<!-- DEBUG: fileType detectado = $fileType -->\n";
    
    if (!isset($allowedTypes[$fileType])) {
        $errors[] = "Tipo de archivo no permitido. Formatos aceptados: PDF, Word, Excel, PowerPoint, imágenes, ZIP, RAR, TXT";
        return ['success' => false, 'errors' => $errors];
    }
    
    echo "<!-- DEBUG: Tipo de archivo permitido -->\n";
    
    $uploadDir = '../frontend/assets/files/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
        echo "<!-- DEBUG: Directorio creado = $uploadDir -->\n";
    }
    
    // Generar nombre único
    $extension = $allowedTypes[$fileType];
    $fileName = pathinfo($file['name'], PATHINFO_FILENAME);
    $safeFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $fileName);
    $uniqueName = $safeFileName . '_' . time() . '_' . uniqid() . '.' . $extension;
    $targetPath = $uploadDir . $uniqueName;
    
    echo "<!-- DEBUG: targetPath = $targetPath -->\n";
    
    // Mover el archivo
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo "<!-- DEBUG: Archivo movido exitosamente -->\n";
        return [
            'success' => true,
            'fileName' => $fileName . '.' . $extension,
            'filePath' => 'frontend/assets/files/' . $uniqueName,
            'fileType' => $fileType,
            'fileSize' => $file['size']
        ];
    } else {
        $errors[] = "Error al guardar el archivo en el servidor";
        echo "<!-- DEBUG: Error moviendo archivo -->\n";
        return ['success' => false, 'errors' => $errors];
    }
}
    
   private function getNextFileNumber($idClase) {
    $query = "SELECT MAX(NoArchivo) as maxNumber 
              FROM Archivos 
              WHERE IdClase_FK = :idClase";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch();
    $nextNumber = ($result['maxNumber'] ? $result['maxNumber'] + 1 : 1);
    
    $logMessage = "[" . date('Y-m-d H:i:s') . "] getNextFileNumber: $nextNumber\n";
    file_put_contents('upload_debug.log', $logMessage, FILE_APPEND);
    
    return $nextNumber;
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
    
    public function getFileStats($cedulaProfesor) {
        $query = "SELECT 
                    COUNT(*) as totalArchivos,
                    SUM(Tamanio) as totalTamanio,
                    COUNT(DISTINCT IdClase_FK) as clasesConArchivos,
                    TipoArchivo,
                    COUNT(*) as cantidadPorTipo
                  FROM " . $this->table_name . " 
                  WHERE IdProfesor_FK = :cedula
                  GROUP BY TipoArchivo
                  ORDER BY cantidadPorTipo DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedulaProfesor, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getRecentFilesForStudent($correoEstudiante, $limit = 5) {
        $query = "SELECT DISTINCT a.*, c.Materia 
                  FROM Archivos a
                  INNER JOIN Clases c ON a.IdClase_FK = c.IdClase
                  INNER JOIN Inscritos i ON a.IdClase_FK = i.IdClase_FK
                  WHERE i.idEstudiante_FK = :correo AND i.Estado = 'activo'
                  ORDER BY a.FechaSubida DESC 
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correoEstudiante, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
} //FIN DE LA CLASE
?>