<?php
class UserController {
    private $usuarioModel;
    
    public function __construct($database) {
        $this->usuarioModel = new UsuarioModel($database);
    }
    
    /**
     * Procesa la creación de un nuevo usuario
     * @param array $userData Datos del formulario
     * @return array Resultado de la operación
     */
    public function create($userData) {
        // Verificar que sea un superadmin quien está creando el usuario
        session_start();
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'superadmin') {
            return [
                'success' => false,
                'message' => 'No tiene permisos para crear usuarios'
            ];
        }
        
        // Agregar el id del superadmin que está creando el usuario
        $userData['created_by'] = $_SESSION['user_id'];
        
        // Por defecto, asignar rol de usuario regular
        if (!isset($userData['rol_id'])) {
            $userData['rol_id'] = 1; // ID del rol "usuario" según el esquema
        }
        
        // Intentar crear el usuario
        $userId = $this->usuarioModel->create($userData);
        
        if ($userId) {
            return [
                'success' => true,
                'message' => 'Usuario creado exitosamente',
                'user_id' => $userId
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al crear el usuario'
            ];
        }
    }
    
    /**
     * Obtiene la lista de usuarios creados por el superadmin actual
     * @return array Lista de usuarios
     */
    public function listUsuarios() {
        session_start();
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'superadmin') {
            return [
                'success' => false,
                'message' => 'No tiene permisos para ver usuarios'
            ];
        }
        
        $usuarios = $this->usuarioModel->getAllByCreator($_SESSION['user_id']);
        
        return [
            'success' => true,
            'usuarios' => $usuarios
        ];
    }
}
?>