<?php
class ContratoModel {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Crear un nuevo contrato
     * @param array $datos Datos del contrato
     * @return int|bool ID del contrato creado o false en caso de error
     */
    public function crear($datos) {
        // Generar número de contrato (formato 0001, 0002, etc.)
        $numero_contrato = $this->generarNumeroContrato($datos['verificado_por']);
        
        $query = "INSERT INTO contratos (
            numero_contrato, 
            fecha_emision, 
            mes_pagado, 
            forma_pago, 
            banco, 
            organizacion, 
            cantidad_recibida, 
            verificado_por, 
            ejecutivo, 
            titular_id, 
            estudiante_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "ssssssdiiis", 
            $numero_contrato,
            $datos['fecha_emision'],
            $datos['mes_pagado'],
            $datos['forma_pago'],
            $datos['banco'],
            $datos['organizacion'],
            $datos['cantidad_recibida'],
            $datos['verificado_por'],
            $datos['ejecutivo'],
            $datos['titular_id'],
            $datos['estudiante_id']
        );
        
        if ($stmt->execute()) {
            $contrato_id = $stmt->insert_id;
            
            // Incrementar consecutivo general
            $this->incrementarConsecutivoGeneral($datos['verificado_por']);
            
            return $contrato_id;
        }
        
        return false;
    }
    
    /**
     * Generar número de contrato
     * @param int $usuario_id ID del usuario
     * @return string Número de contrato generado
     */
    private function generarNumeroContrato($usuario_id) {
        // Obtener mes actual en formato YYYY-MM
        $mes_actual = date('Y-m');
        
        // Verificar si existe un consecutivo para este usuario y mes
        $query = "SELECT consecutivo FROM consecutivos_mensuales WHERE usuario_id = ? AND mes = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $usuario_id, $mes_actual);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Existe un consecutivo, incrementarlo
            $row = $result->fetch_assoc();
            $consecutivo = $row['consecutivo'] + 1;
            
            $query = "UPDATE consecutivos_mensuales SET consecutivo = ? WHERE usuario_id = ? AND mes = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iis", $consecutivo, $usuario_id, $mes_actual);
            $stmt->execute();
        } else {
            // No existe un consecutivo, crearlo con valor 1
            $consecutivo = 1;
            
            $query = "INSERT INTO consecutivos_mensuales (usuario_id, mes, consecutivo) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("isi", $usuario_id, $mes_actual, $consecutivo);
            $stmt->execute();
        }
        
        // Formatear el consecutivo con ceros a la izquierda (0001, 0002, etc.)
        return str_pad($consecutivo, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Incrementar consecutivo general para un usuario
     * @param int $usuario_id ID del usuario
     */
    private function incrementarConsecutivoGeneral($usuario_id) {
        // Verificar si existe un consecutivo general para este usuario
        $query = "SELECT consecutivo FROM consecutivos_generales WHERE usuario_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Existe un consecutivo, incrementarlo
            $row = $result->fetch_assoc();
            $consecutivo = $row['consecutivo'] + 1;
            
            $query = "UPDATE consecutivos_generales SET consecutivo = ? WHERE usuario_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $consecutivo, $usuario_id);
            $stmt->execute();
        } else {
            // No existe un consecutivo, crearlo con valor 1
            $consecutivo = 1;
            
            $query = "INSERT INTO consecutivos_generales (usuario_id, consecutivo) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $usuario_id, $consecutivo);
            $stmt->execute();
        }
    }
    
    /**
     * Obtener todos los contratos
     * @return array Lista de contratos
     */
    public function obtenerTodos() {
        $query = "SELECT c.*, 
                  t.nombres AS titular_nombres, t.apellidos AS titular_apellidos,
                  e.nombres AS estudiante_nombres, e.apellidos AS estudiante_apellidos,
                  u.nombres AS verificador_nombres, u.apellidos AS verificador_apellidos,
                  u2.nombres AS ejecutivo_nombres, u2.apellidos AS ejecutivo_apellidos
                  FROM contratos c
                  INNER JOIN titulares t ON c.titular_id = t.id
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  INNER JOIN usuarios u ON c.verificado_por = u.id
                  INNER JOIN usuarios u2 ON c.ejecutivo = u2.id
                  ORDER BY c.created_at DESC";
                  
        $result = $this->db->getConnection()->query($query);
        $contratos = [];
        
        while ($row = $result->fetch_assoc()) {
            $contratos[] = $row;
        }
        
        return $contratos;
    }
    
    /**
     * Obtener contratos por usuario
     * @param int $usuario_id ID del usuario
     * @return array Lista de contratos del usuario
     */
    public function obtenerPorUsuario($usuario_id) {
        $query = "SELECT c.*, 
                  t.nombres AS titular_nombres, t.apellidos AS titular_apellidos,
                  e.nombres AS estudiante_nombres, e.apellidos AS estudiante_apellidos
                  FROM contratos c
                  INNER JOIN titulares t ON c.titular_id = t.id
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  WHERE c.verificado_por = ? OR c.ejecutivo = ?
                  ORDER BY c.created_at DESC";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $usuario_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $contratos = [];
        
        while ($row = $result->fetch_assoc()) {
            $contratos[] = $row;
        }
        
        return $contratos;
    }
    
    /**
     * Obtener un contrato por ID
     * @param int $id ID del contrato
     * @return array|bool Datos del contrato o false si no existe
     */
    public function obtenerPorId($id) {
        $query = "SELECT c.*, 
                  t.nombres AS titular_nombres, t.apellidos AS titular_apellidos,
                  e.nombres AS estudiante_nombres, e.apellidos AS estudiante_apellidos,
                  u.nombres AS verificador_nombres, u.apellidos AS verificador_apellidos,
                  u2.nombres AS ejecutivo_nombres, u2.apellidos AS ejecutivo_apellidos
                  FROM contratos c
                  INNER JOIN titulares t ON c.titular_id = t.id
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  INNER JOIN usuarios u ON c.verificado_por = u.id
                  INNER JOIN usuarios u2 ON c.ejecutivo = u2.id
                  WHERE c.id = ?";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return false;
    }
    
    /**
     * Actualizar un contrato existente
     * @param int $id ID del contrato
     * @param array $datos Datos del contrato a actualizar
     * @return bool True si se actualizó correctamente, false en caso contrario
     */
    public function actualizar($id, $datos) {
        $query = "UPDATE contratos SET 
                  fecha_emision = ?,
                  mes_pagado = ?,
                  forma_pago = ?,
                  banco = ?,
                  organizacion = ?,
                  cantidad_recibida = ?,
                  titular_id = ?,
                  estudiante_id = ?
                  WHERE id = ?";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "sssssdiis", 
            $datos['fecha_emision'],
            $datos['mes_pagado'],
            $datos['forma_pago'],
            $datos['banco'],
            $datos['organizacion'],
            $datos['cantidad_recibida'],
            $datos['titular_id'],
            $datos['estudiante_id'],
            $id
        );
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar un contrato
     * @param int $id ID del contrato
     * @return bool True si se eliminó correctamente, false en caso contrario
     */
    public function eliminar($id) {
        // Primero eliminar los recibos asociados
        $query = "DELETE FROM recibos WHERE contrato_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Luego eliminar el contrato
        $query = "DELETE FROM contratos WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
