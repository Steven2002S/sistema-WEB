<?php
class AuthController {
    private $superAdminModel;
    private $usuarioModel;
    
    public function __construct($database) {
        $this->superAdminModel = new SuperAdminModel($database);
        $this->usuarioModel = new UsuarioModel($database);
    }
    
    /**
     * Procesa el login verificando en ambas tablas
     * @param string $email Email del usuario
     * @param string $password Contraseña sin encriptar
     * @return array Resultado del login con status y mensaje
     */
    public function login($email, $password) {
        // Mensajes de depuración
        error_log("Intento de login: Email=$email");
        
        // Verificar si ya hay una sesión activa y destruirla
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        
        // Primero verificar en superadmin
        $superadmin = $this->superAdminModel->findByEmail($email);
        
        error_log("Superadmin encontrado: " . ($superadmin ? "SÍ" : "NO"));
        
        if ($superadmin) {
            $passwordVerified = password_verify($password, $superadmin->password);
            error_log("Password verificada: " . ($passwordVerified ? "SÍ" : "NO"));
            
            if ($passwordVerified) {
                // Iniciar sesión como superadmin
                session_start();
                $_SESSION['user_id'] = $superadmin->id;
                $_SESSION['user_type'] = 'superadmin';
                $_SESSION['nombre'] = $superadmin->nombre;
                
                return [
                    'success' => true,
                    'user_type' => 'superadmin',
                    'redirect' => '/dashboard/superadmin'
                ];
            }
        }
        
        // Si no es superadmin, verificar en usuarios
        $usuario = $this->usuarioModel->findByEmail($email);
        
        error_log("Usuario regular encontrado: " . ($usuario ? "SÍ" : "NO"));
        
        if ($usuario) {
            $passwordVerified = password_verify($password, $usuario->password);
            error_log("Password verificada (usuario): " . ($passwordVerified ? "SÍ" : "NO"));
            
            if ($passwordVerified) {
                // Verificar si está activo
                if ($usuario->estado != 'activo') {
                    error_log("Usuario está inactivo");
                    return [
                        'success' => false,
                        'message' => 'Usuario inactivo. Contacte al administrador.'
                    ];
                }
                
                // Iniciar sesión como usuario regular
                session_start();
                $_SESSION['user_id'] = $usuario->id;
                $_SESSION['user_type'] = 'usuario';
                $_SESSION['nombre'] = $usuario->nombres . ' ' . $usuario->apellidos;
                $_SESSION['rol_id'] = $usuario->rol_id;
                
                return [
                    'success' => true,
                    'user_type' => 'usuario',
                    'redirect' => '/dashboard/usuario'
                ];
            }
        }
        
        // Si no se encontró en ninguna tabla
        error_log("Autenticación fallida: credenciales incorrectas");
        return [
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ];
    }
    
    /**
     * Cierra la sesión del usuario
     */
    public function logout() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_destroy();
        
        return [
            'success' => true,
            'redirect' => '/login'
        ];
    }
    
    /**
     * Verifica si hay una sesión activa y qué tipo de usuario está conectado
     * @return array Información de la sesión actual
     */
    public function checkSession() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) {
            return [
                'logged_in' => true,
                'user_type' => $_SESSION['user_type'],
                'user_id' => $_SESSION['user_id'],
                'nombre' => $_SESSION['nombre']
            ];
        }
        
        return [
            'logged_in' => false
        ];
    }
}
?>