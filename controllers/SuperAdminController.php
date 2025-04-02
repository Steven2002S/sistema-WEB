<?php
class SuperAdminController {
    private $db;
    private $authController;
    private $superAdminModel;
    private $usuarioModel;
    private $rolModel;
    private $cursoModel;
    
    /**
     * Constructor del controlador de superadmin
     * @param Database $database Instancia de la clase Database
     * @param AuthController $authController Instancia del controlador de autenticación
     */
    public function __construct($database, $authController) {
        $this->db = $database;
        $this->authController = $authController;
        $this->superAdminModel = new SuperAdminModel($database);
        $this->usuarioModel = new UsuarioModel($database);
        $this->cursoModel = new CursoModel($database);
        $this->rolModel = new RolModel($database);

        
        // Verificar que el usuario sea superadmin en cada acción
        $this->verificarSuperAdmin();
    }
    
    /**
     * Verificar que el usuario actual sea superadmin
     */
    private function verificarSuperAdmin() {
        if (!$this->authController->esSuperAdmin()) {
            // Redirigir al login si no es superadmin
            header('Location: index.php?controller=auth&action=logout');
            exit;
        }
    }
    
    /**
 * Acción para mostrar el dashboard
 */
public function dashboard() {
    // Obtener estadísticas para el dashboard
    $estadisticas = $this->superAdminModel->obtenerEstadisticas();
    
    // Obtener lista de usuarios recientes para mostrar en el dashboard
    $usuarios = $this->usuarioModel->listarTodos();
    
    // Cargar la vista del dashboard
    include 'views/superadmin/dashboard.php';
}
    /**
     * Acción para listar usuarios
     */
    public function listarUsuarios() {
        // Obtener todos los usuarios
        $usuarios = $this->usuarioModel->listarTodos();
        
        // Cargar la vista de usuarios
        include 'views/superadmin/usuarios.php';
    }
    
