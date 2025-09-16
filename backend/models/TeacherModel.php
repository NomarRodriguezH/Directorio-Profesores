<?php
class TeacherModel {
    private $conn;
    private $table_name = "Profesores";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function getAllTeachers() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Activo = 1 ORDER BY Nombre, ApPaterno";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getTeacherByCedula($cedula) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE correo = :cedula AND Activo = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function getTeachersBySpecialty($especialidad) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE Especialidad LIKE :especialidad AND Activo = 1 
                  ORDER BY CalificacionPromedio DESC";
        
        $stmt = $this->conn->prepare($query);
        $search_term = "%" . $especialidad . "%";
        $stmt->bindParam(':especialidad', $search_term, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getTeachersByLocation($estado, $delegacion = null) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE Estado = :estado AND Activo = 1";
        
        if ($delegacion) {
            $query .= " AND Delegacion = :delegacion";
        }
        
        $query .= " ORDER BY Nombre, ApPaterno";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        
        if ($delegacion) {
            $stmt->bindParam(':delegacion', $delegacion, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function createTeacher($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (idProfesor, Nombre, ApPaterno, ApMaterno, Especialidad, 
                   Celular, Correo, PrecioMin, PrecioMax, Estado, Delegacion, 
                   CP, Colonia, Calle, NoExt, NoInt, FechaIngreso, Descripcion)
                  VALUES 
                  (:cedula, :nombre, :apPaterno, :apMaterno, :especialidad, 
                   :celular, :correo, :precioMin, :precioMax, :estado, :delegacion, 
                   :cp, :colonia, :calle, :noExt, :noInt, :fechaIngreso, :descripcion)";
        
        $stmt = $this->conn->prepare($query);
        

        $stmt->bindParam(':cedula', $data['cedula'], PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apPaterno', $data['apPaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':apMaterno', $data['apMaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':especialidad', $data['especialidad'], PDO::PARAM_STR);
        $stmt->bindParam(':celular', $data['celular'], PDO::PARAM_STR);
        $stmt->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
        $stmt->bindParam(':precioMin', $data['precioMin'], PDO::PARAM_STR);
        $stmt->bindParam(':precioMax', $data['precioMax'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':delegacion', $data['delegacion'], PDO::PARAM_STR);
        $stmt->bindParam(':cp', $data['cp'], PDO::PARAM_STR);
        $stmt->bindParam(':colonia', $data['colonia'], PDO::PARAM_STR);
        $stmt->bindParam(':calle', $data['calle'], PDO::PARAM_STR);
        $stmt->bindParam(':noExt', $data['noExt'], PDO::PARAM_STR);
        $stmt->bindParam(':noInt', $data['noInt'], PDO::PARAM_STR);
        $stmt->bindParam(':fechaIngreso', $data['fechaIngreso'], PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    public function updateTeacher($cedula, $data) {
        $query = "UPDATE " . $this->table_name . " SET 
                  Nombre = :nombre, ApPaterno = :apPaterno, ApMaterno = :apMaterno, 
                  Especialidad = :especialidad, Celular = :celular, Correo = :correo, 
                  PrecioMin = :precioMin, PrecioMax = :precioMax, Estado = :estado, 
                  Delegacion = :delegacion, CP = :cp, Colonia = :colonia, Calle = :calle, 
                  NoExt = :noExt, NoInt = :noInt, Descripcion = :descripcion
                  WHERE CedulaProfesional = :cedula";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apPaterno', $data['apPaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':apMaterno', $data['apMaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':especialidad', $data['especialidad'], PDO::PARAM_STR);
        $stmt->bindParam(':celular', $data['celular'], PDO::PARAM_STR);
        $stmt->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
        $stmt->bindParam(':precioMin', $data['precioMin'], PDO::PARAM_STR);
        $stmt->bindParam(':precioMax', $data['precioMax'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':delegacion', $data['delegacion'], PDO::PARAM_STR);
        $stmt->bindParam(':cp', $data['cp'], PDO::PARAM_STR);
        $stmt->bindParam(':colonia', $data['colonia'], PDO::PARAM_STR);
        $stmt->bindParam(':calle', $data['calle'], PDO::PARAM_STR);
        $stmt->bindParam(':noExt', $data['noExt'], PDO::PARAM_STR);
        $stmt->bindParam(':noInt', $data['noInt'], PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    public function deleteTeacher($cedula) {
        $query = "UPDATE " . $this->table_name . " SET Activo = 0 WHERE idProfesor = :cedula";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        
        return $stmt->execute();
    }


    public function getTeachersWithFilters($especialidad, $estado, $delegacion, $precio_min, $precio_max, $busqueda, $limit, $offset) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Activo = 1";
        $count_query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE Activo = 1";
        $params = [];
        
        // Aplicar filtros
        if (!empty($especialidad)) {
            $query .= " AND Especialidad LIKE :especialidad";
            $count_query .= " AND Especialidad LIKE :especialidad";
            $params[':especialidad'] = "%" . $especialidad . "%";
        }
        
        if (!empty($estado)) {
            $query .= " AND Estado = :estado";
            $count_query .= " AND Estado = :estado";
            $params[':estado'] = $estado;
        }
        
        if (!empty($delegacion) && !empty($estado)) {
            $query .= " AND Delegacion = :delegacion";
            $count_query .= " AND Delegacion = :delegacion";
            $params[':delegacion'] = $delegacion;
        }
        
        if ($precio_min > 0) {
            $query .= " AND PrecioMax >= :precio_min";
            $count_query .= " AND PrecioMax >= :precio_min";
            $params[':precio_min'] = $precio_min;
        }
        
        if ($precio_max > 0) {
            $query .= " AND PrecioMin <= :precio_max";
            $count_query .= " AND PrecioMin <= :precio_max";
            $params[':precio_max'] = $precio_max;
        }
        
        if (!empty($busqueda)) {
            $query .= " AND (Nombre LIKE :busqueda OR ApPaterno LIKE :busqueda OR Especialidad LIKE :busqueda)";
            $count_query .= " AND (Nombre LIKE :busqueda OR ApPaterno LIKE :busqueda OR Especialidad LIKE :busqueda)";
            $params[':busqueda'] = "%" . $busqueda . "%";
        }
        
        $query .= " ORDER BY CalificacionPromedio DESC, Nombre, ApPaterno LIMIT :limit OFFSET :offset";
        
        //  consulta de conteo
        $stmt_count = $this->conn->prepare($count_query);
        foreach ($params as $key => $value) {
            $stmt_count->bindValue($key, $value);
        }
        $stmt_count->execute();
        $total = $stmt_count->fetch()['total'];
        
        //  consulta principal
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return [
            'profesores' => $stmt->fetchAll(),
            'total' => $total
        ];
    }
    
    public function getAllSpecialties() {
        $query = "SELECT DISTINCT Especialidad FROM " . $this->table_name . " WHERE Activo = 1 ORDER BY Especialidad";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getAllStates() {
        $query = "SELECT DISTINCT Estado FROM " . $this->table_name . " WHERE Activo = 1 ORDER BY Estado";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getAllDelegations($estado) {
        $query = "SELECT DISTINCT Delegacion FROM " . $this->table_name . " WHERE Estado = :estado AND Activo = 1 ORDER BY Delegacion";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getFeaturedTeachers($limit = 6) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE Activo = 1 AND CalificacionPromedio >= 4.0 
                  ORDER BY CalificacionPromedio DESC, TotalCalificaciones DESC 
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }



    public function cedulaExists($cedula) {
        $query = "SELECT idProfesor FROM " . $this->table_name . " WHERE idProfesor = :cedula LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    // Verificar si el correo ya existe
    public function emailExists($email) {
        $query = "SELECT idProfesor FROM " . $this->table_name . " WHERE Correo = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    // Crear nuevo profesor con manejo de foto
    public function createTeacherWithPhoto($data, $photoName) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (Correo, pass, Nombre, ApPaterno, ApMaterno, Especialidad, 
                   Celular, CedulaP, FotoURL, Descripcion, PrecioMin, PrecioMax, Estado, Delegacion, CP, Colonia, Calle, NoExt, NoInt, FechaIngreso, UltimaVez, CalificacionPromedio, TotalCalificaciones, Activo)
                  VALUES 
                  (:Correo, :pass, :Nombre, :ApPaterno, :ApMaterno, :Especialidad, 
                   :Celular, :CedulaP, :FotoURL, :Descripcion, :PrecioMin, :PrecioMax, :Estado, :Delegacion, :CP, :Colonia, :Calle, :NoExt, :NoInt, :FechaIngreso, :UltimaVez, :CalificacionPromedio, :TotalCalificaciones, :Activo)";
        
        $stmt = $this->conn->prepare($query);
        $cedula = !empty($data['cedula']) ? $data['cedula'] : null;
        $activo='1';
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        
       $stmt->bindParam(':Correo', $data['correo'], PDO::PARAM_STR);
        $stmt->bindParam(':pass', $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':Nombre', $data['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':ApPaterno', $data['apPaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':ApMaterno', $data['apMaterno'], PDO::PARAM_STR);
        $stmt->bindParam(':Especialidad', $data['especialidad'], PDO::PARAM_STR);
        $stmt->bindParam(':Celular', $data['celular'], PDO::PARAM_STR);
        $stmt->bindParam(':CedulaP', $cedula, PDO::PARAM_STR);
        $stmt->bindParam(':FotoURL', $photoName, PDO::PARAM_STR);
        $stmt->bindParam(':Descripcion', $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':PrecioMin', $data['precioMin'], PDO::PARAM_STR);
        $stmt->bindParam(':PrecioMax', $data['precioMax'], PDO::PARAM_STR);
        $stmt->bindParam(':Estado', $data['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':Delegacion', $data['delegacion'], PDO::PARAM_STR);
        $stmt->bindParam(':CP', $data['cp'], PDO::PARAM_STR);
        $stmt->bindParam(':Colonia', $data['colonia'], PDO::PARAM_STR);
        $stmt->bindParam(':Calle', $data['calle'], PDO::PARAM_STR);
        $stmt->bindParam(':NoExt', $data['noExt'], PDO::PARAM_STR);
        $stmt->bindParam(':NoInt', $data['noInt'], PDO::PARAM_STR);
        $stmt->bindParam(':FechaIngreso', $data['fechaIngreso'], PDO::PARAM_STR);
        $stmt->bindParam(':UltimaVez', $data['UltimaVez'], PDO::PARAM_STR);
        $stmt->bindParam(':CalificacionPromedio', $data['CalificacionPromedio'], PDO::PARAM_STR);
        $stmt->bindParam(':TotalCalificaciones', $data['TotalCalificaciones'], PDO::PARAM_STR);
        $stmt->bindParam(':Activo', $activo, PDO::PARAM_STR);


        return $stmt->execute();
    }
}// FIN DE LA CLASE 
?>