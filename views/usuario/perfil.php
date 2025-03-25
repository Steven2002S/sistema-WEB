<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0077c2;
            --primary-dark: #005a9e;
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
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .admin-info {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: linear-gradient(to right, rgba(0, 0, 0, 0.05), transparent);
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .admin-details {
            flex-grow: 1;
            overflow: hidden;
        }
        
        .admin-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
        }
        
        .admin-role {
            font-size: 12px;
            opacity: 0.7;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            position: relative;
            overflow: hidden;
        }
        
        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--accent-color);
        }
        
        .menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1em;
        }
        
        .logout {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            background-color: var(--primary-dark);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .logout:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }
        
        .logout i {
            margin-right: 10px;
        }
        
        /* Main Content */
        .main-content {
            flex-grow: 1;
            margin-left: 220px;
            padding: 30px;
            position: relative;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }
        
        .page-title {
            font-size: 28px;
            color: var(--primary-color);
            font-weight: 600;
            position: relative;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }
        
        .user-badge {
            background: linear-gradient(135deg, var(--accent-color), #ffa000);
            color: var(--text-color);
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(255, 214, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .user-badge i {
            font-size: 1.1em;
        }
        
        /* Profile Section */
        .profile-section {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .profile-card {
            background-color: var(--card-color);
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s;
            flex: 1;
            min-width: 300px;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            position: relative;
        }
        
        .profile-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .profile-subtitle {
            opacity: 0.8;
            font-size: 14px;
        }
        
        .profile-icon {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            opacity: 0.2;
        }
        
        .profile-content {
            padding: 20px;
        }
        
        .info-list {
            list-style: none;
        }
        
        .info-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--primary-color);
            min-width: 130px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-label i {
            font-size: 0.9em;
            color: var(--secondary-color);
        }
        
        .info-value {
            flex: 1;
            padding: 4px 10px;
            background-color: rgba(0, 119, 194, 0.05);
            border-radius: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-active {
            background-color: rgba(76, 175, 80, 0.15);
            color: var(--success-color);
        }
        
        .status-inactive {
            background-color: rgba(244, 67, 54, 0.15);
            color: var(--danger-color);
        }
        
        .contact-info {
            margin-top: 30px;
            padding: 15px;
            background-color: rgba(0, 119, 194, 0.05);
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
        }
        
        .contact-info-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .contact-info-message {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">GestUsers</div>
        <div class="admin-info">
            <div class="admin-avatar">
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
            <div class="admin-details">
                <div class="admin-name"><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario'); ?></div>
                <div class="admin-role"><?php echo htmlspecialchars($_SESSION['usuario_rol'] ?? 'Usuario'); ?></div>
            </div>
        </div>
        <ul class="menu">
            <li class="menu-item" onclick="location.href='index.php?controller=usuario&action=dashboard'">
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
            <li class="menu-item active" onclick="location.href='index.php?controller=usuario&action=perfil'">
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
            <h1 class="page-title">Mi Perfil</h1>
            <div class="user-badge">
                <i class="fas fa-user"></i>
                <?php echo htmlspecialchars($iniciales); ?>
            </div>
        </div>

        <div class="profile-section">
            <!-- Información Personal -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-title">
                        <i class="fas fa-id-card"></i>
                        Información Personal
                    </div>
                    <div class="profile-subtitle">Datos de identificación y contacto</div>
                    <div class="profile-icon"><i class="fas fa-user-circle"></i></div>
                </div>
                <div class="profile-content">
                    <ul class="info-list">
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-id-badge"></i> Cédula
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['cedula']); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user"></i> Nombres
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['nombres']); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user"></i> Apellidos
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['apellidos']); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt"></i> Nacimiento
                            </div>
                            <div class="info-value"><?php echo date('d/m/Y', strtotime($usuario['fecha_nacimiento'])); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-venus-mars"></i> Género
                            </div>
                            <div class="info-value"><?php echo ucfirst(htmlspecialchars($usuario['genero'])); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i> Correo
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['correo']); ?></div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Información de Cuenta -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-title">
                        <i class="fas fa-briefcase"></i>
                        Información de Cuenta
                    </div>
                    <div class="profile-subtitle">Datos de ubicación y organización</div>
                    <div class="profile-icon"><i class="fas fa-building"></i></div>
                </div>
                <div class="profile-content">
                    <ul class="info-list">
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-map-marker-alt"></i> Ciudad
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['ciudad']); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-globe"></i> País
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['pais']); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-building"></i> Organización
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['organizacion']); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user-tag"></i> Rol
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($_SESSION['usuario_rol'] ?? 'Usuario'); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-toggle-on"></i> Estado
                            </div>
                            <div class="info-value">
                                <?php if ($usuario['estado'] == 'activo'): ?>
                                    <span class="status-badge status-active">Activo</span>
                                <?php else: ?>
                                    <span class="status-badge status-inactive">Inactivo</span>
                                <?php endif; ?>
                            </div>
                        </li>
                        <li class="info-item">
                            <div class="info-label">
                                <i class="fas fa-clock"></i> Registro
                            </div>
                            <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($usuario['created_at'])); ?></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="contact-info">
            <div class="contact-info-title">
                <i class="fas fa-info-circle"></i>
                Información importante
            </div>
            <div class="contact-info-message">
                Para modificar la información de tu perfil o cambiar tu contraseña, por favor contacta al administrador del sistema.
                Esta información es gestionada por el superadministrador para mantener la seguridad e integridad de los datos.
            </div>
        </div>
    </div>
</body>
</html>