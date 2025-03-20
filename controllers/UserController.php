<?php
class UserController {
    private $db;
    private $authController;
    private $usuarioModel;
    
    /**
     * Constructor del controlador de usuario
     * @param Database $database Instancia de la clase Database
     * @param AuthController $authController Instancia del controlador de autenticación
     */
    public function __construct($database, $authController) {
        $this->db = $database;
        $this->authController = $authController;
        $this->usuarioModel = new UsuarioModel($database);
        
        // Verificar que el usuario esté autenticado en cada acción
        $this->verificarAutenticacion();
    }
    
    /**
     * Verificar que el usuario esté autenticado
     */
    private function verificarAutenticacion() {
        if (!$this->authController->estaAutenticado() || $this->authController->esSuperAdmin()) {
            // Redirigir al login si no está autenticado o es superadmin
            header('Location: index.php?controller=auth&action=logout');
            exit;
        }
    }
    
    /**
     * Acción para mostrar el dashboard
     */
    public function dashboard() {
        // Obtener datos del usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        $usuario = $this->usuarioModel->obtenerPorId($usuario_id);
        
        // Cargar la vista de dashboard
        include 'views/usuario/dashboard.php';
    }
    
    /**
     * Acción para ver el perfil del usuario
     */
    public function verPerfil() {
        // Obtener datos del usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        $usuario = $this->usuarioModel->obtenerPorId($usuario_id);
        
        if (!$usuario) {
            // Si no se encuentra el usuario, redirigir al dashboard
            header('Location: index.php?controller=usuario&action=dashboard');
            exit;
        }
        
        // Cargar la vista de perfil
        include 'views/usuario/perfil.php';
    }
    
    /**
     * Acción para actualizar el perfil del usuario
     */
    public function actualizarPerfil() {
        $mensaje = '';
        $error = false;
        
        // Obtener datos del usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        $usuario = $this->usuarioModel->obtenerPorId($usuario_id);
        
        if (!$usuario) {
            // Si no se encuentra el usuario, redirigir al dashboard
            header('Location: index.php?controller=usuario&action=dashboard');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos de entrada (solo permitir actualizar algunos campos)
            $ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_STRING);
            $pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
            $organizacion = filter_input(INPUT_POST, 'organizacion', FILTER_SANITIZE_STRING);
            $password_actual = $_POST['password_actual'] ?? '';
            $password_nueva = $_POST['password_nueva'] ?? '';
            
            // Verificar datos obligatorios
            if (!$ciudad || !$pais || !$organizacion) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos obligatorios.';
            } else {
                // Datos del usuario a actualizar
                $datos = [
                    'ciudad' => $ciudad,
                    'pais' => $pais,
                    'organizacion' => $organizacion
                ];
                
                // Si se proporciona una nueva contraseña, verificar la actual y actualizar
                if (!empty($password_nueva)) {
                    // Verificar longitud mínima
                    if (strlen($password_nueva) < 8) {
                        $error = true;
                        $mensaje = 'La nueva contraseña debe tener al menos 8 caracteres.';
                    } else {
                        // Verificar la contraseña actual
                        $usuario_completo = $this->db->prepare("SELECT password FROM usuarios WHERE id = ?");
                        $usuario_completo->bind_param("i", $usuario_id);
                        $usuario_completo->execute();
                        $resultado = $usuario_completo->get_result();
                        $usuario_con_password = $resultado->fetch_assoc();
                        
                        if (password_verify($password_actual, $usuario_con_password['password'])) {
                            $datos['password'] = $password_nueva;
                        } else {
                            $error = true;
                            $mensaje = 'La contraseña actual es incorrecta.';
                        }
                    }
                }
                
                // Si no hay errores, actualizar el usuario
                if (!$error) {
                    $resultado = $this->usuarioModel->actualizar($usuario_id, $datos);
                    
                    if ($resultado) {
                        $mensaje = 'Perfil actualizado con éxito.';
                        
                        // Recargar datos del usuario
                        $usuario = $this->usuarioModel->obtenerPorId($usuario_id);
                    } else {
                        $error = true;
                        $mensaje = 'Error al actualizar el perfil.';
                    }
                }
            }
        }
        
        // Cargar vista de perfil con mensaje
        include 'views/usuario/perfil.php';
    }
    
    /**
     * Responder con JSON para las peticiones AJAX
     * @param bool $success Indica si la operación fue exitosa
     * @param string $message Mensaje para el usuario
     * @param array $data Datos adicionales (opcional)
     */
    private function responderJSON($success, $message, $data = []) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
}
?>