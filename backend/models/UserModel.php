<?php
class UserModel {
    private $conn;
    private $table_name = "estudiantes";
    private $table_name2 = "profesores";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE Correo = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    public function createUser($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (Correo, Nombre, ApPaterno, ApMaterno, Celular, PasswordHash)
                  VALUES 
                  (:correo, :nombre, :apPaterno, :apMaterno, :celular, :passwordHash)";
        
        $stmt = $this->conn->prepare($query);
        
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt->bindParam(':correo', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apPaterno', $data['apPaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':apMaterno', $data['apMaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':celular', $data['celular'], PDO::PARAM_STR);
        $stmt->bindParam(':passwordHash', $passwordHash, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

      
    public function getUserByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Correo = :email AND Activo = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function validateUser($email, $password) {
        $user = $this->getUserByEmail($email);
        
        if ($user && password_verify($password, $user['PasswordHash'])) {
            return $user;
        }
        
        return false;
    }
    
    public function updateUser($email, $data) {
        $query = "UPDATE " . $this->table_name . " SET 
                  Nombre = :nombre, ApPaterno = :apPaterno, ApMaterno = :apMaterno, 
                  Celular = :celular";
        
        if (!empty($data['password'])) {
            $query .= ", PasswordHash = :passwordHash";
        }
        
        $query .= " WHERE Correo = :email";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apPaterno', $data['apPaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':apMaterno', $data['apMaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':celular', $data['celular'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        
        // Solo si hay nueva contraseña
        if (!empty($data['password'])) {
            $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':passwordHash', $passwordHash, PDO::PARAM_STR);
        }
        
        return $stmt->execute();
    }



    //FUNCIONES PARA ADMINISTRADOR
     public function getAllUsers() {
        $query = "SELECT * FROM estudiantes ORDER BY FechaRegistro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function countAllUsers() {
        $query = "SELECT COUNT(*) as total FROM estudiantes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch()['total'];
    }
    
    public function countActiveUsers() {
        $query = "SELECT COUNT(*) as total FROM estudiantes WHERE Activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch()['total'];
    }
    
    // Cambiar estado de usuario
    public function toggleUserStatus($userId, $newStatus) {
        $query = "UPDATE estudiantes SET Activo = :activo WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':activo', $newStatus, PDO::PARAM_INT);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }



}// FIN DE LA CLASE
?>