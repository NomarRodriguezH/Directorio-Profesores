<?php
class ClassModel {
    private $conn;
    private $table_name = "Clases";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function getClassesByTeacher($id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE idProfesor_FK = :id AND Activo = 1 
                  ORDER BY Materia";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getClassById($id) {
        $query = "SELECT c.*, p.Nombre, p.ApPaterno, p.ApMaterno 
                  FROM " . $this->table_name . " c
                  INNER JOIN Profesores p ON c.IdProfesor_FK = p.IdProfesor
                  WHERE c.IdClase = :id AND c.Activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function createClass($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (Materia, IdProfesor_FK, Descripcion, Nivel, Modalidad, 
                   LuHI, LuHF, MaHI, MaHF, MiHI, MiHF, JuHI, JuHF, 
                   ViHI, ViHF, SaHI, SaHF, DoHI, DoHF)
                  VALUES 
                  (:materia, :cedula, :descripcion, :nivel, :modalidad, 
                   :luHI, :luHF, :maHI, :maHF, :miHI, :miHF, :juHI, :juHF, 
                   :viHI, :viHF, :saHI, :saHF, :doHI, :doHF)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':materia', $data['materia'], PDO::PARAM_STR);
        $stmt->bindParam(':cedula', $data['cedula'], PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':nivel', $data['nivel'], PDO::PARAM_STR);
        $stmt->bindParam(':modalidad', $data['modalidad'], PDO::PARAM_STR);
        
        $horarios = ['lu', 'ma', 'mi', 'ju', 'vi', 'sa', 'do'];
        foreach ($horarios as $dia) {
            $stmt->bindParam(':' . $dia . 'HI', $data[$dia . 'HI'], PDO::PARAM_STR);
            $stmt->bindParam(':' . $dia . 'HF', $data[$dia . 'HF'], PDO::PARAM_STR);
        }
        
        return $stmt->execute();
    }

    public function updateClass($idClase, $data) {
        $query = "UPDATE " . $this->table_name . " SET 
                  Materia = :materia, Descripcion = :descripcion, Nivel = :nivel, 
                  Modalidad = :modalidad, MaxEstudiantes = :maxEstudiantes,
                  LuHI = :luHI, LuHF = :luHF, MaHI = :maHI, MaHF = :maHF,
                  MiHI = :miHI, MiHF = :miHF, JuHI = :juHI, JuHF = :juHF,
                  ViHI = :viHI, ViHF = :viHF, SaHI = :saHI, SaHF = :saHF,
                  DoHI = :doHI, DoHF = :doHF
                  WHERE IdClase = :idClase AND CedulaProfesional_FK = :cedula";
        
        $stmt = $this->conn->prepare($query);
        
        // Vincular parámetros básicos
        $stmt->bindParam(':materia', $data['materia'], PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':nivel', $data['nivel'], PDO::PARAM_STR);
        $stmt->bindParam(':modalidad', $data['modalidad'], PDO::PARAM_STR);
        $stmt->bindParam(':maxEstudiantes', $data['maxEstudiantes'], PDO::PARAM_INT);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        $stmt->bindParam(':cedula', $data['cedula'], PDO::PARAM_STR);
        
        $horarios = ['lu', 'ma', 'mi', 'ju', 'vi', 'sa', 'do'];
        foreach ($horarios as $dia) {
            $stmt->bindParam(':' . $dia . 'HI', $data[$dia . 'HI'], PDO::PARAM_STR);
            $stmt->bindParam(':' . $dia . 'HF', $data[$dia . 'HF'], PDO::PARAM_STR);
        }
        
        return $stmt->execute();
    }
    
    // Eliminar clase (soft delete)
    public function deleteClass($idClase, $cedulaProfesor) {
        $query = "UPDATE " . $this->table_name . " SET Activo = 0 
                  WHERE IdClase = :idClase AND CedulaProfesional_FK = :cedula";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        $stmt->bindParam(':cedula', $cedulaProfesor, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    public function isClassOwner($idClase, $cedulaProfesor) {
        $query = "SELECT IdClase FROM " . $this->table_name . " 
                  WHERE IdClase = :idClase AND CedulaProfesional_FK = :cedula AND Activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        $stmt->bindParam(':cedula', $cedulaProfesor, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    public function getClassEnrollments($idClase, $cedulaProfesor) {
        $query = "SELECT u.*, i.FechaIngreso, i.Estado, i.CalificacionPersonal, i.Comentario
                  FROM Inscritos i
                  INNER JOIN Usuarios u ON i.Correo_FK = u.Correo
                  WHERE i.IdClase_FK = :idClase AND i.CedulaProfesor_FK = :cedula
                  ORDER BY i.FechaIngreso DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        $stmt->bindParam(':cedula', $cedulaProfesor, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getEnrollmentCount($idClase) {
        $query = "SELECT COUNT(*) as total FROM Inscritos 
                  WHERE IdClase_FK = :idClase AND Estado = 'activo'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch()['total'];
    }

}// FIN DE LA CLASE
?>