<?php
class AuthController {
    private $db;
    private $superAdminModel;
    private $usuarioModel;
    
    /**
     * Constructor del controlador de autenticación
     * @param Database $database Instancia de la clase Database
     */
    public function __construct($database) {
        $this->db = $database;
        $this->superAdminModel = new SuperAdminModel($database);
        $this->usuarioModel = new UsuarioModel($database);
    }
    
    /**
     * Acción de login
     */
    public function login() {
        // Verificar si es una petición POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Depuración - Guardar en un archivo de log
            error_log("Login intento - Datos recibidos: " . print_r($_POST, true));
            
            // Obtener y validar datos de entrada
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            
            // Depuración
            error_log("Email filtrado: " . ($email ? $email : "no válido"));
            error_log("Password recibido: " . (empty($password) ? "vacío" : "no vacío"));
            
            // Verificar datos obligatorios
            if (!$email || empty($password)) {
                error_log("Login fallido - Datos incompletos");
                $this->responderJSON(false, 'Por favor, introduce un email válido y contraseña');
                return;
            }
            
            // Intentar autenticar como superadmin
            error_log("Intentando autenticar como superadmin a: $email");
            $superadmin = $this->superAdminModel->autenticar($email, $password);
            
            if ($superadmin) {
                error_log("Autenticación exitosa como superadmin para: $email");
                
                // Iniciar sesión
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Almacenar datos de superadmin en la sesión
                $_SESSION['usuario_id'] = $superadmin['id'];
                $_SESSION['usuario_nombre'] = $superadmin['nombre'];
                $_SESSION['usuario_email'] = $superadmin['email'];
                $_SESSION['usuario_tipo'] = 'superadmin';
                
                // Generar un token de sesión para mayor seguridad
                $_SESSION['token'] = bin2hex(random_bytes(32));
                
                // Redirigir al dashboard de superadmin (URL absoluta desde la raíz)
                $this->responderJSON(true, 'Inicio de sesión exitoso', BASE_URL . '/index.php?controller=superadmin&action=dashboard');
                return;
            }
            
            // Si no es superadmin, intentar autenticar como usuario normal
            error_log("Intentando autenticar como usuario a: $email");
            $usuario = $this->usuarioModel->autenticar($email, $password);
            
            if ($usuario) {
                error_log("Autenticación exitosa como usuario para: $email");
                
                // Iniciar sesión
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Almacenar datos de usuario en la sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombres'] . ' ' . $usuario['apellidos'];
                $_SESSION['usuario_email'] = $usuario['correo'];
                $_SESSION['usuario_tipo'] = 'usuario';
                $_SESSION['usuario_rol'] = $usuario['rol'];
                
                // Generar un token de sesión para mayor seguridad
                $_SESSION['token'] = bin2hex(random_bytes(32));
                
                // Redirigir al dashboard de usuario (URL absoluta desde la raíz)
                $this->responderJSON(true, 'Inicio de sesión exitoso', BASE_URL . '/index.php?controller=usuario&action=dashboard');

                return;
            }
            
            // Si no se autenticó ni como superadmin ni como usuario
            error_log("Autenticación fallida para: $email");
            $this->responderJSON(false, 'Email o contraseña incorrectos');
        } else {
            // Si no es POST, redirigir a la página de login
            // CORREGIDO: Usa la ruta correcta al login.html
            header('Location: views/login.html');
            exit;
        }
    }
    
    /**
     * Acción de logout
     */
    public function logout() {
        // Iniciar sesión si no está activa
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Eliminar todas las variables de sesión
        $_SESSION = [];
        
        // Destruir la sesión
        session_destroy();
        
        // Redirigir a la página de login
        header('Location: views/login.html');
        exit;
    }
    
    /**
     * Verificar si el usuario está autenticado
     * @return bool True si está autenticado, false en caso contrario
     */
    public function estaAutenticado() {
        // Iniciar sesión si no está activa
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['usuario_id']) && isset($_SESSION['token']);
    }
    
    /**
     * Verificar si el usuario autenticado es superadmin
     * @return bool True si es superadmin, false en caso contrario
     */
    public function esSuperAdmin() {
        if (!$this->estaAutenticado()) {
            return false;
        }
        
        return $_SESSION['usuario_tipo'] === 'superadmin';
    }
    
    /**
     * Obtener el ID del usuario autenticado
     * @return int|null ID del usuario o null si no está autenticado
     */
    public function getUsuarioId() {
        if (!$this->estaAutenticado()) {
            return null;
        }
        
        return $_SESSION['usuario_id'];
    }
    
    /**
     * Verificar si el usuario tiene un rol específico
     * @param string $rol Nombre del rol a verificar
     * @return bool True si tiene el rol, false en caso contrario
     */
    public function tieneRol($rol) {
        if (!$this->estaAutenticado() || $_SESSION['usuario_tipo'] !== 'usuario') {
            return false;
        }
        
        return $_SESSION['usuario_rol'] === $rol;
    }
    
    /**
     * Responder con JSON para las peticiones AJAX
     * @param bool $success Indica si la operación fue exitosa
     * @param string $message Mensaje para el usuario
     * @param string $redirect URL de redirección (opcional)
     */
    private function responderJSON($success, $message, $redirect = '') {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'redirect' => $redirect
        ]);
        exit;
    }
}
?>