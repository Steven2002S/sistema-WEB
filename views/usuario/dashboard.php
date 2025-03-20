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
            <li class="menu-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=usuario&action=perfil'">
                <i class="fas fa-user"></i>
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
            <h1 class="page-title">Dashboard de Usuario</h1>
            <div class="user-badge">
                <?php echo htmlspecialchars($_SESSION['usuario_rol'] ?? 'Usuario'); ?>
            </div>
        </div>

        <div class="welcome-section">
            <h2 class="welcome-title">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario'); ?>!</h2>
            <p class="welcome-message">Este es tu portal personalizado. Aquí podrás acceder a tu información y gestionar tu perfil.</p>
        </div>

        <div class="info-cards">
            <div class="info-card">
                <h3 class="info-card-title">Mi Información</h3>
                <div class="info-card-content">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['usuario_email'] ?? 'No disponible'); ?></p>
                    <p><strong>Rol:</strong> <?php echo htmlspecialchars($_SESSION['usuario_rol'] ?? 'No disponible'); ?></p>
                    <p><strong>ID de Usuario:</strong> <?php echo htmlspecialchars($_SESSION['usuario_id'] ?? 'No disponible'); ?></p>
                </div>
            </div>
            
            <div class="info-card">
                <h3 class="info-card-title">Mi Perfil</h3>
                <div class="info-card-content">
                    <p>Puedes ver y actualizar tu información personal desde la sección "Mi Perfil".</p>
                    <p style="margin-top: 15px;">
                        <a href="index.php?controller=usuario&action=perfil" style="
                            display: inline-block;
                            padding: 8px 15px;
                            background-color: var(--primary-color);
                            color: white;
                            text-decoration: none;
                            border-radius: 4px;
                            font-weight: bold;
                        ">Ir a Mi Perfil</a>
                    </p>
                </div>
            </div>
            
            <div class="info-card">
                <h3 class="info-card-title">Datos de Usuario</h3>
                <div class="info-card-content">
                    <?php if (isset($usuario)): ?>
                        <p><strong>Cédula:</strong> <?php echo htmlspecialchars($usuario['cedula'] ?? 'No disponible'); ?></p>
                        <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($usuario['ciudad'] ?? 'No disponible'); ?></p>
                        <p><strong>País:</strong> <?php echo htmlspecialchars($usuario['pais'] ?? 'No disponible'); ?></p>
                        <p><strong>Organización:</strong> <?php echo htmlspecialchars($usuario['organizacion'] ?? 'No disponible'); ?></p>
                    <?php else: ?>
                        <p>Información detallada no disponible. Accede a "Mi Perfil" para ver todos tus datos.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="footer">
            Sistema de Gestión de Usuarios - GestUsers © <?php echo date('Y'); ?>
        </div>
    </div>
</body>
</html>