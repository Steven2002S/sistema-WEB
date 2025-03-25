<?php
class ReferenciaModel {
    private $db;
    
    /**
     * Constructor del modelo de referencia personal
     * @param Database $database Instancia de la clase Database
     */
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Obtener todas las referencias personales
     * @return array Lista de referencias personales
     */
    public function obtenerTodas() {
        $query = "SELECT r.*, 
                        CONCAT(t.nombres, ' ', t.apellidos) as titular_nombre
                  FROM referencias_personales r
                  JOIN titulares t ON r.titular_id = t.id
                  ORDER BY r.apellidos, r.nombres";
        
        $result = $this->db->getConnection()->query($query);
        $referencias = [];
        
        while ($row = $result->fetch_assoc()) {
            $referencias[] = $row;
        }
        
        return $referencias;
    }
    
    /**
     * Obtener una referencia personal por su ID
     * @param int $id ID de la referencia personal
     * @return array|bool Datos de la referencia personal o false si no existe
     */
    public function obtenerPorId($id) {
        $query = "SELECT r.*, 
                        CONCAT(t.nombres, ' ', t.apellidos) as titular_nombre
                  FROM referencias_personales r
                  JOIN titulares t ON r.titular_id = t.id
                  WHERE r.id = ?";
        
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
     * Obtener referencias personales por titular
     * @param int $titular_id ID del titular
     * @return array Lista de referencias personales de un titular
     */
    public function obtenerPorTitular($titular_id) {
        $query = "SELECT * FROM referencias_personales WHERE titular_id = ? ORDER BY apellidos, nombres";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $titular_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $referencias = [];
        
        while ($row = $result->fetch_assoc()) {
            $referencias[] = $row;
        }
        
        return $referencias;
    }
    
    /**
     * Crear una nueva referencia personal
     * @param array $datos Datos de la nueva referencia personal
     * @return bool|int ID de la nueva referencia personal o false en caso de error
     */
    public function crear($datos) {
        try {
            $query = "INSERT INTO referencias_personales (nombres, apellidos, direccion, 
                                                     email, celular, telefono_casa, 
                                                     empresa, cargo, telefono_trabajo, 
                                                     titular_id) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssssssssi", 
                $datos['nombres'], 
                $datos['apellidos'], 
                $datos['direccion'], 
                $datos['email'], 
                $datos['celular'], 
                $datos['telefono_casa'], 
                $datos['empresa'], 
                $datos['cargo'], 
                $datos['telefono_trabajo'], 
                $datos['titular_id']
            );
            
            if ($stmt->execute()) {
                return $stmt->insert_id;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Error al crear referencia personal: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar una referencia personal existente
     * @param int $id ID de la referencia personal a actualizar
     * @param array $datos Nuevos datos de la referencia personal
     * @return bool Resultado de la operación
     */
    public function actualizar($id, $datos) {
        try {
            $query = "UPDATE referencias_personales SET 
                        nombres = ?, 
                        apellidos = ?, 
                        direccion = ?, 
                        email = ?, 
                        celular = ?, 
                        telefono_casa = ?, 
                        empresa = ?, 
                        cargo = ?, 
                        telefono_trabajo = ?, 
                        titular_id = ? 
                      WHERE id = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssssssssii", 
                $datos['nombres'], 
                $datos['apellidos'], 
                $datos['direccion'], 
                $datos['email'], 
                $datos['celular'], 
                $datos['telefono_casa'], 
                $datos['empresa'], 
                $datos['cargo'], 
                $datos['telefono_trabajo'], 
                $datos['titular_id'],
                $id
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al actualizar referencia personal: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Eliminar una referencia personal
     * @param int $id ID de la referencia personal a eliminar
     * @return bool Resultado de la operación
     */
    public function eliminar($id) {
        try {
            $query = "DELETE FROM referencias_personales WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al eliminar referencia personal: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Eliminar todas las referencias personales de un titular
     * @param int $titular_id ID del titular
     * @return bool Resultado de la operación
     */
    public function eliminarPorTitular($titular_id) {
        try {
            $query = "DELETE FROM referencias_personales WHERE titular_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $titular_id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al eliminar referencias por titular: " . $e->getMessage());
            return false;
        }
    }
    /**
 * Obtener referencias asociadas a titulares creados por un usuario específico
 * @param int $usuario_id ID del usuario
 * @return array Lista de referencias
 */
public function obtenerPorUsuario($usuario_id) {
    $query = "SELECT r.*, 
                    CONCAT(t.nombres, ' ', t.apellidos) as titular_nombre
              FROM referencias_personales r
              JOIN titulares t ON r.titular_id = t.id
              WHERE t.created_by = ?
              ORDER BY r.apellidos, r.nombres";
    
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $referencias = [];
    
    while ($row = $result->fetch_assoc()) {
        $referencias[] = $row;
    }
    
    return $referencias;
}
}
?>