<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Administrador</title>
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
        
        /* Sidebar estilos (mismo que en dashboard.php) */
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
        
        /* Form Section */
        .form-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            font-size: 16px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(0, 119, 194, 0.2);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-secondary {
            background-color: var(--background-color);
            color: var(--text-color);
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(244, 67, 54, 0.3);
        }
        
        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(76, 175, 80, 0.3);
        }

        /* Nuevos estilos para la selección de días de la semana */
        .days-selection {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }
        
        .day-checkbox {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        
        .day-label {
            display: inline-block;
            background-color: var(--background-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            min-width: 90px;
        }
        
        .day-checkbox:checked + .day-label {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .day-checkbox:focus + .day-label {
            box-shadow: 0 0 0 2px rgba(0, 119, 194, 0.2);
        }
        
        .day-wrapper {
            position: relative;
        }
        
        .day-label:hover {
            background-color: rgba(0, 119, 194, 0.1);
        }
        
        .schedule-header {
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 16px;
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }
        
        .schedule-header i {
            margin-right: 8px;
        }
        
        .schedule-section {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #e5e5e5;
        }
        
        .schedule-fields {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .schedule-fields {
                grid-template-columns: 1fr;
            }
            
            .days-selection {
                justify-content: center;
            }
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
            <li class="menu-item active" onclick="location.href='index.php?controller=superadmin&action=listarCursos'">
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
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=estadisticas'">
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
            <h1 class="page-title">Crear Nuevo Curso</h1>
            <div class="user-badge">SA</div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <?php if (!empty($mensaje)): ?>
                <div class="alert <?php echo $error ? 'alert-danger' : 'alert-success'; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?controller=superadmin&action=crearCurso">
                <div class="form-group">
                    <label for="nombre">Nombre del Curso *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                </div>
                
                <!-- Sección de Horario con mejor diseño -->
                <div class="schedule-section">
                    <div class="schedule-header">
                        <i class="fas fa-calendar-alt"></i> Programación del Curso
                    </div>
                    
                    <div class="schedule-fields">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        </div>

                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Finalización</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                        </div>

                        <div class="form-group">
                            <label for="hora_inicio">Hora de Inicio</label>
                            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
                        </div>

                        <div class="form-group">
                            <label for="hora_fin">Hora de Finalización</label>
                            <input type="time" class="form-control" id="hora_fin" name="hora_fin">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Días de la Semana</label>
                        <div class="days-selection">
                            <div class="day-wrapper">
                                <input type="checkbox" id="lunes" class="day-checkbox" name="dias_semana[]" value="lunes">
                                <label for="lunes" class="day-label">Lunes</label>
                            </div>
                            <div class="day-wrapper">
                                <input type="checkbox" id="martes" class="day-checkbox" name="dias_semana[]" value="martes">
                                <label for="martes" class="day-label">Martes</label>
                            </div>
                            <div class="day-wrapper">
                                <input type="checkbox" id="miercoles" class="day-checkbox" name="dias_semana[]" value="miercoles">
                                <label for="miercoles" class="day-label">Miércoles</label>
                            </div>
                            <div class="day-wrapper">
                                <input type="checkbox" id="jueves" class="day-checkbox" name="dias_semana[]" value="jueves">
                                <label for="jueves" class="day-label">Jueves</label>
                            </div>
                            <div class="day-wrapper">
                                <input type="checkbox" id="viernes" class="day-checkbox" name="dias_semana[]" value="viernes">
                                <label for="viernes" class="day-label">Viernes</label>
                            </div>
                            <div class="day-wrapper">
                                <input type="checkbox" id="sabado" class="day-checkbox" name="dias_semana[]" value="sabado">
                                <label for="sabado" class="day-label">Sábado</label>
                            </div>
                            <div class="day-wrapper">
                                <input type="checkbox" id="domingo" class="day-checkbox" name="dias_semana[]" value="domingo">
                                <label for="domingo" class="day-label">Domingo</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-buttons">
                    <button type="button" class="btn btn-secondary" onclick="location.href='index.php?controller=superadmin&action=listarCursos'">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Curso</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>