    /**
     * Acción para crear un nuevo usuario
     */
    public function crearUsuario() {
        $mensaje = '';
        $error = false;
        
        // Obtener roles para el formulario
        $roles = $this->rolModel->obtenerTodos();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos de entrada
            $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING);
            $nombres = filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING);
            $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
            $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento');
            $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
            $ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_STRING);
            $pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
            $genero = filter_input(INPUT_POST, 'genero');
            $organizacion = filter_input(INPUT_POST, 'organizacion', FILTER_SANITIZE_STRING);
            $password = $_POST['password'] ?? '';
            $rol_id = filter_input(INPUT_POST, 'rol_id', FILTER_VALIDATE_INT);
            
            // Verificar datos obligatorios
            if (!$cedula || !$nombres || !$apellidos || !$fecha_nacimiento || !$correo || 
                !$ciudad || !$pais || !$genero || !$organizacion || strlen($password) < 8 || !$rol_id) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos. La contraseña debe tener al menos 8 caracteres.';
            } else {
                // Datos del usuario a crear
                $datos = [
                    'cedula' => $cedula,
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'correo' => $correo,
                    'ciudad' => $ciudad,
                    'pais' => $pais,
                    'genero' => $genero,
                    'organizacion' => $organizacion,
                    'password' => $password,
                    'rol_id' => $rol_id
                ];
                
                // Obtener ID del superadmin actual
                $superadmin_id = $this->authController->getUsuarioId();
                
                // Intentar crear el usuario
                $resultado = $this->usuarioModel->crear($datos, $superadmin_id);
                
                if ($resultado) {
                    $mensaje = 'Usuario creado con éxito.';
                    
                    // Redirigir a la lista de usuarios después de una creación exitosa
                    header('Location: index.php?controller=superadmin&action=listarUsuarios&success=1');
                    exit;
                } else {
                    $error = true;
                    $mensaje = 'Error al crear el usuario. Verifica que la cédula y el correo no estén en uso.';
                }
            }
        }
        
        // Cargar vista de creación de usuario
        include 'views/superadmin/crear_usuario.php';
    }
    
    /**
     * Acción para editar un usuario existente
     */
    public function editarUsuario() {
        $mensaje = '';
        $error = false;
        
        // Obtener roles para el formulario
        $roles = $this->rolModel->obtenerTodos();
        
        // Obtener ID del usuario a editar
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            header('Location: index.php?controller=superadmin&action=listarUsuarios');
            exit;
        }
        
        // Obtener datos del usuario
        $usuario = $this->usuarioModel->obtenerPorId($id);
        
        if (!$usuario) {
            header('Location: index.php?controller=superadmin&action=listarUsuarios');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos de entrada
            $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING);
            $nombres = filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING);
            $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
            $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento');
            $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
            $ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_STRING);
            $pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
            $genero = filter_input(INPUT_POST, 'genero');
            $organizacion = filter_input(INPUT_POST, 'organizacion', FILTER_SANITIZE_STRING);
            $password = $_POST['password'] ?? ''; // Opcional
            $rol_id = filter_input(INPUT_POST, 'rol_id', FILTER_VALIDATE_INT);
            $estado = filter_input(INPUT_POST, 'estado');
            
            // Verificar datos obligatorios
            if (!$cedula || !$nombres || !$apellidos || !$fecha_nacimiento || !$correo || 
                !$ciudad || !$pais || !$genero || !$organizacion || !$rol_id) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos obligatorios.';
            } else {
                // Datos del usuario a actualizar
                $datos = [
                    'cedula' => $cedula,
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'correo' => $correo,
                    'ciudad' => $ciudad,
                    'pais' => $pais,
                    'genero' => $genero,
                    'organizacion' => $organizacion,
                    'rol_id' => $rol_id
                ];
                
                // Incluir contraseña solo si se proporciona
                if (!empty($password)) {
                    if (strlen($password) < 8) {
                        $error = true;
                        $mensaje = 'La contraseña debe tener al menos 8 caracteres.';
                    } else {
                        $datos['password'] = $password;
                    }
                }
                
                // Incluir estado solo si se proporciona
                if ($estado) {
                    $datos['estado'] = $estado;
                }
                
                // Si no hay errores, actualizar el usuario
                if (!$error) {
                    $resultado = $this->usuarioModel->actualizar($id, $datos);
                    
                    if ($resultado) {
                        $mensaje = 'Usuario actualizado con éxito.';
                        
                        // Recargar datos del usuario
                        $usuario = $this->usuarioModel->obtenerPorId($id);
                        
                        // Añade esta redirección después de una actualización exitosa
                        header('Location: index.php?controller=superadmin&action=listarUsuarios&success=1');
                        exit;
                    } else {
                        $error = true;
                        $mensaje = 'Error al actualizar el usuario.';
                    }
                }
            }
        }
        
        // Cargar vista de edición
        include 'views/superadmin/editar_usuario.php';
    }
    
    /**
     * Acción para eliminar un usuario
     */
    public function eliminarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener ID del usuario a eliminar
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            
            if (!$id) {
                $this->responderJSON(false, 'ID de usuario inválido');
                return;
            }
            
            // Intentar eliminar el usuario
            $resultado = $this->usuarioModel->eliminar($id);
            
            if ($resultado) {
                $this->responderJSON(true, 'Usuario eliminado con éxito');
            } else {
                $this->responderJSON(false, 'Error al eliminar el usuario');
            }
        } else {
            $this->responderJSON(false, 'Método no permitido');
        }
    }
    
    /**
     * Acción para cambiar el estado de un usuario (activar/desactivar)
     */
    public function cambiarEstadoUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener ID del usuario y nuevo estado
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
            
            if (!$id || !$estado) {
                $this->responderJSON(false, 'Parámetros inválidos');
                return;
            }
            
            // Intentar cambiar el estado
            $resultado = $this->usuarioModel->cambiarEstado($id, $estado);
            
            if ($resultado) {
                $this->responderJSON(true, 'Estado actualizado con éxito');
            } else {
                $this->responderJSON(false, 'Error al actualizar el estado');
            }
        } else {
            $this->responderJSON(false, 'Método no permitido');
        }
    }
    
    /**
     * Acción para gestionar roles
     */
    public function gestionarRoles() {
        // Obtener todos los roles
        $roles = $this->rolModel->obtenerTodos();
        
        // Cargar vista de gestión de roles
        include 'views/superadmin/roles.php';
    }
    
    /**
 * Acción para crear un nuevo rol
 */
