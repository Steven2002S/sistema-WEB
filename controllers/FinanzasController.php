<?php
class FinanzasController {
    private $db;
    private $authController;
    private $usuarioModel;
    private $titularModel;
    private $estudianteModel;
    private $contratoModel;
    private $consecutivoModel;
    private $reciboModel;
    
    /**
     * Constructor del controlador de finanzas
     * @param Database $database Instancia de la clase Database
     * @param AuthController $authController Instancia del controlador de autenticación
     */
    public function __construct($database, $authController) {
        $this->db = $database;
        $this->authController = $authController;
        $this->usuarioModel = new UsuarioModel($database);
        $this->titularModel = new TitularModel($database);
        $this->estudianteModel = new EstudianteModel($database);
        $this->contratoModel = new ContratoModel($database);
        $this->consecutivoModel = new ConsecutivoModel($database);
        $this->reciboModel = new ReciboModel($database);
        
        // Verificar que el usuario esté autenticado en cada acción
        $this->verificarAutenticacion();
    }
    
    /**
     * Verificar que el usuario esté autenticado
     */
    private function verificarAutenticacion() {
        if (!$this->authController->estaAutenticado()) {
            // Redirigir al login si no está autenticado
            header('Location: index.php?controller=auth&action=logout');
            exit;
        }
    }
    
    /**
     * Acción para mostrar el dashboard de finanzas
     */
    public function dashboard() {
        // Obtener datos del usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        $usuario = $this->usuarioModel->obtenerPorId($usuario_id);
        
        // Obtener estadísticas según el tipo de usuario
        if ($this->authController->esSuperAdmin()) {
            // Para superadmin, obtener estadísticas generales
            $contratos = $this->contratoModel->obtenerTodos();
            $consecutivos = $this->consecutivoModel->obtenerTodosConsecutivosGenerales();
        } else {
            // Para usuario normal, obtener solo sus contratos
            $contratos = $this->contratoModel->obtenerPorUsuario($usuario_id);
            
            // Obtener consecutivo mensual
            $consecutivo_mensual = $this->consecutivoModel->obtenerConsecutivoMensual($usuario_id);
            
            // Obtener consecutivo general
            $consecutivo_general = $this->consecutivoModel->obtenerConsecutivoGeneral($usuario_id);
        }
        
        // Cargar la vista correspondiente según el tipo de usuario
        if ($this->authController->esSuperAdmin()) {
            include 'views/superadmin/finanzas_dashboard.php';
        } else {
            include 'views/usuario/finanzas_dashboard.php';
        }
    }
    
    /**
     * Acción para listar todos los contratos
     */
    public function listarContratos() {
        // Obtener datos del usuario actual
$usuario_id = $this->authController->getUsuarioId();
$usuario = $this->usuarioModel->obtenerPorId($usuario_id);
        // Obtener contratos según el tipo de usuario
        if ($this->authController->esSuperAdmin()) {
            // Para superadmin, obtener todos los contratos
            $contratos = $this->contratoModel->obtenerTodos();
            include 'views/superadmin/listar_contratos.php';
        } else {
            // Para usuario normal, obtener solo sus contratos
            $contratos = $this->contratoModel->obtenerPorUsuario($usuario_id);
            include 'views/usuario/listar_contratos.php';
        }
    }
    
