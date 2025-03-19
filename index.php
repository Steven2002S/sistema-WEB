<?php
// Iniciar sesión
session_start();

// Incluir archivos de configuración
require_once 'config/Database.php';

// Incluir modelos
require_once 'models/SuperAdminModel.php';
require_once 'models/UsuarioModel.php';

// Incluir controladores
require_once 'controllers/AuthController.php';
require_once 'controllers/UserController.php';

// Crear instancia de la base de datos
$database = new Database();
$db = $database->getConnection();

// Obtener controlador y acción de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'showLogin';

// Enrutamiento básico
switch ($controller) {
    case 'auth':
        $authController = new AuthController($db);
        
        switch ($action) {
            case 'showLogin':
                // Mostrar la página de login
                include 'views/login.html';
                break;
                
            case 'login':
                // Procesar el login
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                
                $result = $authController->login($email, $password);
                
                // Devolver resultado como JSON para la petición AJAX
                header('Content-Type: application/json');
                echo json_encode($result);
                break;
                
            case 'logout':
                $result = $authController->logout();
                header('Location: ' . $result['redirect']);
                break;
                
            default:
                // Acción no encontrada
                header('HTTP/1.0 404 Not Found');
                echo 'Acción no encontrada';
                break;
        }
        break;
        
    case 'user':
        $userController = new UserController($db);
        
        // Verificar si hay sesión activa
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=showLogin');
            exit;
        }
        
        switch ($action) {
            case 'create':
                // Procesar la creación de un usuario
                $result = $userController->create($_POST);
                
                // Devolver resultado como JSON para la petición AJAX
                header('Content-Type: application/json');
                echo json_encode($result);
                break;
                
            case 'list':
                // Obtener la lista de usuarios
                $result = $userController->listUsuarios();
                
                if ($result['success']) {
                    // Si es una petición AJAX
                    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode($result);
                    } else {
                        // Si es una petición normal, mostrar la vista
                        $usuarios = $result['usuarios'];
                        include 'views/superadmin/listadoUsers.php';
                    }
                } else {
                    // Error
                    header('Content-Type: application/json');
                    echo json_encode($result);
                }
                break;
                
            default:
                // Acción no encontrada
                header('HTTP/1.0 404 Not Found');
                echo 'Acción no encontrada';
                break;
        }
        break;
        
    case 'dashboard':
        // Verificar si hay sesión activa
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
            header('Location: index.php?controller=auth&action=showLogin');
            exit;
        }
        
        // Cargar el dashboard según el tipo de usuario
        if ($_SESSION['user_type'] === 'superadmin') {
            include 'views/superadmin/dashboard.php';
        } else {
            include 'views/usuario/dashboard.php';
        }
        break;
        
    default:
        // Controlador no encontrado
        header('HTTP/1.0 404 Not Found');
        echo 'Controlador no encontrado';
        break;
}

// Cerrar la conexión a la base de datos
$database->close();
?>