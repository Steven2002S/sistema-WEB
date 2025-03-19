<?php
class UsuarioModel {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Encuentra un usuario por su correo
     * @param string $correo Email del usuario
     * @return object|false Objeto con datos del usuario o false si no existe
     */
    public function findByEmail($correo) {
        $query = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        }
        
        return false;
    }
    
    /**
     * Crea un nuevo usuario en el sistema
     * @param array $userData Datos del usuario a crear
     * @return int|false ID del usuario creado o false si hubo error
     */
    public function create($userData) {
        $query = "INSERT INTO usuarios (cedula, nombres, apellidos, fecha_nacimiento, correo, ciudad, 
                  pais, genero, estado, organizacion, password, rol_id, created_by) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Hash de la contraseña
        $passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssssssssssii", 
            $userData['cedula'],
            $userData['nombres'],
            $userData['apellidos'],
            $userData['fechaNacimiento'],
            $userData['correo'],
            $userData['ciudad'],
            $userData['pais'],
            $userData['genero'],
            $userData['estado'],
            $userData['organizacion'],
            $passwordHash,
            $userData['rol_id'],
            $userData['created_by']
        );
        
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        
        return false;
    }
    
    /**
     * Obtiene todos los usuarios creados por un superadmin específico
     * @param int $superadminId ID del superadmin
     * @return array Lista de usuarios
     */
    public function getAllByCreator($superadminId) {
        $query = "SELECT * FROM usuarios WHERE created_by = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $superadminId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $usuarios = [];
        while ($row = $result->fetch_object()) {
            $usuarios[] = $row;
        }
        
        return $usuarios;
    }
}
?>