    /**
     * Acción para crear un nuevo contrato
     */
    public function crearContrato() {
        $mensaje = '';
        $error = false;
        
        // Obtener ID del usuario actual
        $usuario_id = $this->authController->getUsuarioId();
        $usuario = $this->usuarioModel->obtenerPorId($usuario_id);
        
        // Verificar si es superadmin
        $es_superadmin = $this->authController->esSuperAdmin();
        
        // Obtener listas para el formulario
        if ($es_superadmin) {
            // Si es superadmin, mostrar todos los titulares
            $titulares = $this->titularModel->listarTodos();
        } else {
            // Si es usuario normal, mostrar solo sus titulares
            $titulares = $this->titularModel->obtenerPorUsuario($usuario_id);
        }
        
        // Obtener ID del titular de la URL (si existe)
        $titular_id = filter_input(INPUT_GET, 'titular_id', FILTER_VALIDATE_INT);
        
        // Lista de estudiantes (inicialmente vacía)
        $estudiantes = [];
        
        // Si se proporciona un titular_id, obtener sus estudiantes
        if ($titular_id) {
            $estudiantes = $this->estudianteModel->obtenerPorTitular($titular_id);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $fecha_emision = filter_input(INPUT_POST, 'fecha_emision');
            $mes_pagado = filter_input(INPUT_POST, 'mes_pagado', FILTER_SANITIZE_STRING);
            $forma_pago = filter_input(INPUT_POST, 'forma_pago', FILTER_SANITIZE_STRING);
            $banco = filter_input(INPUT_POST, 'banco', FILTER_SANITIZE_STRING);
            $organizacion = filter_input(INPUT_POST, 'organizacion', FILTER_SANITIZE_STRING);
            $cantidad_recibida = filter_input(INPUT_POST, 'cantidad_recibida', FILTER_VALIDATE_FLOAT);
            $titular_id = filter_input(INPUT_POST, 'titular_id', FILTER_VALIDATE_INT);
            $estudiante_id = filter_input(INPUT_POST, 'estudiante_id', FILTER_VALIDATE_INT);
            
            // Verificar datos obligatorios
            if (!$fecha_emision || !$mes_pagado || !$forma_pago || !$cantidad_recibida || !$titular_id || !$estudiante_id) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos obligatorios.';
            } else {
                // Si forma de pago es cheque o transferencia, el banco es obligatorio
                if (($forma_pago == 'cheque' || $forma_pago == 'transferencia') && empty($banco)) {
                    $error = true;
                    $mensaje = 'Por favor, especifica el banco para esta forma de pago.';
                } else {
                    // Preparar datos para el contrato
                    $datos_contrato = [
                        'fecha_emision' => $fecha_emision,
                        'mes_pagado' => $mes_pagado,
                        'forma_pago' => $forma_pago,
                        'banco' => $banco,
                        'organizacion' => $organizacion,
                        'cantidad_recibida' => $cantidad_recibida,
                        'verificado_por' => $usuario_id,
                        'ejecutivo' => $usuario_id, // Por defecto, el mismo usuario
                        'titular_id' => $titular_id,
                        'estudiante_id' => $estudiante_id
                    ];
                    
                    // Crear el contrato
                    $contrato_id = $this->contratoModel->crear($datos_contrato);
                    
                    if ($contrato_id) {
                        // Obtener datos del titular para el recibo
                        $titular = $this->titularModel->obtenerPorId($titular_id);
                        $recibo_por = $titular['nombres'] . ' ' . $titular['apellidos'];
                        
                        // Crear recibo automáticamente
                        $datos_recibo = [
                            'contrato_id' => $contrato_id,
                            'recibo_por' => $recibo_por,
                            'responsable_id' => $usuario_id
                        ];
                        
                        $recibo_id = $this->reciboModel->crear($datos_recibo);
                        
                        if ($recibo_id) {
                            $mensaje = 'Contrato y recibo creados con éxito.';
                            
                            // Redirigir a la lista de contratos
                            header('Location: index.php?controller=finanzas&action=dashboard&success=1');
                            exit;
                        } else {
                            $error = true;
                            $mensaje = 'Contrato creado, pero hubo un error al generar el recibo.';
                        }
                    } else {
                        $error = true;
                        $mensaje = 'Error al crear el contrato.';
                    }
                }
            }
            
            // Si se seleccionó un titular, recargar sus estudiantes
            if ($titular_id) {
                $estudiantes = $this->estudianteModel->obtenerPorTitular($titular_id);
            }
        }
        
        // Cargar vista según el tipo de usuario
        if ($es_superadmin) {
            include 'views/superadmin/crear_contrato.php';
        } else {
            include 'views/usuario/crear_contrato.php';
        }
    }
    
    /**
 * Acción para ver los detalles de un contrato
 */
