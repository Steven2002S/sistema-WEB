<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas del Sistema - Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            --purple-color: #9c27b0;
            --pink-color: #e91e63;
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
            z-index: 10;
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
            padding: 30px;
            background-color: var(--background-color);
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background-color: var(--card-color);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .page-title {
            font-size: 28px;
            color: var(--text-color);
            font-weight: 600;
        }
        
        .dashboard-date {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .user-badge {
            background-color: var(--accent-color);
            color: var(--text-color);
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .user-badge i {
            font-size: 14px;
        }
        
        /* Stats Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: flex-start;
            overflow: hidden;
            position: relative;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-right: 20px;
            position: relative;
            z-index: 2;
        }
        
        .stat-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: inherit;
            border-radius: inherit;
            opacity: 0.2;
            transform: scale(2.5);
            z-index: -1;
        }
        
        .stat-details {
            flex-grow: 1;
            z-index: 2;
        }
        
        .stat-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-color);
        }
        
        .stat-description {
            font-size: 13px;
            color: #888;
        }
        
        /* Chart Sections */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 1200px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .chart-card {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .chart-title i {
            color: var(--primary-color);
            font-size: 20px;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        /* Activity Cards */
        .activity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 900px) {
            .activity-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .activity-card {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .activity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .activity-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .activity-title i {
            color: var(--primary-color);
            font-size: 20px;
        }
        
        .activity-list {
            list-style: none;
            max-height: 400px;
            overflow-y: auto;
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
            width: 40px;
            height: 40px;
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
            font-weight: 600;
        }
        
        .activity-time {
            font-size: 12px;
            color: #888;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .activity-time i {
            font-size: 10px;
        }
        
        /* Role Distribution List */
        .role-list {
            list-style: none;
            max-height: 300px;
            overflow-y: auto;
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
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background-color: rgba(0, 119, 194, 0.1);
            color: var(--primary-color);
            margin-right: 10px;
        }
        
        .role-badge i {
            margin-right: 5px;
            font-size: 10px;
        }
        
        .role-count {
            background-color: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        /* Progress Bar */
        .progress-container {
            margin-top: 8px;
            width: 100%;
            background-color: var(--background-color);
            border-radius: 10px;
            height: 8px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .progress-bar::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, 
                rgba(255,255,255,0.1) 25%, 
                rgba(255,255,255,0.15) 50%, 
                rgba(255,255,255,0.1) 75%);
            width: 200%;
            animation: shine 2s infinite linear;
        }
        
        @keyframes shine {
            from { transform: translateX(-100%); }
            to { transform: translateX(100%); }
        }
        
        /* Color variations */
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
        
        .bg-purple {
            background-color: var(--purple-color);
        }
        
        .bg-pink {
            background-color: var(--pink-color);
        }
        
        .color-primary {
            color: var(--primary-color);
        }
        
        .color-success {
            color: var(--success-color);
        }
        
        .color-warning {
            color: var(--warning-color);
        }
        
        .color-accent {
            color: var(--accent-color);
        }
        
        .color-danger {
            color: var(--danger-color);
        }
        
        .color-purple {
            color: var(--purple-color);
        }
        
        .color-pink {
            color: var(--pink-color);
        }
        
        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #888;
        }
        
        .empty-state i {
            font-size: 50px;
            margin-bottom: 15px;
            opacity: 0.3;
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
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=listarCursos'">
                <i class="fas fa-book"></i>
                <span>Gestión de Cursos</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=gestionarRoles'">
                <i class="fas fa-user-tag"></i>
                <span>Roles</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=finanzas&action=informeFacturacion'">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Facturación</span>
            </li>
            <li class="menu-item active" onclick="location.href='index.php?controller=superadmin&action=estadisticas'">
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
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div>
                <h1 class="page-title">Estadísticas del Sistema</h1>
                <div class="dashboard-date">
                <?php
                  // Configuración para mostrar la fecha en español
                  setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
                 // Array de nombres de días en español
                  $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
                 // Array de nombres de meses en español
                  $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 
                  'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

                // Obtener día de la semana, día del mes y mes
                $dia_semana = $dias[date('w')];
                $dia = date('j');
                $mes = $meses[date('n')-1];
                $anio = date('Y');

                // Formatear la fecha en español
                echo "$dia_semana, $dia de $mes $anio";
                ?>
                </div>            
            </div>
            <div class="user-badge">
                <i class="fas fa-crown"></i>
                <span>SuperAdmin</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: var(--primary-color); color: white;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-title">Total Usuarios</div>
                    <div class="stat-value"><?php echo $estadisticas['total_usuarios']; ?></div>
                    <div class="stat-description">Usuarios registrados en el sistema</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background-color: var(--success-color); color: white;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-title">Usuarios Activos</div>
                    <div class="stat-value"><?php echo $estadisticas['usuarios_activos']; ?></div>
                    <div class="stat-description">Usuarios con estado activo</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background-color: var(--purple-color); color: white;">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-title">Total Cursos</div>
                    <div class="stat-value"><?php echo $estadisticas['total_cursos'] ?? 0; ?></div>
                    <div class="stat-description">Cursos creados en el sistema</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background-color: var(--pink-color); color: white;">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-details">
                    <div class="stat-title">Cursos Activos</div>
                    <div class="stat-value"><?php echo $estadisticas['cursos_activos'] ?? 0; ?></div>
                    <div class="stat-description">Cursos con estado activo</div>
                </div>
            </div>
        </div>
        
        <!-- Charts Grid -->
        <div class="charts-grid">
            <!-- Users Distribution Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">
                        <i class="fas fa-chart-pie"></i>
                        <span>Distribución de Usuarios</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="userDistributionChart"></canvas>
                </div>
            </div>
            
            <!-- Courses vs Users Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">
                        <i class="fas fa-chart-bar"></i>
                        <span>Usuarios vs Cursos</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="usersVsCoursesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Role Distribution Card -->
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <i class="fas fa-user-tag"></i>
                    <span>Distribución de Usuarios por Rol</span>
                </div>
            </div>
            
            <div class="role-list">
                <?php 
                $colors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-accent', 'bg-danger', 'bg-purple', 'bg-pink'];
                $colorIndex = 0;
                $total_usuarios = $estadisticas['total_usuarios'];
                
                if (!empty($estadisticas['usuarios_por_rol']) && $total_usuarios > 0): 
                    foreach ($estadisticas['usuarios_por_rol'] as $rol => $cantidad):
                        $porcentaje = round(($cantidad / $total_usuarios) * 100);
                        $colorClass = $colors[$colorIndex % count($colors)];
                        $colorIndex++;
                ?>
                <div class="role-item">
                    <div class="role-name">
                        <span class="role-badge">
                            <i class="fas fa-circle"></i>
                            <?php echo htmlspecialchars($rol); ?>
                        </span>
                    </div>
                    <div class="role-count"><?php echo $cantidad; ?> (<?php echo $porcentaje; ?>%)</div>
                </div>
                <div class="progress-container">
                    <div class="progress-bar <?php echo $colorClass; ?>" style="width: <?php echo $porcentaje; ?>%"></div>
                </div>
                <?php 
                    endforeach;
                else: 
                ?>
                <div class="empty-state">
                    <i class="fas fa-chart-pie"></i>
                    <p>No hay datos de roles disponibles.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Activity Grid -->
        <div class="activity-grid">
            <!-- Recent Courses Activity -->
            <div class="activity-card">
                <div class="activity-header">
                    <div class="activity-title">
                        <i class="fas fa-book"></i>
                        <span>Cursos Recientes</span>
                    </div>
                </div>
                
                <?php if(!empty($cursos_recientes)): ?>
                <ul class="activity-list">
                    <?php foreach($cursos_recientes as $curso): ?>
                    <li class="activity-item">
                        <div class="activity-icon" style="background-color: rgba(156, 39, 176, 0.1); color: var(--purple-color);">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="activity-info">
                            <div class="activity-text">
                                <strong><?php echo htmlspecialchars($curso['nombre']); ?></strong> fue creado.
                            </div>
                            <div class="activity-time">
                                <i class="fas fa-clock"></i>
                                <?php echo date('d/m/Y H:i', strtotime($curso['created_at'])); ?>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-book"></i>
                    <p>No hay cursos recientes para mostrar.</p>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Recent Users Activity -->
            <div class="activity-card">
                <div class="activity-header">
                    <div class="activity-title">
                        <i class="fas fa-user-plus"></i>
                        <span>Usuarios Recientes</span>
                    </div>
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
                                <strong><?php echo htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']); ?></strong> fue registrado.
                            </div>
                            <div class="activity-time">
                                <i class="fas fa-clock"></i>
                                <?php echo date('d/m/Y H:i', strtotime($usuario['created_at'])); ?>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>No hay usuarios recientes para mostrar.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Preparar datos para los gráficos
        document.addEventListener('DOMContentLoaded', function() {
            // Datos para el gráfico de distribución de usuarios
            const userDistributionCtx = document.getElementById('userDistributionChart').getContext('2d');
            
            // Datos para el gráfico de pie
            const roleLabels = [];
            const roleCounts = [];
            const backgroundColors = [
                '#0077c2', // primary
                '#4caf50', // success
                '#ffd600', // accent
                '#ff9800', // warning
                '#f44336', // danger
                '#9c27b0', // purple
                '#e91e63'  // pink
            ];
            
            <?php if (!empty($estadisticas['usuarios_por_rol'])): ?>
                <?php foreach ($estadisticas['usuarios_por_rol'] as $rol => $cantidad): ?>
                    roleLabels.push('<?php echo $rol; ?>');
                    roleCounts.push(<?php echo $cantidad; ?>);
                <?php endforeach; ?>
            <?php endif; ?>
            
            // Crear gráfico de distribución de usuarios
            new Chart(userDistributionCtx, {
                type: 'pie',
                data: {
                    labels: roleLabels,
                    datasets: [{
                        data: roleCounts,
                        backgroundColor: backgroundColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    family: "'Segoe UI', sans-serif",
                                    size: 12
                                },
                                padding: 20
                            }
                        },
                        tooltip: {
                            bodyFont: {
                                family: "'Segoe UI', sans-serif"
                            },
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} usuarios (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            
            // Datos para el gráfico de barras de usuarios vs cursos
            const usersVsCoursesCtx = document.getElementById('usersVsCoursesChart').getContext('2d');
            
            // Datos para el gráfico de barras
            const barLabels = ['Total', 'Activos', 'Recientes'];
            const userCounts = [
                <?php echo $estadisticas['total_usuarios']; ?>,
                <?php echo $estadisticas['usuarios_activos']; ?>,
                <?php echo $estadisticas['usuarios_recientes']; ?>
            ];
            
            const courseCounts = [
                <?php echo $estadisticas['total_cursos'] ?? 0; ?>,
                <?php echo $estadisticas['cursos_activos'] ?? 0; ?>,
                <?php echo $estadisticas['cursos_recientes'] ?? 0; ?>
            ];
            
// Crear gráfico de barras para usuarios vs cursos
new Chart(usersVsCoursesCtx, {
                type: 'bar',
                data: {
                    labels: barLabels,
                    datasets: [
                        {
                            label: 'Usuarios',
                            data: userCounts,
                            backgroundColor: '#0077c2',
                            borderWidth: 0,
                            borderRadius: 4
                        },
                        {
                            label: 'Cursos',
                            data: courseCounts,
                            backgroundColor: '#9c27b0',
                            borderWidth: 0,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    family: "'Segoe UI', sans-serif",
                                    size: 12
                                },
                                padding: 20
                            }
                        },
                        tooltip: {
                            bodyFont: {
                                family: "'Segoe UI', sans-serif"
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>