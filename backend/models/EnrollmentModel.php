<?php
class EnrollmentModel {
    private $conn;
    private $table_name = "Inscritos";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function enrollStudent($idEstudiante, $idClase, $idProfe) {
        // Verificar si ya está inscrito
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE idEstudiante_FK = :idE AND IdClase_FK = :idClase";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idE', $idEstudiante, PDO::PARAM_STR);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return false; // Ya está inscrito
        }
        
        // si no esta inscrito, mandarlo a pendientes ->
        $query = "INSERT INTO " . $this->table_name . " 
                  (idEstudiante_FK, IdClase_FK, idProfesor_FK, FechaIngreso, Estado)
                  VALUES 
                  (:idE, :idClase, :idP, NOW(), 'pendiente')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idE', $idEstudiante, PDO::PARAM_STR);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        $stmt->bindParam(':idP', $idProfe, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function acceptStudent($idEstudiante, $idClase) {
        $query = "UPDATE " . $this->table_name . "
                  SET Estado = 'activo'
                  WHERE idEstudiante_FK = :idE AND IdClase = :idClase";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idE', $idEstudiante, PDO::PARAM_STR);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getStudentEnrollments($correoEstudiante) {
        $query = "SELECT i.*, c.Materia, c.Descripcion as DescripcionClase, 
                         p.Nombre as ProfesorNombre, p.ApPaterno as ProfesorApellido,
                         p.IdProfesor, p.Especialidad, p.CalificacionPromedio
                  FROM Inscritos i
                  INNER JOIN Clases c ON i.IdClase_FK = c.IdClase
                  INNER JOIN Profesores p ON i.idProfesor_FK = p.IdProfesor
                  WHERE i.idEstudiante_FK = :correo
                  ORDER BY i.FechaIngreso DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correoEstudiante, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function isStudentEnrolled($correoEstudiante, $idClase) {
        $query = "SELECT * FROM Inscritos 
                  WHERE idEstudiante_FK = :correo AND IdClase_FK = :idClase AND Estado = 'activo'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correoEstudiante, PDO::PARAM_STR);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    public function cancelEnrollment($correoEstudiante, $idClase) {
        $query = "UPDATE Inscritos SET Estado = 'cancelado' 
                  WHERE idEstudiante_FK = :correo AND IdClase_FK = :idClase";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correoEstudiante, PDO::PARAM_STR);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        
        return $stmt->execute();
    }


}//Fin de clase
?>