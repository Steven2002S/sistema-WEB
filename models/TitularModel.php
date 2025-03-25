<?php
class TitularModel {
    private $db;
    
    /**
     * Constructor del modelo de titular
     * @param Database $database Instancia de la clase Database
     */
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Obtener todos los titulares
     * @return array Lista de titulares
     */
    public function obtenerTodos() {
        $query = "SELECT t.*, 
                        CONCAT(u.nombres, ' ', u.apellidos) as creado_por 
                  FROM titulares t
                  JOIN usuarios u ON t.created_by = u.id
                  ORDER BY t.fecha_registro DESC";
        
        $result = $this->db->getConnection()->query($query);
        $titulares = [];
        
        while ($row = $result->fetch_assoc()) {
            $titulares[] = $row;
        }
        
        return $titulares;
    }
    
    /**
     * Obtener un titular por su ID
     * @param int $id ID del titular
     * @return array|bool Datos del titular o false si no existe
     */
    public function obtenerPorId($id) {
        $query = "SELECT t.*, 
                        CONCAT(u.nombres, ' ', u.apellidos) as creado_por 
                  FROM titulares t
                  JOIN usuarios u ON t.created_by = u.id
                  WHERE t.id = ?";
        
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
     * Verificar si existe un titular con la cédula proporcionada
     * @param string $cedula Cédula a verificar
     * @param int $id_excluir ID del titular a excluir de la verificación (para edición)
     * @return bool True si existe, false en caso contrario
     */
    public function existeCedula($cedula, $id_excluir = null) {
        $query = "SELECT COUNT(*) as total FROM titulares WHERE cedula = ?";
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
     * Crear un nuevo titular
     * @param array $datos Datos del nuevo titular
     * @param int $usuario_id ID del usuario que crea el titular
     * @return bool|int ID del nuevo titular o false en caso de error
     */
    public function crear($datos, $usuario_id) {
        try {
            // Verificar si ya existe un titular con la misma cédula
            if ($this->existeCedula($datos['cedula'])) {
                return false;
            }
            
            $query = "INSERT INTO titulares (cedula, nombres, apellidos, direccion, email, 
                                          empresa, celular, telefono_casa, cargo, 
                                          telefono_trabajo, created_by) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssssssssi", 
                $datos['cedula'], 
                $datos['nombres'], 
                $datos['apellidos'], 
                $datos['direccion'], 
                $datos['email'], 
                $datos['empresa'], 
                $datos['celular'], 
                $datos['telefono_casa'], 
                $datos['cargo'], 
                $datos['telefono_trabajo'], 
                $usuario_id
            );
            
            if ($stmt->execute()) {
                return $stmt->insert_id;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Error al crear titular: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar un titular existente
     * @param int $id ID del titular a actualizar
     * @param array $datos Nuevos datos del titular
     * @return bool Resultado de la operación
     */
    public function actualizar($id, $datos) {
        try {
            // Verificar si ya existe otro titular con la misma cédula
            if ($this->existeCedula($datos['cedula'], $id)) {
                return false;
            }
            
            $query = "UPDATE titulares SET 
                        cedula = ?, 
                        nombres = ?, 
                        apellidos = ?, 
                        direccion = ?, 
                        email = ?, 
                        empresa = ?, 
                        celular = ?, 
                        telefono_casa = ?, 
                        cargo = ?, 
                        telefono_trabajo = ? 
                      WHERE id = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssssssssi", 
                $datos['cedula'], 
                $datos['nombres'], 
                $datos['apellidos'], 
                $datos['direccion'], 
                $datos['email'], 
                $datos['empresa'], 
                $datos['celular'], 
                $datos['telefono_casa'], 
                $datos['cargo'], 
                $datos['telefono_trabajo'], 
                $id
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al actualizar titular: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Eliminar un titular y todos sus datos relacionados
     * @param int $id ID del titular a eliminar
     * @return bool Resultado de la operación
     */
    public function eliminar($id) {
        try {
            // Iniciar transacción
            $this->db->getConnection()->begin_transaction();
            
            // Eliminar estudiantes asociados al titular
            $query = "DELETE FROM estudiantes WHERE titular_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            // Eliminar referencias personales asociadas al titular
            $query = "DELETE FROM referencias_personales WHERE titular_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            // Eliminar el titular
            $query = "DELETE FROM titulares WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $resultado = $stmt->execute();
            
            // Confirmar la transacción si todo fue exitoso
            if ($resultado) {
                $this->db->getConnection()->commit();
                return true;
            } else {
                $this->db->getConnection()->rollback();
                return false;
            }
        } catch (Exception $e) {
            // Si ocurre un error, revertir la transacción
            $this->db->getConnection()->rollback();
            error_log("Error al eliminar titular en cascada: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Buscar titulares por término de búsqueda
     * @param string $termino Término de búsqueda
     * @return array Lista de titulares que coinciden con el término
     */
    public function buscar($termino) {
        $termino = "%$termino%";
        
        $query = "SELECT t.*, 
                        CONCAT(u.nombres, ' ', u.apellidos) as creado_por 
                  FROM titulares t
                  JOIN usuarios u ON t.created_by = u.id
                  WHERE t.cedula LIKE ? 
                     OR t.nombres LIKE ? 
                     OR t.apellidos LIKE ?
                     OR t.email LIKE ?
                  ORDER BY t.fecha_registro DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssss", $termino, $termino, $termino, $termino);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $titulares = [];
        
        while ($row = $result->fetch_assoc()) {
            $titulares[] = $row;
        }
        
        return $titulares;
    }
    
    /**
     * Obtener titulares creados por un usuario específico
     * @param int $usuario_id ID del usuario que creó los titulares
     * @return array Lista de titulares
     */
    public function obtenerPorUsuario($usuario_id) {
        $query = "SELECT t.*, 
                        CONCAT(u.nombres, ' ', u.apellidos) as creado_por 
                  FROM titulares t
                  JOIN usuarios u ON t.created_by = u.id
                  WHERE t.created_by = ?
                  ORDER BY t.fecha_registro DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $titulares = [];
        
        while ($row = $result->fetch_assoc()) {
            $titulares[] = $row;
        }
        
        return $titulares;
    }
}
?>