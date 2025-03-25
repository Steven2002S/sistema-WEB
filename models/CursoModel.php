<?php
class CursoModel {
    private $db;
    
    /**
     * Constructor del modelo de curso
     * @param Database $database Instancia de la clase Database
     */
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Obtener todos los cursos
     * @return array Lista de cursos
     */
    public function obtenerTodos() {
        $query = "SELECT c.*, s.nombre as creado_por 
                  FROM cursos c
                  JOIN superadmin s ON c.created_by = s.id
                  ORDER BY c.created_at DESC";
        
        $result = $this->db->getConnection()->query($query);
        $cursos = [];
        
        while ($row = $result->fetch_assoc()) {
            $cursos[] = $row;
        }
        
        return $cursos;
    }
    
    /**
     * Obtener un curso por su ID
     * @param int $id ID del curso
     * @return array|bool Datos del curso o false si no existe
     */
    public function obtenerPorId($id) {
        $query = "SELECT c.*, s.nombre as creado_por 
                  FROM cursos c
                  JOIN superadmin s ON c.created_by = s.id
                  WHERE c.id = ?";
        
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
     * Crear un nuevo curso
     * @param array $datos Datos del nuevo curso
     * @param int $superadmin_id ID del superadmin que crea el curso
     * @return bool|int ID del nuevo curso o false en caso de error
     */
    public function crear($datos, $superadmin_id) {
        // Sanear los datos de entrada
        $nombre = trim($datos['nombre']);
        $descripcion = trim($datos['descripcion'] ?? '');
        
        // Validar que el nombre no esté vacío
        if (empty($nombre)) {
            return false;
        }
        
        $query = "INSERT INTO cursos (nombre, descripcion, created_by) 
                  VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssi", $nombre, $descripcion, $superadmin_id);
        
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        
        return false;
    }
    
    /**
     * Actualizar un curso existente
     * @param int $id ID del curso a actualizar
     * @param array $datos Nuevos datos del curso
     * @return bool Resultado de la operación
     */
    public function actualizar($id, $datos) {
        // Sanear los datos de entrada
        $nombre = trim($datos['nombre']);
        $descripcion = trim($datos['descripcion'] ?? '');
        $estado = $datos['estado'] ?? null;
        
        // Validar que el nombre no esté vacío
        if (empty($nombre)) {
            return false;
        }
        
        // Preparar la consulta de actualización
        $query = "UPDATE cursos SET nombre = ?, descripcion = ?";
        $params = [$nombre, $descripcion];
        $types = "ss";
        
        // Incluir estado solo si se proporciona
        if ($estado) {
            if ($estado !== 'activo' && $estado !== 'inactivo') {
                return false;
            }
            $query .= ", estado = ?";
            $params[] = $estado;
            $types .= "s";
        }
        
        $query .= " WHERE id = ?";
        $params[] = $id;
        $types .= "i";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$params);
        
        return $stmt->execute();
    }
    
    /**
     * Cambiar estado de un curso (activar/desactivar)
     * @param int $id ID del curso
     * @param string $estado Nuevo estado ('activo' o 'inactivo')
     * @return bool Resultado de la operación
     */
    public function cambiarEstado($id, $estado) {
        if ($estado !== 'activo' && $estado !== 'inactivo') {
            return false;
        }
        
        $query = "UPDATE cursos SET estado = ? WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $estado, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar un curso
     * @param int $id ID del curso a eliminar
     * @return bool Resultado de la operación
     */
    public function eliminar($id) {
        $query = "DELETE FROM cursos WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
?>