public function verContrato() {
    // Obtener ID del contrato
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id) {
        header('Location: index.php?controller=finanzas&action=listarContratos');
        exit;
    }
    
    // Obtener datos del contrato
    $contrato = $this->contratoModel->obtenerPorId($id);
    
    if (!$contrato) {
        header('Location: index.php?controller=finanzas&action=listarContratos');
        exit;
    }
    
    // Obtener datos del usuario actual (ESTA ES LA LÍNEA IMPORTANTE QUE FALTA)
    $usuario_id = $this->authController->getUsuarioId();
    $usuario = $this->usuarioModel->obtenerPorId($usuario_id);
    
    // Verificar permisos si no es superadmin
    if (!$this->authController->esSuperAdmin()) {
        // Solo puede ver contratos donde sea verificador o ejecutivo
        if ($contrato['verificado_por'] != $usuario_id && $contrato['ejecutivo'] != $usuario_id) {
            header('Location: index.php?controller=finanzas&action=listarContratos');
            exit;
        }
    }
    
    // Obtener recibos asociados al contrato
    $recibos = $this->reciboModel->obtenerPorContrato($id);
    
    // Cargar vista según el tipo de usuario
    if ($this->authController->esSuperAdmin()) {
        include 'views/superadmin/ver_contrato.php';
    } else {
        include 'views/usuario/ver_contrato.php';
    }
}
    
    /**
     * Acción para editar un contrato existente
     */
    public function editarContrato() {
        $mensaje = '';
        $error = false;
        
        // Obtener ID del contrato
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            header('Location: index.php?controller=finanzas&action=listarContratos');
            exit;
        }
        
        // Obtener datos del contrato
        $contrato = $this->contratoModel->obtenerPorId($id);
        
        if (!$contrato) {
            header('Location: index.php?controller=finanzas&action=listarContratos');
            exit;
        }
        
        // Verificar permisos si no es superadmin
        $es_superadmin = $this->authController->esSuperAdmin();
        $usuario_id = $this->authController->getUsuarioId();
        
        // Obtener datos del usuario actual
        $usuario = $this->usuarioModel->obtenerPorId($usuario_id);
        
        if (!$es_superadmin) {
            // Solo puede editar contratos donde sea verificador o ejecutivo
            if ($contrato['verificado_por'] != $usuario_id && $contrato['ejecutivo'] != $usuario_id) {
                header('Location: index.php?controller=finanzas&action=listarContratos');
                exit;
            }
        }
        
        // Obtener listas para el formulario
        if ($es_superadmin) {
            // Si es superadmin, mostrar todos los titulares
            $titulares = $this->titularModel->listarTodos();
        } else {
            // Si es usuario normal, mostrar solo sus titulares
            $titulares = $this->titularModel->obtenerPorUsuario($usuario_id);
        }
        
        // Obtener estudiantes del titular actual
        $estudiantes = $this->estudianteModel->obtenerPorTitular($contrato['titular_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $fecha_emision = filter_input(INPUT_POST, 'fecha_emision');
            $mes_pagado = filter_input(INPUT_POST, 'mes_pagado', FILTER_SANITIZE_STRING);
            $forma_pago = filter_input(INPUT_POST, 'forma_pago', FILTER_SANITIZE_STRING);
            $banco = filter_input(INPUT_POST, 'banco', FILTER_SANITIZE_STRING);
            $organizacion = filter_input(INPUT_POST, 'organizacion', FILTER_SANITIZE_STRING);
            $cantidad_recibida = filter_input(INPUT_POST, 'cantidad_recibida', FILTER_VALIDATE_FLOAT);
            $titular_id = filter_input(INPUT_POST, 'titular_id', FILTER_VALIDATE_INT);
            $estudiante_id = filter_input(INPUT_POST, 'estudiante_id', FILTER_VALIDATE_INT);
            
            // Verificar datos obligatorios
            if (!$fecha_emision || !$mes_pagado || !$forma_pago || !$cantidad_recibida || !$titular_id || !$estudiante_id) {
                $error = true;
                $mensaje = 'Por favor, completa todos los campos obligatorios.';
            } else {
                // Si forma de pago es cheque o transferencia, el banco es obligatorio
                if (($forma_pago == 'cheque' || $forma_pago == 'transferencia') && empty($banco)) {
                    $error = true;
                    $mensaje = 'Por favor, especifica el banco para esta forma de pago.';
                } else {
                    // Preparar datos para actualizar el contrato
                    $datos_contrato = [
                        'fecha_emision' => $fecha_emision,
                        'mes_pagado' => $mes_pagado,
                        'forma_pago' => $forma_pago,
                        'banco' => $banco,
                        'organizacion' => $organizacion,
                        'cantidad_recibida' => $cantidad_recibida,
                        'titular_id' => $titular_id,
                        'estudiante_id' => $estudiante_id
                    ];
                    
                    // Actualizar el contrato
                    $resultado = $this->contratoModel->actualizar($id, $datos_contrato);
                    
                    if ($resultado) {
                        $mensaje = 'Contrato actualizado con éxito.';
                        
                        // Recargar datos del contrato
                        $contrato = $this->contratoModel->obtenerPorId($id);
                        
                        // Redirigir a la lista de contratos después de actualizar
                        header('Location: index.php?controller=finanzas&action=dashboard&success=1');
                        exit;
                    } else {
                        $error = true;
                        $mensaje = 'Error al actualizar el contrato.';
                    }
                }
            }
            
            // Si se cambió el titular, recargar sus estudiantes
            if ($titular_id && $titular_id != $contrato['titular_id']) {
                $estudiantes = $this->estudianteModel->obtenerPorTitular($titular_id);
            }
        }
        
        // Cargar vista según el tipo de usuario
        if ($es_superadmin) {
            include 'views/superadmin/editar_contrato.php';
        } else {
            include 'views/usuario/editar_contrato.php';
        }
    }
    /**
     * Acción para eliminar un contrato
     */
    public function eliminarContrato() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener ID del contrato a eliminar
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            
            if (!$id) {
                $this->responderJSON(false, 'ID de contrato inválido');
                return;
            }
            
            // Verificar permisos si no es superadmin
            if (!$this->authController->esSuperAdmin()) {
                $usuario_id = $this->authController->getUsuarioId();
                $contrato = $this->contratoModel->obtenerPorId($id);
                
                if (!$contrato || ($contrato['verificado_por'] != $usuario_id && $contrato['ejecutivo'] != $usuario_id)) {
                    $this->responderJSON(false, 'No tienes permiso para eliminar este contrato');
                    return;
                }
            }
            
            // Intentar eliminar el contrato (esto también eliminará los recibos asociados)
            $resultado = $this->contratoModel->eliminar($id);
            
            if ($resultado) {
                $this->responderJSON(true, 'Contrato y recibos asociados eliminados con éxito');
            } else {
                $this->responderJSON(false, 'Error al eliminar el contrato');
            }
        } else {
            $this->responderJSON(false, 'Método no permitido');
        }
    }
    
    /**
     * Acción para ver un recibo
     */
    public function verRecibo() {
        // Obtener ID del recibo
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            header('Location: index.php?controller=finanzas&action=listarContratos');
            exit;
        }
        
        // Obtener datos del recibo
        $recibo = $this->reciboModel->obtenerPorId($id);
        
        if (!$recibo) {
            header('Location: index.php?controller=finanzas&action=listarContratos');
            exit;
        }
        
        // Verificar permisos si no es superadmin
        if (!$this->authController->esSuperAdmin()) {
            $usuario_id = $this->authController->getUsuarioId();
            
            if ($recibo['responsable_id'] != $usuario_id) {
                header('Location: index.php?controller=finanzas&action=listarContratos');
                exit;
            }
        }
        
        // Cargar vista según el tipo de usuario
        if ($this->authController->esSuperAdmin()) {
            include 'views/superadmin/ver_recibo.php';
        } else {
            include 'views/usuario/ver_recibo.php';
        }
    }
    
    /**
     * Acción para mostrar el informe de facturación (solo para superadmin)
     */
    public function informeFacturacion() {
        // Verificar que el usuario sea superadmin
        if (!$this->authController->esSuperAdmin()) {
            header('Location: index.php?controller=finanzas&action=dashboard');
            exit;
        }
        
        // Parámetros de filtrado
        $fecha_inicio = filter_input(INPUT_GET, 'fecha_inicio');
        $fecha_fin = filter_input(INPUT_GET, 'fecha_fin');
        $usuario_id = filter_input(INPUT_GET, 'usuario_id', FILTER_VALIDATE_INT);
        
        // Consulta base
        $query = "SELECT c.*, u.cedula AS usuario_cedula, u.correo AS usuario_correo, 
                  cg.consecutivo AS consecutivo_general,
                  t.cedula AS titular_cedula, t.nombres AS titular_nombres, t.apellidos AS titular_apellidos,
                  e.cedula AS estudiante_cedula, e.nombres AS estudiante_nombres, e.apellidos AS estudiante_apellidos,
                  u.nombres AS usuario_nombres, u.apellidos AS usuario_apellidos
                  FROM contratos c
                  INNER JOIN titulares t ON c.titular_id = t.id
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  INNER JOIN usuarios u ON c.verificado_por = u.id
                  LEFT JOIN consecutivos_generales cg ON c.verificado_por = cg.usuario_id
                  WHERE 1=1";
        
        $params = [];
        $types = "";
        
        // Aplicar filtros
        if ($fecha_inicio) {
            $query .= " AND c.fecha_emision >= ?";
            $params[] = $fecha_inicio;
            $types .= "s";
        }
        
        if ($fecha_fin) {
            $query .= " AND c.fecha_emision <= ?";
            $params[] = $fecha_fin;
            $types .= "s";
        }
        
        if ($usuario_id) {
            $query .= " AND c.verificado_por = ?";
            $params[] = $usuario_id;
            $types .= "i";
        }
        
        // Ordenamiento
        $query .= " ORDER BY c.created_at DESC";
        
        // Preparar y ejecutar consulta
        $stmt = $this->db->prepare($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $facturas = [];
        
        while ($row = $result->fetch_assoc()) {
            $facturas[] = $row;
        }
        
        // Obtener lista de usuarios para el filtro
        $usuarios = $this->usuarioModel->listarTodos();
        
        // Cargar vista de informe de facturación
        include 'views/superadmin/informe_facturacion.php';
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
     * Acción para obtener estudiantes por titular (para AJAX)
     */
    public function getEstudiantesPorTitular() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Obtener ID del titular
            $titular_id = filter_input(INPUT_GET, 'titular_id', FILTER_VALIDATE_INT);
            
            if (!$titular_id) {
                $this->responderJSON(false, 'ID de titular inválido');
                return;
            }
            
            // Obtener estudiantes del titular
            $estudiantes = $this->estudianteModel->obtenerPorTitular($titular_id);
            
            $this->responderJSON(true, 'Estudiantes obtenidos con éxito', ['estudiantes' => $estudiantes]);
        } else {
            $this->responderJSON(false, 'Método no permitido');
        }
    }
    /**
 * Acción para mostrar el historial de pagos
 */