public function crearRol() {
    $mensaje = '';
    $error = false;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Depuración - Ver todos los datos recibidos
        error_log("POST data recibida en crearRol: " . print_r($_POST, true));
        
        // Validar datos de entrada
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        
        error_log("Nombre filtrado: " . ($nombre ? $nombre : "vacío"));
        error_log("Descripción filtrada: " . ($descripcion ? $descripcion : "vacía"));
        
        // Verificar datos obligatorios
        if (!$nombre) {
            $error = true;
            $mensaje = 'Por favor, proporciona un nombre para el rol.';
            error_log("Error: Nombre del rol está vacío");
        } else {
            // Datos del rol a crear
            $datos = [
                'nombre' => $nombre,
                'descripcion' => $descripcion ?? ''
            ];
            
            error_log("Intentando crear rol con datos: " . print_r($datos, true));
            
            // Intentar crear el rol
            $resultado = $this->rolModel->crear($datos);
            
            if ($resultado) {
                error_log("Rol creado exitosamente con ID: " . $resultado);
                $mensaje = 'Rol creado con éxito.';
                
                // Redirigir a la gestión de roles
                header('Location: index.php?controller=superadmin&action=gestionarRoles&success=1');
                exit;
            } else {
                $error = true;
                $mensaje = 'Error al crear el rol. Verifica que el nombre no esté en uso.';
                error_log("Error al crear rol. Error SQL: " . $this->db->getConnection()->error);
            }
        }
    }
    
    // Cargar vista de creación de rol
    include 'views/superadmin/crear_rol.php';
}
    
  /**
 * Acción para editar un rol existente
 */
public function editarRol() {
    $mensaje = '';
    $error = false;
    
    // Obtener ID del rol a editar
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id) {
        header('Location: index.php?controller=superadmin&action=gestionarRoles');
        exit;
    }
    
    // Obtener datos del rol
    $rol = $this->rolModel->obtenerPorId($id);
    
    if (!$rol) {
        header('Location: index.php?controller=superadmin&action=gestionarRoles');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validar datos de entrada
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        
        // Verificar datos obligatorios
        if (!$nombre) {
            $error = true;
            $mensaje = 'Por favor, proporciona un nombre para el rol.';
        } else {
            // Datos del rol a actualizar
            $datos = [
                'nombre' => $nombre,
                'descripcion' => $descripcion ?? ''
            ];
            
            // Intentar actualizar el rol
            $resultado = $this->rolModel->actualizar($id, $datos);
            
            if ($resultado) {
                $mensaje = 'Rol actualizado con éxito.';
                
                // Recargar datos del rol
                $rol = $this->rolModel->obtenerPorId($id);
                
                // Redirigir a la gestión de roles con mensaje de éxito
                header('Location: index.php?controller=superadmin&action=gestionarRoles&success=1');
                exit;
            } else {
                $error = true;
                $mensaje = 'Error al actualizar el rol.';
            }
        }
    }
    
    // Cargar vista de edición
    include 'views/superadmin/editar_rol.php';
}
    
    /**
     * Acción para eliminar un rol
     */
    public function eliminarRol() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener ID del rol a eliminar
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            
            if (!$id) {
                $this->responderJSON(false, 'ID de rol inválido');
                return;
            }
            
            // Intentar eliminar el rol
            $resultado = $this->rolModel->eliminar($id);
            
            if ($resultado) {
                $this->responderJSON(true, 'Rol eliminado con éxito');
            } else {
                $this->responderJSON(false, 'Error al eliminar el rol. Verifica que no tenga usuarios asociados.');
            }
        } else {
            $this->responderJSON(false, 'Método no permitido');
        }
    }
    
    /**
     * Acción para ver perfil del superadmin
     */
    public function verPerfil() {
        // Obtener ID del superadmin actual
        $superadmin_id = $this->authController->getUsuarioId();
        
        // Obtener datos del superadmin
        $superadmin = $this->superAdminModel->obtenerPorId($superadmin_id);
        
        if (!$superadmin) {
            header('Location: index.php?controller=superadmin&action=dashboard');
            exit;
        }
        
        // Cargar vista de perfil
        include 'views/superadmin/perfil.php';
    }

    
    /**
     * Acción para actualizar perfil del superadmin
     */
    public function actualizarPerfil() {
        $mensaje = '';
        $error = false;
        
        // Obtener ID del superadmin actual
        $superadmin_id = $this->authController->getUsuarioId();
        
        // Obtener datos del superadmin
        $superadmin = $this->superAdminModel->obtenerPorId($superadmin_id);
        
        if (!$superadmin) {
            header('Location: index.php?controller=superadmin&action=dashboard');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos de entrada
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password_actual = $_POST['password_actual'] ?? '';
            $password_nueva = $_POST['password_nueva'] ?? '';
            
            // Verificar datos obligatorios
            if (!$nombre || !$email) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos obligatorios.';
            } else {
                // Datos del superadmin a actualizar
                $datos = [
                    'nombre' => $nombre,
                    'email' => $email
                ];
                
                // Si se proporciona una nueva contraseña, validarla
                if (!empty($password_nueva)) {
                    if (strlen($password_nueva) < 8) {
                        $error = true;
                        $mensaje = 'La nueva contraseña debe tener al menos 8 caracteres.';
                    } else {
                        // Verificar contraseña actual
                        $superadmin_completo = $this->db->prepare("SELECT password FROM superadmin WHERE id = ?");
                        $superadmin_completo->bind_param("i", $superadmin_id);
                        $superadmin_completo->execute();
                        $resultado = $superadmin_completo->get_result();
                        $superadmin_con_password = $resultado->fetch_assoc();
                        
                        if (password_verify($password_actual, $superadmin_con_password['password'])) {
                            $datos['password'] = $password_nueva;
                        } else {
                            $error = true;
                            $mensaje = 'La contraseña actual es incorrecta.';
                        }
                    }
                }
                
                // Si no hay errores, actualizar el superadmin
                if (!$error) {
                    $resultado = $this->superAdminModel->actualizarPerfil($superadmin_id, $datos);
                    
                    if ($resultado) {
                        $mensaje = 'Perfil actualizado con éxito.';
                        
                        // Actualizar datos de sesión
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        $_SESSION['usuario_nombre'] = $nombre;
                        $_SESSION['usuario_email'] = $email;
                        
                        // Recargar datos del superadmin
                        $superadmin = $this->superAdminModel->obtenerPorId($superadmin_id);
                    } else {
                        $error = true;
                        $mensaje = 'Error al actualizar el perfil.';
                    }
                }
            }
        }
        
        // Cargar vista de perfil con mensaje
        include 'views/superadmin/perfil.php';
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

    /**
 * Acción para ver detalles de un usuario
 */
