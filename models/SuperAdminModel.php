<?php
class SuperAdminModel {
    private $db;
    
    /**
     * Constructor del modelo de superadmin
     * @param Database $database Instancia de la clase Database
     */
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Autenticar un superadmin por email y contraseña
     * @param string $email Email del superadmin
     * @param string $password Contraseña sin encriptar
     * @return array|bool Datos del superadmin o false si la autenticación falla
     */
    public function autenticar($email, $password) {
        // Preparar consulta
        $query = "SELECT id, nombre, email, password FROM superadmin WHERE email = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $superadmin = $result->fetch_assoc();
            
            // Verificar la contraseña
            if (password_verify($password, $superadmin['password'])) {
                // Eliminar la contraseña del array antes de devolverlo
                unset($superadmin['password']);
                return $superadmin;
            }
        }
        
        return false;
    }
    
    /**
     * Obtener un superadmin por su ID
     * @param int $id ID del superadmin
     * @return array|bool Datos del superadmin o false si no existe
     */
    public function obtenerPorId($id) {
        $query = "SELECT id, nombre, email FROM superadmin WHERE id = ?";
        
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
     * Actualizar perfil del superadmin
     * @param int $id ID del superadmin
     * @param array $datos Nuevos datos del superadmin
     * @return bool Resultado de la operación
     */
    public function actualizarPerfil($id, $datos) {
        $query = "UPDATE superadmin SET nombre = ?, email = ?";
        $params = [$datos['nombre'], $datos['email']];
        $types = "ss";
        
        // Si se proporciona una nueva contraseña, actualizarla
        if (!empty($datos['password'])) {
            // Verificar longitud mínima
            if (strlen($datos['password']) < 8) {
                return false;
            }
            
            $query .= ", password = ?";
            $params[] = password_hash($datos['password'], PASSWORD_DEFAULT);
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
 * Dashboard stats para el superadmin
 * @return array Estadísticas del dashboard
 */
public function obtenerEstadisticas() {
    $stats = [];
    
    // Total de usuarios
    $query = "SELECT COUNT(*) as total FROM usuarios";
    $result = $this->db->getConnection()->query($query);
    $stats['total_usuarios'] = $result->fetch_assoc()['total'];
    
    // Usuarios activos
    $query = "SELECT COUNT(*) as activos FROM usuarios WHERE estado = 'activo'";
    $result = $this->db->getConnection()->query($query);
    $stats['usuarios_activos'] = $result->fetch_assoc()['activos'];
    
    // Usuarios por rol
    $query = "SELECT r.nombre, COUNT(u.id) as cantidad 
              FROM usuarios u
              JOIN roles r ON u.rol_id = r.id
              GROUP BY r.nombre";
    $result = $this->db->getConnection()->query($query);
    $stats['usuarios_por_rol'] = [];
    
    while ($row = $result->fetch_assoc()) {
        $stats['usuarios_por_rol'][$row['nombre']] = $row['cantidad'];
    }
    
    // Usuarios recientes (último mes)
    $query = "SELECT COUNT(*) as recientes FROM usuarios 
              WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    $result = $this->db->getConnection()->query($query);
    $stats['usuarios_recientes'] = $result->fetch_assoc()['recientes'];
    
    // Total de cursos
    $query = "SELECT COUNT(*) as total FROM cursos";
    $result = $this->db->getConnection()->query($query);
    $stats['total_cursos'] = $result->fetch_assoc()['total'];
    
    // Cursos activos
    $query = "SELECT COUNT(*) as activos FROM cursos WHERE estado = 'activo'";
    $result = $this->db->getConnection()->query($query);
    $stats['cursos_activos'] = $result->fetch_assoc()['activos'];
    
    // Cursos recientes (último mes)
    $query = "SELECT COUNT(*) as recientes FROM cursos 
              WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    $result = $this->db->getConnection()->query($query);
    $stats['cursos_recientes'] = $result->fetch_assoc()['recientes'];
    
    return $stats;
}
}
?>