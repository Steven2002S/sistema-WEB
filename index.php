<?php
// Configuración de errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar clases necesarias
require_once 'config/Database.php';
require_once 'models/SuperAdminModel.php';
require_once 'models/UsuarioModel.php';
require_once 'models/CursoModel.php';
require_once 'models/RolModel.php';
require_once 'models/TitularModel.php';
require_once 'models/EstudianteModel.php';
require_once 'models/ReferenciaModel.php';
require_once 'models/ContratoModel.php';
require_once 'models/ConsecutivoModel.php';
require_once 'models/ReciboModel.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/SuperAdminController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/FinanzasController.php';

// Iniciar sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Obtener controlador y acción de la URL
$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

// Inicializar conexión a la base de datos
$database = new Database();

// Crear instancia del controlador de autenticación
$authController = new AuthController($database);

// Router básico
try {
    switch ($controller) {
        case 'auth':
            switch ($action) {
                case 'login':
                    $authController->login();
                    break;
                case 'logout':
                    $authController->logout();
                    break;
                default:
                    // Si la acción no existe, mostrar página de login
                    include 'views/login.html';
                    break;
            }
            break;
            
        case 'superadmin':
            $superAdminController = new SuperAdminController($database, $authController);
            
            switch ($action) {
                case 'dashboard':
                    $superAdminController->dashboard();
                    break;
                case 'usuarios':
                case 'listarUsuarios':
                    $superAdminController->listarUsuarios();
                    break;
                case 'crear_usuario':
                    $superAdminController->crearUsuario();
                    break;
                case 'editar_usuario':
                    $superAdminController->editarUsuario();
                    break;
                case 'ver_usuario':
                    $superAdminController->ver_usuario();
                    break;
                case 'eliminar_usuario':
                    $superAdminController->eliminarUsuario();
                    break;
                case 'cambiar_estado_usuario':
                    $superAdminController->cambiarEstadoUsuario();
                    break;
                case 'listarCursos':
                    $superAdminController->listarCursos();
                    break;
                case 'crearCurso':
                    $superAdminController->crearCurso();
                    break;
                case 'editarCurso':
                    $superAdminController->editarCurso();
                    break;
                case 'verCurso':
                    $superAdminController->verCurso();
                    break;
                case 'eliminarCurso':
                    $superAdminController->eliminarCurso();
                    break;
                case 'cambiarEstadoCurso':
                    $superAdminController->cambiarEstadoCurso();
                    break;
                case 'roles':
                case 'gestionarRoles':
                    $superAdminController->gestionarRoles();
                    break;
                case 'crear_rol':
                    $superAdminController->crearRol();
                    break;
                case 'editar_rol':
                    $superAdminController->editarRol();
                    break;
                case 'eliminar_rol':
                    $superAdminController->eliminarRol();
                    break;
                case 'estadisticas':
                    $superAdminController->estadisticas();
                    break;
                case 'perfil':
                    $superAdminController->verPerfil();
                    break;
                case 'actualizar_perfil':
                    $superAdminController->actualizarPerfil();
                    break;
                default:
                    // Si la acción no existe, mostrar dashboard
                    $superAdminController->dashboard();
                    break;
            }
            break;
            
        case 'usuario':
            $userController = new UserController($database, $authController);
            
            switch ($action) {
                case 'dashboard':
                    $userController->dashboard();
                    break;
                case 'perfil':
                    $userController->verPerfil();
                    break;
                case 'actualizar_perfil':
                    $userController->actualizarPerfil();
                    break;
                // Titulares
                case 'listarTitulares':
                    $userController->listarTitulares();
                    break;
                case 'crearTitular':
                    $userController->crearTitular();
                    break;
                case 'verTitular':
                    $userController->verTitular();
                    break;
                case 'editarTitular':
                    $userController->editarTitular();
                    break;
                case 'actualizarTitular':
                    $userController->actualizarTitular();
                    break;
                case 'eliminarTitular':
                    $userController->eliminarTitular();
                    break;
                // Estudiantes
                case 'listarEstudiantes':
                    $userController->listarEstudiantes();
                    break;
                case 'crearEstudiante':
                    $userController->crearEstudiante();
                    break;
                case 'crearEstudianteInline':
                    $userController->crearEstudianteInline();
                    break;
                case 'editarEstudiante':
                    $userController->editarEstudiante();
                    break;
                case 'eliminarEstudiante':
                    $userController->eliminarEstudiante();
                    break;
                // Referencias
                case 'crearReferencia':
                    $userController->crearReferencia();
                    break;
                case 'actualizarReferencia':
                    $userController->actualizarReferencia();
                    break;
                default:
                    // Si la acción no existe, mostrar dashboard
                    $userController->dashboard();
                    break;
            }
            break;
            
        case 'finanzas':
            $finanzasController = new FinanzasController($database, $authController);
            
            switch ($action) {
                case 'dashboard':
                    $finanzasController->dashboard();
                    break;
                case 'listarContratos':
                    $finanzasController->listarContratos();
                    break;
                case 'crearContrato':
                    $finanzasController->crearContrato();
                    break;
                case 'verContrato':
                    $finanzasController->verContrato();
                    break;
                case 'editarContrato':
                    $finanzasController->editarContrato();
                    break;
                case 'eliminarContrato':
                    $finanzasController->eliminarContrato();
                    break;
                case 'verRecibo':
                    $finanzasController->verRecibo();
                    break;
                case 'informeFacturacion':
                    $finanzasController->informeFacturacion();
                    break;
                case 'getEstudiantesPorTitular':
                    $finanzasController->getEstudiantesPorTitular();
                    break;
                default:
                    $finanzasController->dashboard();
                    break;
            }
            break;
            
        default:
            // Si el controlador no existe, mostrar página de login
            include 'views/login.html';
            break;
    }
} catch (Exception $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}

// Cerrar conexión a la base de datos
$database->close();
?>