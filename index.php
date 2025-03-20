<?php
// Configuración de errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar clases necesarias
require_once 'config/Database.php';
require_once 'models/SuperAdminModel.php';
require_once 'models/UsuarioModel.php';
require_once 'models/RolModel.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/SuperAdminController.php';
require_once 'controllers/UserController.php';

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
                default:
                    // Si la acción no existe, mostrar dashboard
                    $userController->dashboard();
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