<?php
class UserController {
    private $db;
    private $authController;
    private $usuarioModel;
    private $titularModel;
    private $estudianteModel;
    private $referenciaModel;
    private $cursoModel;
    
    /**
     * Constructor del controlador de usuario
     * @param Database $database Instancia de la clase Database
     * @param AuthController $authController Instancia del controlador de autenticación
     */
    public function __construct($database, $authController) {
        $this->db = $database;
        $this->authController = $authController;
        $this->usuarioModel = new UsuarioModel($database);
        $this->titularModel = new TitularModel($database);
        $this->estudianteModel = new EstudianteModel($database);
        $this->referenciaModel = new ReferenciaModel($database);
        $this->cursoModel = new CursoModel($database);
        
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
        
        // Obtener listas para las estadísticas (solo del usuario actual)
        $titulares = $this->titularModel->obtenerPorUsuario($usuario_id);
        $estudiantes = $this->estudianteModel->obtenerPorUsuario($usuario_id);
        $cursos = $this->cursoModel->obtenerTodos(); // Los cursos son globales
        
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
    
    // MÉTODOS PARA GESTIÓN DE TITULARES
    
    /**
     * Acción para listar titulares
     */
    public function listarTitulares() {
        // Obtener ID del usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        
        // Obtener solo los titulares creados por el usuario actual
        $titulares = $this->titularModel->obtenerPorUsuario($usuario_id);
        
        // Cargar la vista de titulares
        include 'views/usuario/titulares.php';
    }
    
    /**
     * Acción para crear un nuevo titular con estudiantes y referencias
     */
    public function crearTitular() {
        $mensaje = '';
        $error = false;
        
        // Obtener cursos para el formulario
        $cursos = $this->cursoModel->obtenerTodos();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del titular
            $datos_titular = [
                'cedula' => filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING),
                'nombres' => filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING),
                'apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING),
                'direccion' => filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'empresa' => filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING),
                'celular' => filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING),
                'telefono_casa' => filter_input(INPUT_POST, 'telefono_casa', FILTER_SANITIZE_STRING),
                'cargo' => filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING),
                'telefono_trabajo' => filter_input(INPUT_POST, 'telefono_trabajo', FILTER_SANITIZE_STRING)
            ];
            
            // Verificar datos obligatorios del titular
            if (!$datos_titular['cedula'] || !$datos_titular['nombres'] || !$datos_titular['apellidos'] || !$datos_titular['direccion']) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos obligatorios del titular.';
            } else {
                // Obtener ID del usuario actual
                $usuario_id = $this->authController->getUsuarioId();
                
                // Crear el titular
                $titular_id = $this->titularModel->crear($datos_titular, $usuario_id);
                
                if ($titular_id) {
                    // Procesar estudiantes
                    $estudiantes_creados = 0;
                    
                    // Determinar cuántos estudiantes se enviaron
                    $total_estudiantes = isset($_POST['estudiante_cedula']) ? count($_POST['estudiante_cedula']) : 0;
                    
                    // Limitamos a 10 estudiantes máximo por titular
                    $total_estudiantes = min($total_estudiantes, 10);
                    
                    for ($i = 0; $i < $total_estudiantes; $i++) {
                        // Verificar que al menos se haya proporcionado el nombre y apellido
                        if (!empty($_POST['estudiante_nombres'][$i]) && !empty($_POST['estudiante_apellidos'][$i])) {
                            $datos_estudiante = [
                                'cedula' => filter_var($_POST['estudiante_cedula'][$i], FILTER_SANITIZE_STRING),
                                'nombres' => filter_var($_POST['estudiante_nombres'][$i], FILTER_SANITIZE_STRING),
                                'apellidos' => filter_var($_POST['estudiante_apellidos'][$i], FILTER_SANITIZE_STRING),
                                'edad' => filter_var($_POST['estudiante_edad'][$i], FILTER_VALIDATE_INT),
                                'curso_id' => filter_var($_POST['estudiante_curso_id'][$i], FILTER_VALIDATE_INT),
                                'talla' => filter_var($_POST['estudiante_talla'][$i], FILTER_SANITIZE_STRING),
                                'titular_id' => $titular_id
                            ];
                            
                            // Crear estudiante
                            if ($this->estudianteModel->crear($datos_estudiante)) {
                                $estudiantes_creados++;
                            }
                        }
                    }
                    
                    // Procesar referencias personales
                    $referencias_creadas = 0;
                    
                    // Determinar si se envió una referencia
                    if (!empty($_POST['referencia_nombres']) && !empty($_POST['referencia_apellidos'])) {
                        $datos_referencia = [
                            'nombres' => filter_input(INPUT_POST, 'referencia_nombres', FILTER_SANITIZE_STRING),
                            'apellidos' => filter_input(INPUT_POST, 'referencia_apellidos', FILTER_SANITIZE_STRING),
                            'direccion' => filter_input(INPUT_POST, 'referencia_direccion', FILTER_SANITIZE_STRING),
                            'email' => filter_input(INPUT_POST, 'referencia_email', FILTER_SANITIZE_EMAIL),
                            'celular' => filter_input(INPUT_POST, 'referencia_celular', FILTER_SANITIZE_STRING),
                            'telefono_casa' => filter_input(INPUT_POST, 'referencia_telefono_casa', FILTER_SANITIZE_STRING),
                            'empresa' => filter_input(INPUT_POST, 'referencia_empresa', FILTER_SANITIZE_STRING),
                            'cargo' => filter_input(INPUT_POST, 'referencia_cargo', FILTER_SANITIZE_STRING),
                            'telefono_trabajo' => filter_input(INPUT_POST, 'referencia_telefono_trabajo', FILTER_SANITIZE_STRING),
                            'titular_id' => $titular_id
                        ];
                        
                        // Crear referencia
                        if ($this->referenciaModel->crear($datos_referencia)) {
                            $referencias_creadas++;
                        }
                    }
                    
                    $mensaje = "Titular creado con éxito. Se han registrado $estudiantes_creados estudiante(s)";
                    if ($referencias_creadas > 0) {
                        $mensaje .= " y $referencias_creadas referencia(s) personal(es).";
                    } else {
                        $mensaje .= ".";
                    }
                    
                    // Redirigir a la lista de titulares
                    header('Location: index.php?controller=usuario&action=listarTitulares&success=1');
                    exit;
                } else {
                    $error = true;
                    $mensaje = 'Error al crear el titular. Verifica que la cédula no esté en uso.';
                }
            }
        }
        
        // Cargar vista de creación
        include 'views/usuario/crear_titular.php';
    }
    
    /**
     * Acción para ver detalles de un titular
     */
    public function verTitular() {
        // Obtener ID del titular
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
        
        // Obtener datos del titular
        $titular = $this->titularModel->obtenerPorId($id);
        
        if (!$titular) {
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
        
        // Verificar que el titular pertenece al usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        if ($titular['created_by'] != $usuario_id) {
            // Si no tiene permiso, redirigir
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
        
        // Obtener estudiantes del titular
        $estudiantes = $this->estudianteModel->obtenerPorTitular($id);
        
        // Obtener referencias del titular
        $referencias = $this->referenciaModel->obtenerPorTitular($id);
        
        // Cargar vista de detalles
        include 'views/usuario/ver_titular.php';
    }
    
    /**
     * Acción para editar un titular existente
     */
    public function editarTitular() {
        $mensaje = '';
        $error = false;
        
        // Obtener ID del titular
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
        
        // Obtener datos del titular
        $titular = $this->titularModel->obtenerPorId($id);
        
        if (!$titular) {
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
        
        // Verificar que el titular pertenece al usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        if ($titular['created_by'] != $usuario_id) {
            // Si no tiene permiso, redirigir
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
        
        // Obtener estudiantes del titular
        $estudiantes = $this->estudianteModel->obtenerPorTitular($id);
        
        // Obtener referencias del titular
        $referencias = $this->referenciaModel->obtenerPorTitular($id);
        
        // Obtener cursos para el formulario
        $cursos = $this->cursoModel->obtenerTodos();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del titular
            $datos_titular = [
                'cedula' => filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING),
                'nombres' => filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING),
                'apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING),
                'direccion' => filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'empresa' => filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING),
                'celular' => filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING),
                'telefono_casa' => filter_input(INPUT_POST, 'telefono_casa', FILTER_SANITIZE_STRING),
                'cargo' => filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING),
                'telefono_trabajo' => filter_input(INPUT_POST, 'telefono_trabajo', FILTER_SANITIZE_STRING)
            ];
            
            // Verificar datos obligatorios del titular
            if (!$datos_titular['cedula'] || !$datos_titular['nombres'] || !$datos_titular['apellidos'] || !$datos_titular['direccion']) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos obligatorios del titular.';
            } else {
                // Actualizar el titular
                $resultado = $this->titularModel->actualizar($id, $datos_titular);
                
                if ($resultado) {
                    $mensaje = 'Titular actualizado con éxito.';
                    
                    // Redirigir a la vista de detalles
                    header('Location: index.php?controller=usuario&action=verTitular&id=' . $id . '&success=1');
                    exit;
                } else {
                    $error = true;
                    $mensaje = 'Error al actualizar el titular. Verifica que la cédula no esté en uso.';
                }
            }
        }
        
        // Cargar vista de edición
        include 'views/usuario/editar_titular.php';
    }
    
    /**
     * Acción para eliminar un titular
     */
    public function eliminarTitular() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener ID del titular a eliminar
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            
            if (!$id) {
                $this->responderJSON(false, 'ID de titular inválido');
                return;
            }
            
            // Verificar que el titular pertenece al usuario actual
            $usuario_id = $this->authController->getUsuarioId();
            $titular = $this->titularModel->obtenerPorId($id);
            
            if (!$titular || $titular['created_by'] != $usuario_id) {
                $this->responderJSON(false, 'No tienes permiso para eliminar este titular');
                return;
            }
            
            // Intentar eliminar el titular y todos sus datos relacionados
            $resultado = $this->titularModel->eliminar($id);
            
            if ($resultado) {
                $this->responderJSON(true, 'Titular y todos sus datos relacionados eliminados con éxito');
            } else {
                $this->responderJSON(false, 'Error al eliminar el titular y sus datos relacionados');
            }
        } else {
            $this->responderJSON(false, 'Método no permitido');
        }
    }
    
    // MÉTODOS PARA GESTIÓN DE REFERENCIAS
    
    /**
     * Acción para crear una referencia personal
     */
    public function crearReferencia() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener ID del titular
            $titular_id = filter_input(INPUT_POST, 'titular_id', FILTER_VALIDATE_INT);
            
            if (!$titular_id) {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=listarTitulares');
                exit;
            }
            
            // Verificar que el titular pertenece al usuario actual
            $usuario_id = $this->authController->getUsuarioId();
            $titular = $this->titularModel->obtenerPorId($titular_id);
            
            if (!$titular || $titular['created_by'] != $usuario_id) {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=listarTitulares');
                exit;
            }
            
            // Obtener datos de la referencia
            $datos_referencia = [
                'nombres' => filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING),
                'apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING),
                'direccion' => filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'celular' => filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING),
                'telefono_casa' => filter_input(INPUT_POST, 'telefono_casa', FILTER_SANITIZE_STRING),
                'empresa' => filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING),
                'cargo' => filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING),
                'telefono_trabajo' => filter_input(INPUT_POST, 'telefono_trabajo', FILTER_SANITIZE_STRING),
                'titular_id' => $titular_id
            ];
            
            // Crear la referencia
            $resultado = $this->referenciaModel->crear($datos_referencia);
            
            // Redirigir a la vista de edición del titular
            if ($resultado) {
                header('Location: index.php?controller=usuario&action=editarTitular&id=' . $titular_id . '&success=1');
            } else {
                header('Location: index.php?controller=usuario&action=editarTitular&id=' . $titular_id . '&error=1');
            }
            exit;
        } else {
            // Redirigir a la lista de titulares si no es POST
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
    }
    
    /**
     * Acción para actualizar una referencia personal
     */
    public function actualizarReferencia() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener IDs de la referencia y del titular
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $titular_id = filter_input(INPUT_POST, 'titular_id', FILTER_VALIDATE_INT);
            
            if (!$id || !$titular_id) {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=listarTitulares');
                exit;
            }
            
            // Verificar que el titular pertenece al usuario actual
            $usuario_id = $this->authController->getUsuarioId();
            $titular = $this->titularModel->obtenerPorId($titular_id);
            
            if (!$titular || $titular['created_by'] != $usuario_id) {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=listarTitulares');
                exit;
            }
            
            // Obtener datos de la referencia
            $datos_referencia = [
                'nombres' => filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING),
                'apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING),
                'direccion' => filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'celular' => filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING),
                'telefono_casa' => filter_input(INPUT_POST, 'telefono_casa', FILTER_SANITIZE_STRING),
                'empresa' => filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING),
                'cargo' => filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING),
                'telefono_trabajo' => filter_input(INPUT_POST, 'telefono_trabajo', FILTER_SANITIZE_STRING),
                'titular_id' => $titular_id
            ];
            
            // Actualizar la referencia
            $resultado = $this->referenciaModel->actualizar($id, $datos_referencia);
            
            // Redirigir a la vista de edición del titular
            if ($resultado) {
                header('Location: index.php?controller=usuario&action=editarTitular&id=' . $titular_id . '&success=1');
            } else {
                header('Location: index.php?controller=usuario&action=editarTitular&id=' . $titular_id . '&error=1');
            }
            exit;
        } else {
            // Redirigir a la lista de titulares si no es POST
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
    }
    
    // MÉTODOS PARA GESTIÓN DE ESTUDIANTES
    
    /**
     * Acción para listar todos los estudiantes
     */
    public function listarEstudiantes() {
        // Obtener ID del usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        
        // Obtener solo los estudiantes asociados a titulares creados por el usuario actual
        $estudiantes = $this->estudianteModel->obtenerPorUsuario($usuario_id);
        
        // Cargar la vista de estudiantes
        include 'views/usuario/estudiantes.php';
    }
    
    /**
     * Acción para crear un nuevo estudiante
     */
    public function crearEstudiante() {
        $mensaje = '';
        $error = false;
        
        // Obtener cursos para el formulario
        $cursos = $this->cursoModel->obtenerTodos();
        
        // Obtener ID del usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        
        // Obtener titulares para el formulario (solo los del usuario actual)
        $titulares = $this->titularModel->obtenerPorUsuario($usuario_id);
        
        // Verificar si se ha proporcionado un titular_id en la URL
        $titular_id = filter_input(INPUT_GET, 'titular_id', FILTER_VALIDATE_INT);
        
        // Si se proporciona un titular_id, verificar que pertenece al usuario actual
        if ($titular_id) {
            $titular = $this->titularModel->obtenerPorId($titular_id);
            if (!$titular || $titular['created_by'] != $usuario_id) {
                header('Location: index.php?controller=usuario&action=listarTitulares');
                exit;
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del estudiante
            $datos_estudiante = [
                'cedula' => filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING),
                'nombres' => filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING),
                'apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING),
                'edad' => filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT),
                'curso_id' => filter_input(INPUT_POST, 'curso_id', FILTER_VALIDATE_INT),
                'talla' => filter_input(INPUT_POST, 'talla', FILTER_SANITIZE_STRING),
                'titular_id' => filter_input(INPUT_POST, 'titular_id', FILTER_VALIDATE_INT)
            ];
            
            // Verificar datos obligatorios
            if (!$datos_estudiante['nombres'] || !$datos_estudiante['apellidos'] || 
                !$datos_estudiante['edad'] || !$datos_estudiante['curso_id'] || 
                !$datos_estudiante['titular_id']) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos obligatorios.';
            } else {
                // Verificar que el titular pertenece al usuario actual
                $titular = $this->titularModel->obtenerPorId($datos_estudiante['titular_id']);
                if (!$titular || $titular['created_by'] != $usuario_id) {
                    $error = true;
                    $mensaje = 'No tienes permiso para asociar este estudiante al titular seleccionado.';
                } else {
                    // Crear estudiante
                    $resultado = $this->estudianteModel->crear($datos_estudiante);
                    
                    if ($resultado) {
                        $mensaje = 'Estudiante creado con éxito.';
                        
                        // Redirigir a la lista de estudiantes o a la vista del titular
                        if ($titular_id) {
                            header('Location: index.php?controller=usuario&action=verTitular&id=' . $titular_id . '&success=1');
                        } else {
                            header('Location: index.php?controller=usuario&action=listarEstudiantes&success=1');
                        }
                        exit;
                    } else {
                        $error = true;
                        $mensaje = 'Error al crear el estudiante. Verifica que la cédula no esté en uso.';
                    }
                }
            }
        }
        
        // Cargar vista de creación
        include 'views/usuario/crear_estudiante.php';
    }
    
    /**
     * Acción para crear un nuevo estudiante desde la vista de edición de titular
     */
    public function crearEstudianteInline() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener ID del titular
            $titular_id = filter_input(INPUT_POST, 'titular_id', FILTER_VALIDATE_INT);
            
            if (!$titular_id) {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=listarTitulares');
                exit;
            }
            
            // Verificar que el titular pertenece al usuario actual
            $usuario_id = $this->authController->getUsuarioId();
            $titular = $this->titularModel->obtenerPorId($titular_id);
            
            if (!$titular || $titular['created_by'] != $usuario_id) {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=listarTitulares');
                exit;
            }
            
            // Obtener datos del estudiante
            $datos_estudiante = [
                'cedula' => filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING),
                'nombres' => filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING),
                'apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING),
                'edad' => filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT),
                'curso_id' => filter_input(INPUT_POST, 'curso_id', FILTER_VALIDATE_INT),
                'talla' => filter_input(INPUT_POST, 'talla', FILTER_SANITIZE_STRING),
                'titular_id' => $titular_id
            ];
            
            // Verificar datos obligatorios
            if (!$datos_estudiante['nombres'] || !$datos_estudiante['apellidos'] || 
                !$datos_estudiante['edad'] || !$datos_estudiante['curso_id']) {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=editarTitular&id=' . $titular_id . '&error=1');
                exit;
            }
            
            // Crear estudiante
            $resultado = $this->estudianteModel->crear($datos_estudiante);
            
            // Redirigir a la vista de edición del titular
            if ($resultado) {
                header('Location: index.php?controller=usuario&action=editarTitular&id=' . $titular_id . '&success=1');
            } else {
                header('Location: index.php?controller=usuario&action=editarTitular&id=' . $titular_id . '&error=1');
            }
            exit;
        } else {
            // Redirigir a la lista de titulares si no es POST
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
    }
    
    /**
     * Acción para editar un estudiante existente
     */
    public function editarEstudiante() {
        $mensaje = '';
        $error = false;
        
        // Obtener ID del estudiante
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            header('Location: index.php?controller=usuario&action=listarEstudiantes');
            exit;
        }
        
        // Obtener datos del estudiante
        $estudiante = $this->estudianteModel->obtenerPorId($id);
        
        if (!$estudiante) {
            header('Location: index.php?controller=usuario&action=listarEstudiantes');
            exit;
        }
        
        // Verificar que el estudiante está asociado a un titular del usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        $titular = $this->titularModel->obtenerPorId($estudiante['titular_id']);
        
        if (!$titular || $titular['created_by'] != $usuario_id) {
            // Si no tiene permiso, redirigir
            header('Location: index.php?controller=usuario&action=listarEstudiantes');
            exit;
        }
        
        // Obtener cursos para el formulario
        $cursos = $this->cursoModel->obtenerTodos();
        
        // Obtener titulares para el formulario (solo los del usuario actual)
        $titulares = $this->titularModel->obtenerPorUsuario($usuario_id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del estudiante
            $datos_estudiante = [
                'cedula' => filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING),
                'nombres' => filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING),
                'apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING),
                'edad' => filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT),
                'curso_id' => filter_input(INPUT_POST, 'curso_id', FILTER_VALIDATE_INT),
                'talla' => filter_input(INPUT_POST, 'talla', FILTER_SANITIZE_STRING),
                'titular_id' => filter_input(INPUT_POST, 'titular_id', FILTER_VALIDATE_INT)
            ];
            
            // Verificar datos obligatorios
            if (!$datos_estudiante['nombres'] || !$datos_estudiante['apellidos'] || 
                !$datos_estudiante['edad'] || !$datos_estudiante['curso_id'] || 
                !$datos_estudiante['titular_id']) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos obligatorios.';
            } else {
                // Verificar que el nuevo titular pertenece al usuario actual
                $nuevo_titular = $this->titularModel->obtenerPorId($datos_estudiante['titular_id']);
                if (!$nuevo_titular || $nuevo_titular['created_by'] != $usuario_id) {
                    $error = true;
                    $mensaje = 'No tienes permiso para asociar este estudiante al titular seleccionado.';
                } else {
                    // Actualizar estudiante
                    $resultado = $this->estudianteModel->actualizar($id, $datos_estudiante);
                    
                    if ($resultado) {
                        $mensaje = 'Estudiante actualizado con éxito.';
                        
                        // Redirigir a la lista de estudiantes
                        header('Location: index.php?controller=usuario&action=listarEstudiantes&success=1');
                        exit;
                    } else {
                        $error = true;
                        $mensaje = 'Error al actualizar el estudiante. Verifica que la cédula no esté en uso.';
                    }
                }
            }
        }
        
        // Cargar vista de edición
        include 'views/usuario/editar_estudiante.php';
    }
    
    /**
     * Acción para procesar la actualización de un titular existente
     */
    public function actualizarTitular() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener ID del titular
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            
            if (!$id) {
                header('Location: index.php?controller=usuario&action=listarTitulares');
                exit;
            }
            
            // Verificar que el titular pertenece al usuario actual
            $usuario_id = $this->authController->getUsuarioId();
            $titular = $this->titularModel->obtenerPorId($id);
            
            if (!$titular || $titular['created_by'] != $usuario_id) {
                // Si no tiene permiso, redirigir
                header('Location: index.php?controller=usuario&action=listarTitulares');
                exit;
            }
            
            // Obtener datos del titular
            $datos_titular = [
                'cedula' => filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING),
                'nombres' => filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING),
                'apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING),
                'direccion' => filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'empresa' => filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING),
                'celular' => filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING),
                'telefono_casa' => filter_input(INPUT_POST, 'telefono_casa', FILTER_SANITIZE_STRING),
                'cargo' => filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING),
                'telefono_trabajo' => filter_input(INPUT_POST, 'telefono_trabajo', FILTER_SANITIZE_STRING)
            ];
            
            // Verificar datos obligatorios del titular
            if (!$datos_titular['cedula'] || !$datos_titular['nombres'] || !$datos_titular['apellidos'] || !$datos_titular['direccion']) {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=editarTitular&id=' . $id . '&error=1');
                exit;
            }
            
            // Actualizar el titular
            $resultado = $this->titularModel->actualizar($id, $datos_titular);
            
            if ($resultado) {
                // Redirigir a la lista de titulares con mensaje de éxito
                header('Location: index.php?controller=usuario&action=listarTitulares&success=1');
            } else {
                // Redirigir con error
                header('Location: index.php?controller=usuario&action=editarTitular&id=' . $id . '&error=1');
            }
            exit;
        } else {
            // Redirigir a la lista de titulares si no es POST
            header('Location: index.php?controller=usuario&action=listarTitulares');
            exit;
        }
    }
    
    /**
     * Acción para eliminar un estudiante
     */
    public function eliminarEstudiante() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener ID del estudiante a eliminar
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            
            if (!$id) {
                $this->responderJSON(false, 'ID de estudiante inválido');
                return;
            }
            
            // Verificar que el estudiante está asociado a un titular del usuario actual
            $usuario_id = $this->authController->getUsuarioId();
            $estudiante = $this->estudianteModel->obtenerPorId($id);
            
            if (!$estudiante) {
                $this->responderJSON(false, 'Estudiante no encontrado');
                return;
            }
            
            $titular = $this->titularModel->obtenerPorId($estudiante['titular_id']);
            
            if (!$titular || $titular['created_by'] != $usuario_id) {
                $this->responderJSON(false, 'No tienes permiso para eliminar este estudiante');
                return;
            }
            
            // Intentar eliminar el estudiante
            $resultado = $this->estudianteModel->eliminar($id);
            
            if ($resultado) {
                $this->responderJSON(true, 'Estudiante eliminado con éxito');
            } else {
                $this->responderJSON(false, 'Error al eliminar el estudiante');
            }
        } else {
            $this->responderJSON(false, 'Método no permitido');
        }
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