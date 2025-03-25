<?php
class ConsecutivoModel {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Obtener consecutivo mensual de un usuario
     * @param int $usuario_id ID del usuario
     * @param string $mes Mes en formato YYYY-MM
     * @return int Consecutivo mensual
     */
    public function obtenerConsecutivoMensual($usuario_id, $mes = null) {
        if ($mes === null) {
            $mes = date('Y-m');
        }
        
        $query = "SELECT consecutivo FROM consecutivos_mensuales WHERE usuario_id = ? AND mes = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $usuario_id, $mes);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return (int)$row['consecutivo'];
        }
        
        return 0;
    }
    
    /**
     * Obtener consecutivo general de un usuario
     * @param int $usuario_id ID del usuario
     * @return int Consecutivo general
     */
    public function obtenerConsecutivoGeneral($usuario_id) {
        $query = "SELECT consecutivo FROM consecutivos_generales WHERE usuario_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return (int)$row['consecutivo'];
        }
        
        return 0;
    }
    
    /**
     * Obtener historial de consecutivos mensuales de un usuario
     * @param int $usuario_id ID del usuario
     * @return array Historial de consecutivos mensuales
     */
    public function obtenerHistorialConsecutivosMensuales($usuario_id) {
        $query = "SELECT mes, consecutivo FROM consecutivos_mensuales 
                  WHERE usuario_id = ? 
                  ORDER BY mes DESC";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $consecutivos = [];
        
        while ($row = $result->fetch_assoc()) {
            $consecutivos[] = $row;
        }
        
        return $consecutivos;
    }
    
    /**
     * Obtener todos los consecutivos generales con información de usuarios
     * @return array Lista de consecutivos generales con datos de usuarios
     */
    public function obtenerTodosConsecutivosGenerales() {
        $query = "SELECT cg.*, u.nombres, u.apellidos, u.correo, u.cedula
                  FROM consecutivos_generales cg
                  INNER JOIN usuarios u ON cg.usuario_id = u.id
                  ORDER BY cg.consecutivo DESC";
                  
        $result = $this->db->getConnection()->query($query);
        $consecutivos = [];
        
        while ($row = $result->fetch_assoc()) {
            $consecutivos[] = $row;
        }
        
        return $consecutivos;
    }
}