public function historialPagos() {
    // Obtener datos del usuario actual
    $usuario_id = $this->authController->getUsuarioId();
    $usuario = $this->usuarioModel->obtenerPorId($usuario_id);
    
    // Parámetros de filtrado
    $titular_id = filter_input(INPUT_GET, 'titular_id', FILTER_VALIDATE_INT);
    $estudiante_id = filter_input(INPUT_GET, 'estudiante_id', FILTER_VALIDATE_INT);
    $fecha_inicio = filter_input(INPUT_GET, 'fecha_inicio');
    $fecha_fin = filter_input(INPUT_GET, 'fecha_fin');
    
    // Consulta base
    $query = "SELECT c.*, 
              t.cedula AS titular_cedula, t.nombres AS titular_nombres, t.apellidos AS titular_apellidos,
              e.cedula AS estudiante_cedula, e.nombres AS estudiante_nombres, e.apellidos AS estudiante_apellidos
              FROM contratos c
              INNER JOIN titulares t ON c.titular_id = t.id
              INNER JOIN estudiantes e ON c.estudiante_id = e.id
              WHERE (c.verificado_por = ? OR c.ejecutivo = ?)";
    
    $params = [$usuario_id, $usuario_id];
    $types = "ii";
    
    // Aplicar filtros
    if ($titular_id) {
        $query .= " AND c.titular_id = ?";
        $params[] = $titular_id;
        $types .= "i";
    }
    
    if ($estudiante_id) {
        $query .= " AND c.estudiante_id = ?";
        $params[] = $estudiante_id;
        $types .= "i";
    }
    
    if ($fecha_inicio) {
        $query .= " AND c.fecha_emision >= ?";
        $params[] = $fecha_inicio;
        $types .= "s";
    }
    
    if ($fecha_fin) {
        $query .= " AND c.fecha_emision <= ?";
        $params[] = $fecha_fin;
        $types .= "s";
    }
    
    // Ordenamiento
    $query .= " ORDER BY c.fecha_emision DESC";
    
    // Preparar y ejecutar consulta
    $stmt = $this->db->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $pagos = [];
    
    while ($row = $result->fetch_assoc()) {
        $pagos[] = $row;
    }
    
    // Obtener titulares y estudiantes para los filtros
    $titulares = $this->titularModel->obtenerPorUsuario($usuario_id);
    $estudiantes = [];
    
    if ($titular_id) {
        $estudiantes = $this->estudianteModel->obtenerPorTitular($titular_id);
    }
    
    // Cargar vista de historial de pagos
    include 'views/usuario/historial_pagos.php';
}
}
?>