public function ver_usuario() {
    // Obtener ID del usuario a ver
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id) {
        header('Location: index.php?controller=superadmin&action=listarUsuarios');
        exit;
    }
    
    // Obtener datos del usuario
    $usuario = $this->usuarioModel->obtenerPorId($id);
    
    if (!$usuario) {
        header('Location: index.php?controller=superadmin&action=listarUsuarios');
        exit;
    }
    
    // Obtener datos del creador del usuario
    $creador = null;
    if ($usuario['created_by']) {
        $creador = $this->superAdminModel->obtenerPorId($usuario['created_by']);
    }
    
    // Cargar vista de detalles
    include 'views/superadmin/ver_usuario.php';
}
/**
 * Acción para mostrar estadísticas del sistema
 */
public function estadisticas() {
    // Obtener estadísticas generales
    $estadisticas = $this->superAdminModel->obtenerEstadisticas();
    
    // Obtener todos los roles
    $roles = $this->rolModel->obtenerTodos();
    
    // Obtener todos los cursos
    $cursos = $this->cursoModel->obtenerTodos();
    
    // Obtener usuarios recientes
    $query = "SELECT u.id, u.nombres, u.apellidos, u.correo, u.created_at
              FROM usuarios u
              ORDER BY u.created_at DESC
              LIMIT 10";
    
    $result = $this->db->getConnection()->query($query);
    $usuarios_recientes = [];
    
    while ($row = $result->fetch_assoc()) {
        $usuarios_recientes[] = $row;
    }
    
    // Obtener cursos recientes
    $query = "SELECT c.id, c.nombre, c.created_at
              FROM cursos c
              ORDER BY c.created_at DESC
              LIMIT 10";
    
    $result = $this->db->getConnection()->query($query);
    $cursos_recientes = [];
    
    while ($row = $result->fetch_assoc()) {
        $cursos_recientes[] = $row;
    }
    
    // Cargar la vista de estadísticas
    include 'views/superadmin/estadisticas.php';
}

/**
 * Acción para listar cursos
 */
public function listarCursos() {
    // Obtener todos los cursos
    $cursos = $this->cursoModel->obtenerTodos();
    
    // Cargar la vista de cursos
    include 'views/superadmin/cursos.php';
}

/**
 * Acción para crear un nuevo curso
 */
public function crearCurso() {
    $mensaje = '';
    $error = false;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validar datos de entrada
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        $fecha_inicio = filter_input(INPUT_POST, 'fecha_inicio');
        $fecha_fin = filter_input(INPUT_POST, 'fecha_fin');
        $hora_inicio = filter_input(INPUT_POST, 'hora_inicio');
        $hora_fin = filter_input(INPUT_POST, 'hora_fin');
        $dias_semana = isset($_POST['dias_semana']) ? json_encode($_POST['dias_semana']) : null;
        
        // Verificar datos obligatorios
        if (!$nombre) {
            $error = true;
            $mensaje = 'Por favor, proporciona un nombre para el curso.';
        } else {
            // Datos del curso a crear
            $datos = [
                'nombre' => $nombre,
                'descripcion' => $descripcion ?? '',
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'hora_inicio' => $hora_inicio,
                'hora_fin' => $hora_fin,
                'dias_semana' => $dias_semana
            ];
            
            // Obtener ID del superadmin actual
            $superadmin_id = $this->authController->getUsuarioId();
            
            // Intentar crear el curso
            $resultado = $this->cursoModel->crear($datos, $superadmin_id);
            
            if ($resultado) {
                $mensaje = 'Curso creado con éxito.';
                
                // Redirigir a la lista de cursos
                header('Location: index.php?controller=superadmin&action=listarCursos&success=1');
                exit;
            } else {
                $error = true;
                $mensaje = 'Error al crear el curso.';
            }
        }
    }
    
    // Cargar vista de creación de curso
    include 'views/superadmin/crear_curso.php';
}

