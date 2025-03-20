<?php
class RolModel {
    private $db;
    
    /**
     * Constructor del modelo de rol
     * @param Database $database Instancia de la clase Database
     */
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Obtener todos los roles
     * @return array Lista de roles
     */
    public function obtenerTodos() {
        $query = "SELECT id, nombre, descripcion FROM roles";
        
        $result = $this->db->getConnection()->query($query);
        $roles = [];
        
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row;
        }
        
        return $roles;
    }
    
    /**
     * Obtener un rol por su ID
     * @param int $id ID del rol
     * @return array|bool Datos del rol o false si no existe
     */
    public function obtenerPorId($id) {
        $query = "SELECT id, nombre, descripcion FROM roles WHERE id = ?";
        
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
     * Crear un nuevo rol
     * @param array $datos Datos del nuevo rol
     * @return bool|int ID del nuevo rol o false en caso de error
     */
    public function crear($datos) {
        try {
            // Sanear los datos de entrada
            $nombre = trim($datos['nombre']);
            $descripcion = trim($datos['descripcion'] ?? '');
            
            // Validar que el nombre no esté vacío
            if (empty($nombre)) {
                error_log("Error: El nombre del rol no puede estar vacío");
                return false;
            }
            
            // Verificar que el nombre no exista ya en la base de datos
            $check_query = "SELECT COUNT(*) as total FROM roles WHERE nombre = ?";
            $check_stmt = $this->db->prepare($check_query);
            $check_stmt->bind_param("s", $nombre);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            $count = $result->fetch_assoc()['total'];
            
            if ($count > 0) {
                error_log("Error: Ya existe un rol con el nombre '{$nombre}'");
                return false;
            }
            
            // Preparar la consulta de inserción
            $query = "INSERT INTO roles (nombre, descripcion) VALUES (?, ?)";
            
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                error_log("Error en preparación de consulta SQL: " . $this->db->getConnection()->error);
                return false;
            }
            
            $stmt->bind_param("ss", $nombre, $descripcion);
            
            // Ejecutar la inserción
            $exito = $stmt->execute();
            
            if (!$exito) {
                error_log("Error en ejecución de consulta SQL: " . $stmt->error);
                return false;
            }
            
            $id = $stmt->insert_id;
            error_log("Rol creado exitosamente con ID: " . $id);
            return $id;
        } catch (Exception $e) {
            error_log("Excepción al crear rol: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar un rol existente
     * @param int $id ID del rol a actualizar
     * @param array $datos Nuevos datos del rol
     * @return bool Resultado de la operación
     */
    public function actualizar($id, $datos) {
        try {
            // Sanear los datos de entrada
            $nombre = trim($datos['nombre']);
            $descripcion = trim($datos['descripcion'] ?? '');
            
            // Validar que el nombre no esté vacío
            if (empty($nombre)) {
                error_log("Error: El nombre del rol no puede estar vacío");
                return false;
            }
            
            // Verificar que el nombre no exista ya para otro rol
            $check_query = "SELECT COUNT(*) as total FROM roles WHERE nombre = ? AND id != ?";
            $check_stmt = $this->db->prepare($check_query);
            $check_stmt->bind_param("si", $nombre, $id);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            $count = $result->fetch_assoc()['total'];
            
            if ($count > 0) {
                error_log("Error: Ya existe otro rol con el nombre '{$nombre}'");
                return false;
            }
            
            // Preparar la consulta de actualización
            $query = "UPDATE roles SET nombre = ?, descripcion = ? WHERE id = ?";
            
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                error_log("Error en preparación de consulta SQL: " . $this->db->getConnection()->error);
                return false;
            }
            
            $stmt->bind_param("ssi", $nombre, $descripcion, $id);
            
            // Ejecutar la actualización
            $exito = $stmt->execute();
            
            if (!$exito) {
                error_log("Error en ejecución de consulta SQL: " . $stmt->error);
                return false;
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Excepción al actualizar rol: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Eliminar un rol
     * @param int $id ID del rol a eliminar
     * @return bool Resultado de la operación
     */
    public function eliminar($id) {
        try {
            // Verificar si hay usuarios con este rol
            $query = "SELECT COUNT(*) as total FROM usuarios WHERE rol_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $total = $result->fetch_assoc()['total'];
            
            // Si hay usuarios con este rol, no permitir eliminación
            if ($total > 0) {
                error_log("No se puede eliminar el rol con ID {$id} porque tiene {$total} usuarios asociados");
                return false;
            }
            
            // Si no hay usuarios, eliminar el rol
            $query = "DELETE FROM roles WHERE id = ?";
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                error_log("Error en preparación de consulta SQL: " . $this->db->getConnection()->error);
                return false;
            }
            
            $stmt->bind_param("i", $id);
            
            // Ejecutar la eliminación
            $exito = $stmt->execute();
            
            if (!$exito) {
                error_log("Error en ejecución de consulta SQL: " . $stmt->error);
                return false;
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Excepción al eliminar rol: " . $e->getMessage());
            return false;
        }
    }
}
?>