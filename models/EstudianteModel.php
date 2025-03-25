<?php
class EstudianteModel {
    private $db;
    
    /**
     * Constructor del modelo de estudiante
     * @param Database $database Instancia de la clase Database
     */
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Obtener todos los estudiantes
     * @return array Lista de estudiantes
     */
    public function obtenerTodos() {
        $query = "SELECT e.*, 
                        CONCAT(t.nombres, ' ', t.apellidos) as titular_nombre,
                        t.cedula as titular_cedula,
                        c.nombre as curso_nombre
                  FROM estudiantes e
                  JOIN titulares t ON e.titular_id = t.id
                  JOIN cursos c ON e.curso_id = c.id
                  ORDER BY e.apellidos, e.nombres";
        
        $result = $this->db->getConnection()->query($query);
        $estudiantes = [];
        
        while ($row = $result->fetch_assoc()) {
            $estudiantes[] = $row;
        }
        
        return $estudiantes;
    }
    
    /**
     * Obtener un estudiante por su ID
     * @param int $id ID del estudiante
     * @return array|bool Datos del estudiante o false si no existe
     */
    public function obtenerPorId($id) {
        $query = "SELECT e.*, 
                        CONCAT(t.nombres, ' ', t.apellidos) as titular_nombre,
                        t.cedula as titular_cedula,
                        c.nombre as curso_nombre
                  FROM estudiantes e
                  JOIN titulares t ON e.titular_id = t.id
                  JOIN cursos c ON e.curso_id = c.id
                  WHERE e.id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }
        
        return false;
    }
    
    /**
     * Obtener estudiantes por titular
     * @param int $titular_id ID del titular
     * @return array Lista de estudiantes de un titular
     */
    public function obtenerPorTitular($titular_id) {
        $query = "SELECT e.*, 
                        c.nombre as curso_nombre
                  FROM estudiantes e
                  JOIN cursos c ON e.curso_id = c.id
                  WHERE e.titular_id = ?
                  ORDER BY e.apellidos, e.nombres";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $titular_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $estudiantes = [];
        
        while ($row = $result->fetch_assoc()) {
            $estudiantes[] = $row;
        }
        
        return $estudiantes;
    }
    
    /**
     * Verificar si existe un estudiante con la cédula proporcionada
     * @param string $cedula Cédula a verificar
     * @param int $id_excluir ID del estudiante a excluir de la verificación (para edición)
     * @return bool True si existe, false en caso contrario
     */
    public function existeCedula($cedula, $id_excluir = null) {
        $query = "SELECT COUNT(*) as total FROM estudiantes WHERE cedula = ?";
        $params = [$cedula];
        $types = "s";
        
        if ($id_excluir) {
            $query .= " AND id != ?";
            $params[] = $id_excluir;
            $types .= "i";
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $count = $result->fetch_assoc()['total'];
        
        return $count > 0;
    }
    
    /**
     * Crear un nuevo estudiante
     * @param array $datos Datos del nuevo estudiante
     * @return bool|int ID del nuevo estudiante o false en caso de error
     */
    public function crear($datos) {
        try {
            // Verificar si ya existe un estudiante con la misma cédula
            if (!empty($datos['cedula']) && $this->existeCedula($datos['cedula'])) {
                return false;
            }
            
            $query = "INSERT INTO estudiantes (cedula, nombres, apellidos, edad, 
                                            curso_id, talla, titular_id) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssisii", 
                $datos['cedula'], 
                $datos['nombres'], 
                $datos['apellidos'], 
                $datos['edad'], 
                $datos['curso_id'], 
                $datos['talla'], 
                $datos['titular_id']
            );
            
            if ($stmt->execute()) {
                return $stmt->insert_id;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Error al crear estudiante: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar un estudiante existente
     * @param int $id ID del estudiante a actualizar
     * @param array $datos Nuevos datos del estudiante
     * @return bool Resultado de la operación
     */
    public function actualizar($id, $datos) {
        try {
            // Verificar si ya existe otro estudiante con la misma cédula
            if (!empty($datos['cedula']) && $this->existeCedula($datos['cedula'], $id)) {
                return false;
            }
            
            $query = "UPDATE estudiantes SET 
                        cedula = ?, 
                        nombres = ?, 
                        apellidos = ?, 
                        edad = ?, 
                        curso_id = ?, 
                        talla = ?, 
                        titular_id = ? 
                      WHERE id = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssisiii", 
                $datos['cedula'], 
                $datos['nombres'], 
                $datos['apellidos'], 
                $datos['edad'], 
                $datos['curso_id'], 
                $datos['talla'], 
                $datos['titular_id'],
                $id
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al actualizar estudiante: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Eliminar un estudiante
     * @param int $id ID del estudiante a eliminar
     * @return bool Resultado de la operación
     */
    public function eliminar($id) {
        try {
            $query = "DELETE FROM estudiantes WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al eliminar estudiante: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Buscar estudiantes por término de búsqueda
     * @param string $termino Término de búsqueda
     * @return array Lista de estudiantes que coinciden con el término
     */
    public function buscar($termino) {
        $termino = "%$termino%";
        
        $query = "SELECT e.*, 
                        CONCAT(t.nombres, ' ', t.apellidos) as titular_nombre,
                        t.cedula as titular_cedula,
                        c.nombre as curso_nombre
                  FROM estudiantes e
                  JOIN titulares t ON e.titular_id = t.id
                  JOIN cursos c ON e.curso_id = c.id
                  WHERE e.cedula LIKE ? 
                     OR e.nombres LIKE ? 
                     OR e.apellidos LIKE ?
                     OR t.cedula LIKE ?
                     OR t.nombres LIKE ?
                     OR t.apellidos LIKE ?
                     OR c.nombre LIKE ?
                  ORDER BY e.apellidos, e.nombres";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssssss", $termino, $termino, $termino, $termino, $termino, $termino, $termino);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $estudiantes = [];
        
        while ($row = $result->fetch_assoc()) {
            $estudiantes[] = $row;
        }
        
        return $estudiantes;
    }
    
    /**
     * Obtener estudiantes por curso
     * @param int $curso_id ID del curso
     * @return array Lista de estudiantes en un curso
     */
    public function obtenerPorCurso($curso_id) {
        $query = "SELECT e.*, 
                        CONCAT(t.nombres, ' ', t.apellidos) as titular_nombre,
                        t.cedula as titular_cedula
                  FROM estudiantes e
                  JOIN titulares t ON e.titular_id = t.id
                  WHERE e.curso_id = ?
                  ORDER BY e.apellidos, e.nombres";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $curso_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $estudiantes = [];
        
        while ($row = $result->fetch_assoc()) {
            $estudiantes[] = $row;
        }
        
        return $estudiantes;
    }
    
    /**
     * Obtener estudiantes asociados a titulares creados por un usuario específico
     * @param int $usuario_id ID del usuario
     * @return array Lista de estudiantes
     */
    public function obtenerPorUsuario($usuario_id) {
        $query = "SELECT e.*, 
                    c.nombre as curso_nombre,
                    t.cedula as titular_cedula,
                    t.fecha_registro as titular_fecha_registro
              FROM estudiantes e
              JOIN titulares t ON e.titular_id = t.id
              JOIN cursos c ON e.curso_id = c.id
              WHERE t.created_by = ?
              ORDER BY t.fecha_registro DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $estudiantes = [];
        
        while ($row = $result->fetch_assoc()) {
            $estudiantes[] = $row;
        }
        
        return $estudiantes;
    }
}
?>