/**
 * Acción para editar un curso existente
 */
public function editarCurso() {
    $mensaje = '';
    $error = false;
    
    // Obtener ID del curso a editar
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id) {
        header('Location: index.php?controller=superadmin&action=listarCursos');
        exit;
    }
    
    // Obtener datos del curso
    $curso = $this->cursoModel->obtenerPorId($id);
    
    if (!$curso) {
        header('Location: index.php?controller=superadmin&action=listarCursos');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validar datos de entrada
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado');
        $fecha_inicio = filter_input(INPUT_POST, 'fecha_inicio');
        $fecha_fin = filter_input(INPUT_POST, 'fecha_fin');
        $hora_inicio = filter_input(INPUT_POST, 'hora_inicio');
        $hora_fin = filter_input(INPUT_POST, 'hora_fin');
        $dias_semana = isset($_POST['dias_semana']) ? json_encode($_POST['dias_semana']) : null;
        
        // Verificar datos obligatorios
        if (!$nombre) {
            $error = true;
            $mensaje = 'Por favor, proporciona un nombre para el curso.';
        } else {
            // Datos del curso a actualizar
            $datos = [
                'nombre' => $nombre,
                'descripcion' => $descripcion ?? '',
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'hora_inicio' => $hora_inicio,
                'hora_fin' => $hora_fin,
                'dias_semana' => $dias_semana
            ];
            
            // Incluir estado solo si se proporciona
            if ($estado) {
                $datos['estado'] = $estado;
            }
            
            // Intentar actualizar el curso
            $resultado = $this->cursoModel->actualizar($id, $datos);
            
            if ($resultado) {
                $mensaje = 'Curso actualizado con éxito.';
                
                // Recargar datos del curso
                $curso = $this->cursoModel->obtenerPorId($id);
                
                // Redirigir a la lista de cursos
                header('Location: index.php?controller=superadmin&action=listarCursos&success=1');
                exit;
            } else {
                $error = true;
                $mensaje = 'Error al actualizar el curso.';
            }
        }
    }
    
    // Cargar vista de edición
    include 'views/superadmin/editar_curso.php';
}

/**
 * Acción para eliminar un curso
 */
public function eliminarCurso() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener ID del curso a eliminar
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            $this->responderJSON(false, 'ID de curso inválido');
            return;
        }
        
        // Intentar eliminar el curso
        $resultado = $this->cursoModel->eliminar($id);
        
        if ($resultado) {
            $this->responderJSON(true, 'Curso eliminado con éxito');
        } else {
            $this->responderJSON(false, 'Error al eliminar el curso');
        }
    } else {
        $this->responderJSON(false, 'Método no permitido');
    }
}

/**
 * Acción para cambiar el estado de un curso (activar/desactivar)
 */
public function cambiarEstadoCurso() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener ID del curso y nuevo estado
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
        
        if (!$id || !$estado) {
            $this->responderJSON(false, 'Parámetros inválidos');
            return;
        }
        
        // Intentar cambiar el estado
        $resultado = $this->cursoModel->cambiarEstado($id, $estado);
        
        if ($resultado) {
            $this->responderJSON(true, 'Estado actualizado con éxito');
        } else {
            $this->responderJSON(false, 'Error al actualizar el estado');
        }
    } else {
        $this->responderJSON(false, 'Método no permitido');
    }
}

/**
 * Acción para ver detalles de un curso
 */
public function verCurso() {
    // Obtener ID del curso a ver
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id) {
        header('Location: index.php?controller=superadmin&action=listarCursos');
        exit;
    }
    
    // Obtener datos del curso
    $curso = $this->cursoModel->obtenerPorId($id);
    
    if (!$curso) {
        header('Location: index.php?controller=superadmin&action=listarCursos');
        exit;
    }
    
    // Cargar vista de detalles
    include 'views/superadmin/ver_curso.php';
}
}
?>