<?php
class ReciboModel {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Crear un nuevo recibo
     * @param array $datos Datos del recibo
     * @return int|bool ID del recibo creado o false en caso de error
     */
    public function crear($datos) {
        $query = "INSERT INTO recibos (contrato_id, recibo_por, responsable_id) VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("isi", $datos['contrato_id'], $datos['recibo_por'], $datos['responsable_id']);
        
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        
        return false;
    }
    
    /**
     * Obtener recibos por contrato
     * @param int $contrato_id ID del contrato
     * @return array Lista de recibos
     */
    public function obtenerPorContrato($contrato_id) {
        $query = "SELECT r.*, u.nombres AS responsable_nombres, u.apellidos AS responsable_apellidos
                  FROM recibos r
                  INNER JOIN usuarios u ON r.responsable_id = u.id
                  WHERE r.contrato_id = ?
                  ORDER BY r.created_at DESC";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $contrato_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $recibos = [];
        
        while ($row = $result->fetch_assoc()) {
            $recibos[] = $row;
        }
        
        return $recibos;
    }
    
    /**
     * Obtener recibos por usuario responsable
     * @param int $usuario_id ID del usuario responsable
     * @return array Lista de recibos
     */
    public function obtenerPorUsuario($usuario_id) {
        $query = "SELECT r.*, c.numero_contrato, c.fecha_emision, c.mes_pagado, c.cantidad_recibida,
                  t.nombres AS titular_nombres, t.apellidos AS titular_apellidos,
                  e.nombres AS estudiante_nombres, e.apellidos AS estudiante_apellidos
                  FROM recibos r
                  INNER JOIN contratos c ON r.contrato_id = c.id
                  INNER JOIN titulares t ON c.titular_id = t.id
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  WHERE r.responsable_id = ?
                  ORDER BY r.created_at DESC";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $recibos = [];
        
        while ($row = $result->fetch_assoc()) {
            $recibos[] = $row;
        }
        
        return $recibos;
    }
    
    /**
     * Obtener un recibo por ID
     * @param int $id ID del recibo
     * @return array|bool Datos del recibo o false si no existe
     */
    public function obtenerPorId($id) {
        $query = "SELECT r.*, c.numero_contrato, c.fecha_emision, c.mes_pagado, c.cantidad_recibida,
                  c.forma_pago, c.banco, c.organizacion,
                  t.nombres AS titular_nombres, t.apellidos AS titular_apellidos,
                  e.nombres AS estudiante_nombres, e.apellidos AS estudiante_apellidos,
                  u.nombres AS responsable_nombres, u.apellidos AS responsable_apellidos
                  FROM recibos r
                  INNER JOIN contratos c ON r.contrato_id = c.id
                  INNER JOIN titulares t ON c.titular_id = t.id
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  INNER JOIN usuarios u ON r.responsable_id = u.id
                  WHERE r.id = ?";
                  
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
     * Eliminar un recibo
     * @param int $id ID del recibo
     * @return bool True si se eliminó correctamente, false en caso contrario
     */
    public function eliminar($id) {
        $query = "DELETE FROM recibos WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
?>