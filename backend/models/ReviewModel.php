<?php
class ReviewModel {
    private $conn;
    private $table_name = "Inscritos";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function getReviewsByTeacher($id) {
        $query = "SELECT i.*, p.Nombre, p.ApPaterno, p.ApMaterno 
                  FROM " . $this->table_name . " i
                  INNER JOIN profesores p ON i.idProfesor_FK = p.IdProfesor
                  WHERE i.idProfesor_FK = :id 
                  AND i.CalificacionPersonal IS NOT NULL
                  ORDER BY i.FechaCalificacion DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getRatingStats($idProfesor) {
        $query = "SELECT 
                    COUNT(*) as total_reviews,
                    AVG(CalificacionPersonal) as average_rating,
                    COUNT(CASE WHEN CalificacionPersonal = 5 THEN 1 END) as five_stars,
                    COUNT(CASE WHEN CalificacionPersonal = 4 THEN 1 END) as four_stars,
                    COUNT(CASE WHEN CalificacionPersonal = 3 THEN 1 END) as three_stars,
                    COUNT(CASE WHEN CalificacionPersonal = 2 THEN 1 END) as two_stars,
                    COUNT(CASE WHEN CalificacionPersonal = 1 THEN 1 END) as one_stars
                  FROM " . $this->table_name . " 
                  WHERE idProfesor_FK = :idP 
                  AND CalificacionPersonal IS NOT NULL";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idP', $idProfesor, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function addReview($correoEstudiante, $idP, $idClase, $calificacion, $comentario) {
        $query = "UPDATE " . $this->table_name . " 
                  SET CalificacionPersonal = :calificacion, 
                      Comentario = :comentario,
                      FechaCalificacion = NOW()
                  WHERE Correo_FK = :correo 
                  AND idProfesor_FK = :idP
                  AND IdClase_FK = :idClase";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':calificacion', $calificacion, PDO::PARAM_STR);
        $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correoEstudiante, PDO::PARAM_STR);
        $stmt->bindParam(':idP', $idP, PDO::PARAM_STR);
        $stmt->bindParam(':idClase', $idClase, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>