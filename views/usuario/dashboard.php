<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Usuario - GestUsers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0077c2;
            --secondary-color: #0099ff;
            --accent-color: #ffd600;
            --text-color: #333333;
            --light-text: #ffffff;
            --background-color: #f5f5f5;
            --card-color: #ffffff;
            --border-color: #e0e0e0;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
        }
        
        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: var(--primary-color);
            color: var(--light-text);
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }
        
        .logo {
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .user-details {
            flex-grow: 1;
        }
        
        .user-role {
            font-size: 12px;
            opacity: 0.7;
        }
        
        .menu {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        
        .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .logout {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        
        .logout i {
            margin-right: 10px;
        }
        
        /* Main Content */
        .main-content {
            flex-grow: 1;
            margin-left: 220px;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 24px;
            color: var(--text-color);
        }
        
        .user-badge {
            background-color: var(--accent-color);
            color: var(--text-color);
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
        }
        
        /* Welcome Section */
        .welcome-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .welcome-title {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--primary-color);
        }
        
        .welcome-message {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .action-button {
            padding: 12px 24px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }
        
        .action-button:hover {
            background-color: var(--secondary-color);
        }
        
        .action-button i {
            margin-right: 8px;
        }
        
        /* Info Cards */
        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-card {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            border-left: 4px solid var(--primary-color);
        }
        
        .info-card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: var(--primary-color);
        }
        
        .info-card-content {
            font-size: 14px;
            line-height: 1.5;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
            border-top: 1px solid var(--border-color);
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">GestUsers</div>
        <div class="user-info">
            <div class="user-avatar">
                <?php 
                    // Mostrar iniciales del usuario
                    $iniciales = "";
                    if (!empty($_SESSION['usuario_nombre'])) {
                        $nombres = explode(' ', $_SESSION['usuario_nombre']);
                        foreach ($nombres as $nombre) {
                            if (!empty($nombre)) {
                                $iniciales .= substr($nombre, 0, 1);
                                if (strlen($iniciales) >= 2) break;
                            }
                        }
                    }
                    echo htmlspecialchars($iniciales);
                ?>
            </div>
            <div class="user-details">
                <div class="user-name"><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario'); ?></div>
                <div class="user-role"><?php echo htmlspecialchars($_SESSION['usuario_rol'] ?? 'Usuario'); ?></div>
            </div>
        </div>
        <ul class="menu">
            <li class="menu-item active" onclick="location.href='index.php?controller=usuario&action=dashboard'">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=usuario&action=listarTitulares'">
                <i class="fas fa-user-tie"></i>
                <span>Titulares</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=usuario&action=listarEstudiantes'">
                <i class="fas fa-user-graduate"></i>
                <span>Estudiantes</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=finanzas&action=dashboard'">
                <i class="fas fa-dollar-sign"></i>
                <span>Finanzas</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=usuario&action=perfil'">
                <i class="fas fa-cog"></i>
                <span>Mi Perfil</span>
            </li>
        </ul>
        <div class="logout" onclick="location.href='index.php?controller=auth&action=logout'">
            <i class="fas fa-sign-out-alt"></i>
            <span>Cerrar Sesión</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1 class="page-title">Bienvenido</h1>
            <div class="user-badge">
                <?php echo htmlspecialchars($_SESSION['usuario_rol'] ?? 'Usuario'); ?>
            </div>
        </div>

        <div class="welcome-section">
            <h2 class="welcome-title">¡Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario'); ?>!</h2>
            <p class="welcome-message">Bienvenido al sistema de gestión. Por favor seleccione una de las opciones para continuar.</p>
            
            <div class="action-buttons">
                <a href="index.php?controller=usuario&action=listarTitulares" class="action-button">
                    <i class="fas fa-user-tie"></i> Gestionar Titulares
                </a>
                <a href="index.php?controller=usuario&action=listarEstudiantes" class="action-button">
                    <i class="fas fa-user-graduate"></i> Gestionar Estudiantes
                </a>
                <a href="index.php?controller=finanzas&action=dashboard" class="action-button" style="background-color: var(--success-color);">
                    <i class="fas fa-dollar-sign"></i> Gestionar Finanzas
                </a>
            </div>
        </div>

        <div class="info-cards">
            <div class="info-card">
                <h3 class="info-card-title">Gestión de Titulares</h3>
                <div class="info-card-content">
                    <p>En esta sección podrá registrar nuevos titulares, cada uno puede tener hasta 10 estudiantes asociados.</p>
                    <p>También podrá editar la información de los titulares existentes y sus estudiantes.</p>
                </div>
            </div>
            
            <div class="info-card">
                <h3 class="info-card-title">Gestión de Estudiantes</h3>
                <div class="info-card-content">
                    <p>Aquí podrá ver todos los estudiantes registrados en el sistema.</p>
                    <p>Puede filtrar por cursos, editar sus datos y más.</p>
                </div>
            </div>
            
            <div class="info-card">
                <h3 class="info-card-title">Gestión de Finanzas</h3>
                <div class="info-card-content">
                    <p>Registre y administre los pagos de los titulares y estudiantes.</p>
                    <p>Genere contratos y recibos automáticamente para cada transacción.</p>
                    <p><a href="index.php?controller=finanzas&action=crearContrato" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">Crear nuevo contrato</a></p>
                </div>
            </div>
            
            <div class="info-card">
                <h3 class="info-card-title">Mi Información</h3>
                <div class="info-card-content">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['usuario_email'] ?? 'No disponible'); ?></p>
                    <p><strong>Rol:</strong> <?php echo htmlspecialchars($_SESSION['usuario_rol'] ?? 'No disponible'); ?></p>
                    <p>Puede actualizar su información personal en la sección <a href="index.php?controller=usuario&action=perfil" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">Mi Perfil</a>.</p>
                </div>
            </div>
        </div>

        <div class="footer">
            Sistema de Gestión de Usuarios - GestUsers © <?php echo date('Y'); ?>
        </div>
    </div>
</body>
</html>