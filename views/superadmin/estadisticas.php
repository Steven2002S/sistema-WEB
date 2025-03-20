<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas del Sistema - Administrador</title>
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
        
        .admin-info {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
        }
        
        .admin-details {
            flex-grow: 1;
        }
        
        .admin-role {
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
        
        /* Stats Grid */
        .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Cambiamos a 4 columnas fijas */
    gap: 20px;
    margin-bottom: 30px;
    max-width: 1200px; /* Limitar el ancho máximo */
    margin-left: auto;
    margin-right: auto; /* Centrar horizontalmente */
}
        
    
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr); /* En pantallas medianas, 2 columnas */
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr; /* En móviles, 1 columna */
    }
}

.stat-card {
    background-color: var(--card-color);
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center; /* Centrar contenido horizontalmente */
    text-align: center; /* Texto centrado */
    transition: transform 0.3s, box-shadow 0.3s;
}
        
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.stat-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    justify-content: center; /* Centrar horizontalmente */
}

.stat-icon {
    width: 50px; /* Hacemos más grande el icono */
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 24px; /* Icono más grande */
}

.stat-value {
    font-size: 40px; /* Número más grande */
    font-weight: bold;
    margin: 10px 0;
    color: var(--primary-color); /* Color destacado */
}

.stat-description {
    font-size: 14px;
    color: #666;
    margin-top: auto;
}
        
        .icon-users {
            background-color: rgba(0, 119, 194, 0.1);
            color: var(--primary-color);
        }
        
        .icon-active {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }
        
        .icon-roles {
            background-color: rgba(255, 214, 0, 0.1);
            color: var(--accent-color);
        }
        
        .icon-recent {
            background-color: rgba(255, 152, 0, 0.1);
            color: var(--warning-color);
        }
        
        .stat-title {
            font-size: 16px;
            font-weight: bold;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .stat-description {
            font-size: 14px;
            color: #666;
            margin-top: auto;
        }
        
        /* Chart Sections */
        .chart-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .chart-title {
            font-size: 18px;
            font-weight: bold;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        /* Activity Section */
        .activity-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .activity-title {
            font-size: 18px;
            font-weight: bold;
        }
        
        .activity-list {
            list-style: none;
        }
        
        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
        }
        
        .activity-info {
            flex-grow: 1;
        }
        
        .activity-text {
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .activity-text strong {
            font-weight: bold;
        }
        
        .activity-time {
            font-size: 12px;
            color: #666;
        }
        
        /* Role Distribution */
        .role-list {
            list-style: none;
        }
        
        .role-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }
        
        .role-item:last-child {
            border-bottom: none;
        }
        
        .role-name {
            flex-grow: 1;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .role-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            background-color: rgba(0, 119, 194, 0.1);
            color: var(--primary-color);
            margin-right: 10px;
        }
        
        .role-count {
            background-color: var(--primary-color);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Progress Bar */
        .progress-container {
            margin-top: 5px;
            width: 100%;
            background-color: var(--background-color);
            border-radius: 4px;
            height: 8px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            border-radius: 4px;
        }
        
        /* Color variations for progress bars */
        .bg-primary {
            background-color: var(--primary-color);
        }
        
        .bg-success {
            background-color: var(--success-color);
        }
        
        .bg-warning {
            background-color: var(--warning-color);
        }
        
        .bg-accent {
            background-color: var(--accent-color);
        }
        
        .bg-danger {
            background-color: var(--danger-color);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">GestUsers</div>
        <div class="admin-info">
            <div class="admin-avatar">SA</div>
            <div class="admin-details">
                <div class="admin-name">SuperAdmin</div>
                <div class="admin-role">Administrador</div>
            </div>
        </div>
        <ul class="menu">
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=dashboard'">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=listarUsuarios'">
                <i class="fas fa-users"></i>
                <span>Gestión de Usuarios</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=gestionarRoles'">
                <i class="fas fa-user-tag"></i>
                <span>Roles</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=perfil'">
                <i class="fas fa-cog"></i>
                <span>Configuraciones</span>
            </li>
            <li class="menu-item active">
                <i class="fas fa-chart-bar"></i>
                <span>Estadísticas</span>
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
            <h1 class="page-title">Estadísticas del Sistema</h1>
            <div class="user-badge">SA</div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon icon-users">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-title">Total Usuarios</div>
                </div>
                <div class="stat-value"><?php echo $estadisticas['total_usuarios']; ?></div>
                <div class="stat-description">Usuarios registrados en el sistema</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon icon-active">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-title">Usuarios Activos</div>
                </div>
                <div class="stat-value"><?php echo $estadisticas['usuarios_activos']; ?></div>
                <div class="stat-description">Usuarios con estado activo</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon icon-roles">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <div class="stat-title">Total Roles</div>
                </div>
                <div class="stat-value"><?php echo count($roles); ?></div>
                <div class="stat-description">Roles definidos en el sistema</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon icon-recent">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-title">Usuarios Recientes</div>
                </div>
                <div class="stat-value"><?php echo $estadisticas['usuarios_recientes']; ?></div>
                <div class="stat-description">Usuarios registrados en el último mes</div>
            </div>
        </div>
        
        <!-- Role Distribution Section -->
        <div class="chart-section">
            <div class="chart-header">
                <h2 class="chart-title">Distribución de Usuarios por Rol</h2>
            </div>
            
            <div class="role-list">
                <?php 
                $colors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-accent', 'bg-danger'];
                $colorIndex = 0;
                $total_usuarios = $estadisticas['total_usuarios'];
                
                if (!empty($estadisticas['usuarios_por_rol'])) {
                    foreach ($estadisticas['usuarios_por_rol'] as $rol => $cantidad) {
                        $porcentaje = $total_usuarios > 0 ? round(($cantidad / $total_usuarios) * 100) : 0;
                        $colorClass = $colors[$colorIndex % count($colors)];
                        $colorIndex++;
                ?>
                <div class="role-item">
                    <div class="role-name">
                        <span class="role-badge"><?php echo htmlspecialchars($rol); ?></span>
                    </div>
                    <div class="role-count"><?php echo $cantidad; ?> usuarios</div>
                </div>
                <div class="progress-container">
                    <div class="progress-bar <?php echo $colorClass; ?>" style="width: <?php echo $porcentaje; ?>%"></div>
                </div>
                <?php 
                    }
                } else {
                    echo '<p>No hay datos de roles disponibles.</p>';
                }
                ?>
            </div>
        </div>
        
        <!-- Recent Activity Section -->
        <div class="activity-section">
            <div class="activity-header">
                <h2 class="activity-title">Actividad Reciente</h2>
            </div>
            
            <?php if(!empty($usuarios_recientes)): ?>
            <ul class="activity-list">
                <?php foreach($usuarios_recientes as $usuario): ?>
                <li class="activity-item">
                    <div class="activity-icon" style="background-color: rgba(0, 119, 194, 0.1); color: var(--primary-color);">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-info">
                        <div class="activity-text">
                            <strong><?php echo htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']); ?></strong> fue registrado en el sistema.
                        </div>
                        <div class="activity-time">
                            <?php echo date('d/m/Y H:i', strtotime($usuario['created_at'])); ?>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p>No hay actividad reciente para mostrar.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>