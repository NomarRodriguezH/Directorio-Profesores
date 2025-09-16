CREATE DATABASE IF NOT EXISTS dp 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE directorio_profesores;

CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Correo VARCHAR(100) NOT NULL UNIQUE,
    Nombre VARCHAR(50) NOT NULL,
    ApPaterno VARCHAR(50) NOT NULL,
    ApMaterno VARCHAR(50),
    Celular VARCHAR(15),
    FotoURL VARCHAR(255),
    PasswordHash VARCHAR(255) NOT NULL,
    FechaRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Activo TINYINT(1) DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE Profesores (
    IdProfesor INT AUTO_INCREMENT PRIMARY KEY,  
    Correo VARCHAR(100) NOT NULL UNIQUE,        
    Nombre VARCHAR(50) NOT NULL,
    ApPaterno VARCHAR(50) NOT NULL,
    ApMaterno VARCHAR(50),
    Especialidad VARCHAR(100) NOT NULL,
    Celular VARCHAR(15) NOT NULL,
    CedulaP VARCHAR(100) NOT NULL UNIQUE,
    FotoURL VARCHAR(255),
    Descripcion TEXT,
    PrecioMin DECIMAL(10,2) NOT NULL,
    PrecioMax DECIMAL(10,2) NOT NULL,
    Estado VARCHAR(50) NOT NULL,
    Delegacion VARCHAR(100) NOT NULL,
    CP VARCHAR(10) NOT NULL,
    Colonia VARCHAR(100) NOT NULL,
    Calle VARCHAR(150) NOT NULL,
    NoExt VARCHAR(10),
    NoInt VARCHAR(10),
    FechaIngreso DATE NOT NULL,
    UltimaVez TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CalificacionPromedio DECIMAL(3,2) DEFAULT 0.00,
    TotalCalificaciones INT DEFAULT 0,
    Activo TINYINT(1) DEFAULT 1,
    INDEX idx_correo (Correo), 
    INDEX idx_nombre_completo (Nombre, ApPaterno, ApMaterno)
) ENGINE=InnoDB;

CREATE TABLE Clases (
    IdClase INT AUTO_INCREMENT PRIMARY KEY,
    Materia VARCHAR(100) NOT NULL,
    IdProfesor_FK INT NOT NULL, 
    -- Horarios por día
    LuHI TIME, LuHF TIME,
    MaHI TIME, MaHF TIME,
    MiHI TIME, MiHF TIME,
    JuHI TIME, JuHF TIME,
    ViHI TIME, ViHF TIME,
    SaHI TIME, SaHF TIME,
    DoHI TIME, DoHF TIME,
    Descripcion TEXT,
    Nivel VARCHAR(50),
    Modalidad VARCHAR(50),
    MaxEstudiantes INT DEFAULT 1,
    Activo TINYINT(1) DEFAULT 1,
    FechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (IdProfesor_FK) REFERENCES Profesores(IdProfesor) ON DELETE CASCADE  -- Actualizado a IdProfesor
) ENGINE=InnoDB;


CREATE TABLE Inscritos (
    Correo_FK VARCHAR(100) NOT NULL,
    IdClase_FK INT NOT NULL,
    IdProfesor_FK INT NOT NULL, 
    FechaIngreso TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CalificacionPersonal DECIMAL(3,2) DEFAULT NULL,
    Comentario TEXT,
    FechaCalificacion TIMESTAMP NULL,
    Estado ENUM('activo', 'completado', 'cancelado') DEFAULT 'activo',
    PRIMARY KEY (Correo_FK, IdClase_FK),
    FOREIGN KEY (Correo_FK) REFERENCES Usuarios(Correo) ON DELETE CASCADE,
    FOREIGN KEY (IdClase_FK) REFERENCES Clases(IdClase) ON DELETE CASCADE,
    FOREIGN KEY (IdProfesor_FK) REFERENCES Profesores(IdProfesor) ON DELETE CASCADE  -- Actualizado a IdProfesor
) ENGINE=InnoDB;

CREATE TABLE Archivos (
    IdArchivo INT AUTO_INCREMENT PRIMARY KEY,
    IdClase_FK INT NOT NULL,
    IdProfesor_FK INT NOT NULL,
    NoArchivo INT NOT NULL,
    NombreArchivo VARCHAR(255) NOT NULL,
    ArchivoURL VARCHAR(255) NOT NULL,
    TipoArchivo VARCHAR(50),
    Tamanio BIGINT,
    FechaSubida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Descripcion TEXT,
    FOREIGN KEY (IdClase_FK) REFERENCES Clases(IdClase) ON DELETE CASCADE,
    FOREIGN KEY (IdProfesor_FK) REFERENCES Profesores(IdProfesor) ON DELETE CASCADE,  -- Actualizado a IdProfesor
    UNIQUE KEY uk_archivo_clase (IdClase_FK, NoArchivo)
) ENGINE=InnoDB;


ALTER TABLE Usuarios 
ADD INDEX idx_correo_fk (Correo),
ADD INDEX idx_nombre_completo_fk (Nombre, ApPaterno, ApMaterno);

ALTER TABLE Profesores
ADD INDEX idx_especialidad (Especialidad),
ADD INDEX idx_ubicacion (Estado, Delegacion),
ADD INDEX idx_precios (PrecioMin, PrecioMax),
ADD INDEX idx_correo_fk (Correo),
ADD INDEX idx_nombre_completo_fk (Nombre, ApPaterno, ApMaterno);

ALTER TABLE Clases
ADD INDEX idx_materia_fk (Materia),
ADD INDEX idx_profesor_fk (IdProfesor_FK);

ALTER TABLE Inscritos
ADD INDEX idx_calificacion_fk (CalificacionPersonal),
ADD INDEX idx_estado_fk (Estado),
ADD INDEX idx_fecha_ingreso_fk (FechaIngreso);

ALTER TABLE Archivos
ADD INDEX idx_clase_fk (IdClase_FK),
ADD INDEX idx_profesor_fk (IdProfesor_FK),
ADD INDEX idx_tipo_archivo_fk (TipoArchivo);

DELIMITER //
CREATE TRIGGER after_inscritos_update
AFTER UPDATE ON Inscritos
FOR EACH ROW
BEGIN
    IF NEW.CalificacionPersonal IS NOT NULL AND OLD.CalificacionPersonal IS NULL THEN
        UPDATE Profesores 
        SET TotalCalificaciones = TotalCalificaciones + 1,
            CalificacionPromedio = (
                (CalificacionPromedio * (TotalCalificaciones - 1)) + NEW.CalificacionPersonal
            ) / TotalCalificaciones
        WHERE IdProfesor = NEW.IdProfesor_FK;
    END IF;
END;
//
DELIMITER ;
