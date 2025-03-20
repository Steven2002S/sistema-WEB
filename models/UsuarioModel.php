<?php
class UsuarioModel {
    private $db;
    
    /**
     * Constructor del modelo de usuario
     * @param Database $database Instancia de la clase Database
     */
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Autenticar un usuario por correo y contraseña
     * @param string $correo Correo del usuario
     * @param string $password Contraseña sin encriptar
     * @return array|bool Datos del usuario o false si la autenticación falla
     */
    public function autenticar($correo, $password) {
        // Preparar consulta
        $query = "SELECT u.id, u.cedula, u.nombres, u.apellidos, u.correo, u.password, 
                         r.nombre as rol 
                  FROM usuarios u
                  JOIN roles r ON u.rol_id = r.id 
                  WHERE u.correo = ? AND u.estado = 'activo'";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            
            // Verificar la contraseña
            if (password_verify($password, $usuario['password'])) {
                // Eliminar la contraseña del array antes de devolverlo
                unset($usuario['password']);
                return $usuario;
            }
        }
        
        return false;
    }
    
    /**
     * Obtener un usuario por su ID
     * @param int $id ID del usuario
     * @return array|bool Datos del usuario o false si no existe
     */
    public function obtenerPorId($id) {
        $query = "SELECT u.*, r.nombre as rol_nombre 
                  FROM usuarios u
                  JOIN roles r ON u.rol_id = r.id
                  WHERE u.id = ?";
        
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
     * Crear un nuevo usuario
     * @param array $datos Datos del nuevo usuario
     * @param int $superadmin_id ID del superadmin que crea el usuario
     * @return bool|int ID del nuevo usuario o false en caso de error
     */
    public function crear($datos, $superadmin_id) {
        // Verificar que la contraseña tenga al menos 8 caracteres
        if (strlen($datos['password']) < 8) {
            return false;
        }
        
        // Encriptar la contraseña
        $password_hash = password_hash($datos['password'], PASSWORD_DEFAULT);
        
        // Formatear fecha de nacimiento
        $fecha_nacimiento = date('Y-m-d', strtotime($datos['fecha_nacimiento']));
        
        $query = "INSERT INTO usuarios (cedula, nombres, apellidos, fecha_nacimiento, 
                                        correo, ciudad, pais, genero, organizacion, 
                                        password, rol_id, created_by) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssssssssii", 
            $datos['cedula'], 
            $datos['nombres'], 
            $datos['apellidos'], 
            $fecha_nacimiento,
            $datos['correo'], 
            $datos['ciudad'], 
            $datos['pais'], 
            $datos['genero'], 
            $datos['organizacion'], 
            $password_hash,
            $datos['rol_id'], 
            $superadmin_id
        );
        
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        
        return false;
    }
    
    /**
     * Listar todos los usuarios
     * @return array Lista de usuarios
     */
    public function listarTodos() {
        $query = "SELECT u.id, u.cedula, u.nombres, u.apellidos, u.correo, 
                         u.ciudad, u.pais, u.estado, r.nombre as rol, u.created_at, 
                         s.nombre as creado_por
                  FROM usuarios u
                  JOIN roles r ON u.rol_id = r.id
                  JOIN superadmin s ON u.created_by = s.id
                  ORDER BY u.created_at DESC";
        
        $result = $this->db->getConnection()->query($query);
        $usuarios = [];
        
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        
        return $usuarios;
    }
    
    /**
     * Actualizar un usuario existente
     * @param int $id ID del usuario a actualizar
     * @param array $datos Nuevos datos del usuario
     * @return bool Resultado de la operación
     */
    public function actualizar($id, $datos) {
        $query = "UPDATE usuarios SET ";
        $params = [];
        $types = "";
        
        // Construir la query dinámicamente según los campos proporcionados
        $camposActualizables = [
            'cedula' => 's',
            'nombres' => 's',
            'apellidos' => 's',
            'fecha_nacimiento' => 's',
            'correo' => 's',
            'ciudad' => 's',
            'pais' => 's',
            'genero' => 's',
            'organizacion' => 's',
            'rol_id' => 'i',
            'estado' => 's'
        ];
        
        $actualizaciones = [];
        
        foreach ($camposActualizables as $campo => $tipo) {
            if (isset($datos[$campo])) {
                // Formatear fecha si es necesario
                if ($campo === 'fecha_nacimiento' && !empty($datos[$campo])) {
                    $datos[$campo] = date('Y-m-d', strtotime($datos[$campo]));
                }
                
                $actualizaciones[] = "$campo = ?";
                $params[] = $datos[$campo];
                $types .= $tipo;
            }
        }
        
        // Si se proporciona una nueva contraseña, actualizarla
        if (!empty($datos['password'])) {
            // Verificar longitud mínima
            if (strlen($datos['password']) < 8) {
                return false;
            }
            
            $actualizaciones[] = "password = ?";
            $params[] = password_hash($datos['password'], PASSWORD_DEFAULT);
            $types .= "s";
        }
        
        // Si no hay campos para actualizar, retornar error
        if (empty($actualizaciones)) {
            return false;
        }
        
        $query .= implode(", ", $actualizaciones);
        $query .= " WHERE id = ?";
        $params[] = $id;
        $types .= "i";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$params);
        
        return $stmt->execute();
    }
    
    /**
     * Cambiar estado de un usuario (activar/desactivar)
     * @param int $id ID del usuario
     * @param string $estado Nuevo estado ('activo' o 'inactivo')
     * @return bool Resultado de la operación
     */
    public function cambiarEstado($id, $estado) {
        if ($estado !== 'activo' && $estado !== 'inactivo') {
            return false;
        }
        
        $query = "UPDATE usuarios SET estado = ? WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $estado, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar un usuario (realmente lo elimina de la base de datos)
     * @param int $id ID del usuario a eliminar
     * @return bool Resultado de la operación
     */
    public function eliminar($id) {
        $query = "DELETE FROM usuarios WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Obtener todos los roles
     * @return array Lista de roles
     */
    public function obtenerRoles() {
        $query = "SELECT id, nombre, descripcion FROM roles";
        
        $result = $this->db->getConnection()->query($query);
        $roles = [];
        
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row;
        }
        
        return $roles;
    }
}
?>