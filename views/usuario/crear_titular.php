<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Titular - Usuario</title>
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
        
        /* Form Section */
        .form-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .form-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 25px;
            color: var(--text-color);
            display: flex;
            align-items: center;
        }
        
        .form-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-required {
            color: var(--danger-color);
            margin-left: 4px;
        }
        
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        .form-input.error,
        .form-select.error,
        .form-textarea.error {
            border-color: var(--danger-color);
        }
        
        .form-help {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }
        
        .form-error {
            font-size: 13px;
            color: var(--danger-color);
            margin-top: 5px;
            display: none;
        }
        
        .form-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn i {
            margin-right: 8px;
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
        
        .btn-add {
            background-color: var(--success-color);
            color: white;
        }
        
        .btn-add:hover {
            background-color: #3d9140;
        }
        
        .estudiante-container {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #f9f9f9;
        }
        
        .estudiante-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .estudiante-title {
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .estudiante-title i {
            margin-right: 8px;
            color: var(--primary-color);
        }
        
        .btn-remove {
            padding: 6px 12px;
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
        }
        
        .btn-remove:hover {
            background-color: rgba(244, 67, 54, 0.2);
        }
        
        /* Alert messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }
        
        .alert-error {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
            border: 1px solid var(--danger-color);
        }
        
        .alert i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .separator {
            border-top: 1px solid var(--border-color);
            margin: 30px 0;
        }

        /* Nuevos estilos para selector de cursos */
        .curso-selector {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 5px;
        }

        .curso-search {
            padding: 10px;
            background-color: #f5f5f5;
            border-bottom: 1px solid var(--border-color);
        }

        .curso-cards {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
        }

        .curso-card {
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .curso-card:hover {
            background-color: rgba(0, 119, 194, 0.05);
            border-color: var(--primary-color);
        }

        .curso-card.selected {
            background-color: rgba(0, 119, 194, 0.1);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(0, 119, 194, 0.2);
        }

        .curso-name {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--primary-color);
        }

        .curso-dates, .curso-time {
            font-size: 13px;
            margin-bottom: 5px;
            color: #666;
        }

        .curso-days {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-top: 8px;
        }

        .day-badge {
            font-size: 11px;
            padding: 2px 6px;
            background-color: rgba(0, 119, 194, 0.1);
            color: var(--primary-color);
            border-radius: 4px;
        }

        /* Estilos para radio buttons de discapacidad */
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 5px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .radio-label input {
            margin-right: 5px;
        }

        /* Estilos para información de curso en select */
        .form-select option {
            padding: 8px;
            font-size: 14px;
        }

        /* Estilos para los campos adicionales */
        .fecha-nacimiento-field {
            display: flex;
            align-items: center;
        }

        .fecha-nacimiento-field i {
            color: var(--primary-color);
            margin-right: 8px;
        }

        .discapacidad-section {
            background-color: rgba(249, 249, 249, 0.7);
            border-radius: 6px;
            padding: 15px;
            margin-top: 5px;
            border: 1px solid #e0e0e0;
        }

        .discapacidad-header {
            font-weight: 600;
            color: #555;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .discapacidad-header i {
            margin-right: 8px;
            color: var(--primary-color);
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
            <li class="menu-item active" onclick="location.href='index.php?controller=usuario&action=listarTitulares'">
                <i class="fas fa-user-tie"></i>
                <span>Titulares</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=usuario&action=listarEstudiantes'">
                <i class="fas fa-user-graduate"></i>
                <span>Estudiantes</span>
            </li>
            <li class="menu-item " onclick="location.href='index.php?controller=finanzas&action=dashboard'">
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
            <h1 class="page-title">Crear Nuevo Titular</h1>
            <div class="user-badge">
                <?php echo htmlspecialchars($iniciales); ?>
            </div>
        </div>

        <?php if (isset($mensaje) && !empty($mensaje)): ?>
        <div class="alert <?php echo $error ? 'alert-error' : 'alert-success'; ?>">
            <i class="fas <?php echo $error ? 'fa-exclamation-circle' : 'fa-check-circle'; ?>"></i>
            <span><?php echo htmlspecialchars($mensaje); ?></span>
        </div>
        <?php endif; ?>

        <!-- Form Section -->
        <form id="createTitularForm" action="index.php?controller=usuario&action=crearTitular" method="POST">
            <!-- Información del Titular -->
            <div class="form-section">
                <h2 class="form-title"><i class="fas fa-user-tie"></i> Información del Titular</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="cedula">Cédula<span class="form-required">*</span></label>
                        <input type="text" id="cedula" name="cedula" class="form-input" required>
                        <div class="form-error" id="cedula-error">Por favor, ingrese un número de cédula válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="nombres">Nombres<span class="form-required">*</span></label>
                        <input type="text" id="nombres" name="nombres" class="form-input" required>
                        <div class="form-error" id="nombres-error">Por favor, ingrese los nombres.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="apellidos">Apellidos<span class="form-required">*</span></label>
                        <input type="text" id="apellidos" name="apellidos" class="form-input" required>
                        <div class="form-error" id="apellidos-error">Por favor, ingrese los apellidos.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="direccion">Dirección<span class="form-required">*</span></label>
                        <textarea id="direccion" name="direccion" class="form-textarea" required></textarea>
                        <div class="form-error" id="direccion-error">Por favor, ingrese la dirección.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-input">
                        <div class="form-error" id="email-error">Por favor, ingrese un correo válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="empresa">Empresa/Organización</label>
                        <input type="text" id="empresa" name="empresa" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="celular">Celular</label>
                        <input type="text" id="celular" name="celular" class="form-input">
                        <div class="form-error" id="celular-error">Por favor, ingrese un número de celular válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="telefono_casa">Teléfono Casa</label>
                        <input type="text" id="telefono_casa" name="telefono_casa" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="cargo">Cargo</label>
                        <input type="text" id="cargo" name="cargo" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="telefono_trabajo">Teléfono Trabajo</label>
                        <input type="text" id="telefono_trabajo" name="telefono_trabajo" class="form-input">
                    </div>
                </div>
            </div>
            
            <!-- Información de Estudiantes -->
            <div class="form-section">
                <h2 class="form-title"><i class="fas fa-user-graduate"></i> Información de Estudiantes</h2>
                
                <div id="estudiantes-container">
                    <!-- Primer estudiante (siempre visible) -->
                    <div class="estudiante-container" id="estudiante-0">
                        <div class="estudiante-header">
                            <h3 class="estudiante-title"><i class="fas fa-user-graduate"></i> Estudiante 1</h3>
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="estudiante_cedula_0">Cédula<span class="form-required">*</span></label>
                                <input type="text" id="estudiante_cedula_0" name="estudiante_cedula[]" class="form-input" required>
                                <div class="form-error" id="estudiante_cedula_0-error">Por favor, ingrese un número de cédula válido.</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="estudiante_nombres_0">Nombres<span class="form-required">*</span></label>
                                <input type="text" id="estudiante_nombres_0" name="estudiante_nombres[]" class="form-input" required>
                                <div class="form-error" id="estudiante_nombres_0-error">Por favor, ingrese los nombres.</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="estudiante_apellidos_0">Apellidos<span class="form-required">*</span></label>
                                <input type="text" id="estudiante_apellidos_0" name="estudiante_apellidos[]" class="form-input" required>
                                <div class="form-error" id="estudiante_apellidos_0-error">Por favor, ingrese los apellidos.</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="estudiante_edad_0">Edad<span class="form-required">*</span></label>
                                <input type="number" id="estudiante_edad_0" name="estudiante_edad[]" class="form-input" min="1" max="100" required>
                                <div class="form-error" id="estudiante_edad_0-error">Por favor, ingrese una edad válida.</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="estudiante_fecha_nacimiento_0">Fecha de Nacimiento</label>
                                <div class="fecha-nacimiento-field">
                                    <i class="fas fa-calendar-alt"></i>
                                    <input type="date" id="estudiante_fecha_nacimiento_0" name="estudiante_fecha_nacimiento[]" class="form-input">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="estudiante_curso_id_0">Curso<span class="form-required">*</span></label>
                                <select id="estudiante_curso_id_0" name="estudiante_curso_id[]" class="form-select" required>
                                    <option value="">Seleccione un curso...</option>
                                    <?php foreach ($cursos as $curso): ?>
                                        <?php if ($curso['estado'] === 'activo'): 
                                            // Preparar información del horario
                                            $infoHorario = "";
                                            if (!empty($curso['fecha_inicio']) && !empty($curso['fecha_fin'])) {
                                                $infoHorario .= " | " . date('d/m/Y', strtotime($curso['fecha_inicio'])) . " al " . date('d/m/Y', strtotime($curso['fecha_fin']));
                                            }
                                            if (!empty($curso['hora_inicio']) && !empty($curso['hora_fin'])) {
                                                $infoHorario .= " | " . date('H:i', strtotime($curso['hora_inicio'])) . " a " . date('H:i', strtotime($curso['hora_fin']));
                                            }
                                            
                                            // Preparar información de días
                                            $diasSemana = "";
                                            if (!empty($curso['dias_semana'])) {
                                                $diasArray = json_decode($curso['dias_semana'], true);
                                                if (is_array($diasArray) && !empty($diasArray)) {
                                                    $diasCortos = array_map(function($dia) {
                                                        return ucfirst(substr($dia, 0, 3));
                                                    }, $diasArray);
                                                    $diasSemana = " | " . implode(", ", $diasCortos);
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $curso['id']; ?>">
                                            <?php echo htmlspecialchars($curso['nombre']) . $infoHorario . $diasSemana; ?>
                                        </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-error" id="estudiante_curso_id_0-error">Por favor, seleccione un curso.</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="estudiante_talla_0">Talla</label>
                                <input type="text" id="estudiante_talla_0" name="estudiante_talla[]" class="form-input">
                            </div>

                            <div class="form-group">
                                <label class="form-label">¿Tiene discapacidad?</label>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="estudiante_tiene_discapacidad[0]" value="no" checked onchange="toggleDiscapacidad(0, 'no')"> No
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="estudiante_tiene_discapacidad[0]" value="si" onchange="toggleDiscapacidad(0, 'si')"> Sí
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group" id="discapacidad_container_0" style="display: none;">
                                <div class="discapacidad-section">
                                    <div class="discapacidad-header">
                                        <i class="fas fa-info-circle"></i>
                                        Observaciones sobre discapacidad
                                    </div>
                                    <textarea id="estudiante_observaciones_discapacidad_0" name="estudiante_observaciones_discapacidad[]" class="form-textarea" placeholder="Describa el tipo de discapacidad y cualquier información relevante..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button type="button" id="btnAddEstudiante" class="btn btn-add">
                        <i class="fas fa-plus"></i> Agregar Otro Estudiante
                    </button>
                </div>
            </div>
            
            <!-- Información de Referencia Personal -->
            <div class="form-section">
                <h2 class="form-title"><i class="fas fa-address-book"></i> Referencia Personal</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="referencia_nombres">Nombres<span class="form-required">*</span></label>
                        <input type="text" id="referencia_nombres" name="referencia_nombres" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="referencia_apellidos">Apellidos</label>
                        <input type="text" id="referencia_apellidos" name="referencia_apellidos" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="referencia_direccion">Dirección</label>
                        <textarea id="referencia_direccion" name="referencia_direccion" class="form-textarea" require></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="referencia_email">Correo Electrónico</label>
                        <input type="email" id="referencia_email" name="referencia_email" class="form-input">
                        <div class="form-error" id="referencia_email-error">Por favor, ingrese un correo válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="referencia_celular">Celular</label>
                        <input type="text" id="referencia_celular" name="referencia_celular" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="referencia_telefono_casa">Teléfono Casa</label>
                        <input type="text" id="referencia_telefono_casa" name="referencia_telefono_casa" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="referencia_empresa">Empresa</label>
                        <input type="text" id="referencia_empresa" name="referencia_empresa" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="referencia_cargo">Cargo</label>
                        <input type="text" id="referencia_cargo" name="referencia_cargo" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="referencia_telefono_trabajo">Teléfono Trabajo</label>
                        <input type="text" id="referencia_telefono_trabajo" name="referencia_telefono_trabajo" class="form-input">
                    </div>
                </div>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="index.php?controller=usuario&action=listarTitulares" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        // Contador para estudiantes adicionales
        let estudianteCount = 1;
        
        // Función para agregar otro estudiante
        document.getElementById('btnAddEstudiante').addEventListener('click', function() {
            if (estudianteCount < 10) { // Permitir hasta 10 estudiantes
                const container = document.getElementById('estudiantes-container');
                const newEstudiante = document.createElement('div');
                newEstudiante.className = 'estudiante-container';
                newEstudiante.id = `estudiante-${estudianteCount}`;
                
                newEstudiante.innerHTML = `
                    <div class="estudiante-header">
                        <h3 class="estudiante-title"><i class="fas fa-user-graduate"></i> Estudiante ${estudianteCount + 1}</h3>
                        <button type="button" class="btn-remove" onclick="removeEstudiante(${estudianteCount})">
                            <i class="fas fa-times"></i> Eliminar
                        </button>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="estudiante_cedula_${estudianteCount}">Cédula</label>
                            <input type="text" id="estudiante_cedula_${estudianteCount}" name="estudiante_cedula[]" class="form-input">
                            <div class="form-error" id="estudiante_cedula_${estudianteCount}-error">Por favor, ingrese un número de cédula válido.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_nombres_${estudianteCount}">Nombres<span class="form-required">*</span></label>
                            <input type="text" id="estudiante_nombres_${estudianteCount}" name="estudiante_nombres[]" class="form-input" required>
                            <div class="form-error" id="estudiante_nombres_${estudianteCount}-error">Por favor, ingrese los nombres.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_apellidos_${estudianteCount}">Apellidos<span class="form-required">*</span></label>
                            <input type="text" id="estudiante_apellidos_${estudianteCount}" name="estudiante_apellidos[]" class="form-input" required>
                            <div class="form-error" id="estudiante_apellidos_${estudianteCount}-error">Por favor, ingrese los apellidos.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_edad_${estudianteCount}">Edad<span class="form-required">*</span></label>
                            <input type="number" id="estudiante_edad_${estudianteCount}" name="estudiante_edad[]" class="form-input" min="1" max="100" required>
                            <div class="form-error" id="estudiante_edad_${estudianteCount}-error">Por favor, ingrese una edad válida.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_fecha_nacimiento_${estudianteCount}">Fecha de Nacimiento</label>
                            <div class="fecha-nacimiento-field">
                                <i class="fas fa-calendar-alt"></i>
                                <input type="date" id="estudiante_fecha_nacimiento_${estudianteCount}" name="estudiante_fecha_nacimiento[]" class="form-input">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_curso_id_${estudianteCount}">Curso<span class="form-required">*</span></label>
                            <select id="estudiante_curso_id_${estudianteCount}" name="estudiante_curso_id[]" class="form-select" required>
                                <option value="">Seleccione un curso...</option>
                                <?php foreach ($cursos as $curso): ?>
                                    <?php if ($curso['estado'] === 'activo'): 
                                        // Preparar información del horario
                                        $infoHorario = "";
                                        if (!empty($curso['fecha_inicio']) && !empty($curso['fecha_fin'])) {
                                            $infoHorario .= " | " . date('d/m/Y', strtotime($curso['fecha_inicio'])) . " al " . date('d/m/Y', strtotime($curso['fecha_fin']));
                                        }
                                        if (!empty($curso['hora_inicio']) && !empty($curso['hora_fin'])) {
                                            $infoHorario .= " | " . date('H:i', strtotime($curso['hora_inicio'])) . " a " . date('H:i', strtotime($curso['hora_fin']));
                                        }
                                        
                                        // Preparar información de días
                                        $diasSemana = "";
                                        if (!empty($curso['dias_semana'])) {
                                            $diasArray = json_decode($curso['dias_semana'], true);
                                            if (is_array($diasArray) && !empty($diasArray)) {
                                                $diasCortos = array_map(function($dia) {
                                                    return ucfirst(substr($dia, 0, 3));
                                                }, $diasArray);
                                                $diasSemana = " | " . implode(", ", $diasCortos);
                                            }
                                        }
                                    ?>
                                    <option value="<?php echo $curso['id']; ?>">
                                        <?php echo htmlspecialchars($curso['nombre']) . $infoHorario . $diasSemana; ?>
                                    </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-error" id="estudiante_curso_id_${estudianteCount}-error">Por favor, seleccione un curso.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_talla_${estudianteCount}">Talla</label>
                            <input type="text" id="estudiante_talla_${estudianteCount}" name="estudiante_talla[]" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">¿Tiene discapacidad?</label>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="estudiante_tiene_discapacidad[${estudianteCount}]" value="no" checked onchange="toggleDiscapacidad(${estudianteCount}, 'no')"> No
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="estudiante_tiene_discapacidad[${estudianteCount}]" value="si" onchange="toggleDiscapacidad(${estudianteCount}, 'si')"> Sí
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="discapacidad_container_${estudianteCount}" style="display: none;">
                            <div class="discapacidad-section">
                                <div class="discapacidad-header">
                                    <i class="fas fa-info-circle"></i>
                                    Observaciones sobre discapacidad
                                </div>
                                <textarea id="estudiante_observaciones_discapacidad_${estudianteCount}" name="estudiante_observaciones_discapacidad[]" class="form-textarea" placeholder="Describa el tipo de discapacidad y cualquier información relevante..."></textarea>
                            </div>
                        </div>
                    </div>
                `;
                
                container.appendChild(newEstudiante);
                
                // Configurar los radio buttons del nuevo estudiante
                const radioButtons = document.querySelectorAll(`input[name="estudiante_tiene_discapacidad[${estudianteCount}]"]`);
                radioButtons.forEach(radio => {
                    radio.addEventListener('change', function() {
                        toggleDiscapacidad(estudianteCount, this.value);
                    });
                });
                
                estudianteCount++;
                
                // Si ya hay 10 estudiantes, ocultar el botón de agregar
                if (estudianteCount >= 10) {
                    document.getElementById('btnAddEstudiante').style.display = 'none';
                }
            }
        });
        
        // Función para eliminar un estudiante
        function removeEstudiante(id) {
            const estudiante = document.getElementById(`estudiante-${id}`);
            estudiante.remove();
            estudianteCount--;
            
            // Mostrar el botón de agregar nuevamente
            document.getElementById('btnAddEstudiante').style.display = 'inline-flex';
        }

        // Función para mostrar/ocultar el campo de observaciones de discapacidad
        function toggleDiscapacidad(id, valor) {
            const container = document.getElementById(`discapacidad_container_${id}`);
            if (valor === 'si') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
                // Limpiar el campo cuando se deselecciona
                document.getElementById(`estudiante_observaciones_discapacidad_${id}`).value = '';
            }
        }
        
        // Inicializar el primer estudiante
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar los radio buttons del primer estudiante
            const radioButtons = document.querySelectorAll('input[name="estudiante_tiene_discapacidad[0]"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    toggleDiscapacidad(0, this.value);
                });
            });
        });
        
        // Función para reorganizar los índices de los estudiantes
        function reorganizarIndices() {
            // Obtener todos los contenedores de estudiantes
            const estudiantes = document.querySelectorAll('.estudiante-container');
            let nuevoIndice = 0;
            
            // Para cada estudiante existente, reasignar los índices
            estudiantes.forEach((estudiante, index) => {
                // Verificar si el estudiante tiene datos
                const nombres = estudiante.querySelector('input[name^="estudiante_nombres"]');
                const apellidos = estudiante.querySelector('input[name^="estudiante_apellidos"]');
                const edad = estudiante.querySelector('input[name^="estudiante_edad"]');
                
                if (nombres && nombres.value.trim() && apellidos && apellidos.value.trim() && edad && edad.value) {
                    // Este estudiante tiene datos, actualizar sus índices
                    const radioButtons = estudiante.querySelectorAll('input[type="radio"]');
                    
                    // Actualizar el nombre de los radio buttons
                    radioButtons.forEach(radio => {
                        // Solo actualizar si el nombre tiene el formato "estudiante_tiene_discapacidad[X]"
                        const match = radio.name.match(/estudiante_tiene_discapacidad\[\d+\]/);
                        if (match) {
                            radio.name = `estudiante_tiene_discapacidad[${nuevoIndice}]`;
                        }
                    });
                    
                    nuevoIndice++;
                } else {
                    // Este estudiante no tiene datos válidos, removerlo del envío
                    if (nombres) nombres.disabled = true;
                    if (apellidos) apellidos.disabled = true;
                    if (edad) edad.disabled = true;
                    const curso = estudiante.querySelector('select[name^="estudiante_curso_id"]');
                    if (curso) curso.disabled = true;
                    const talla = estudiante.querySelector('input[name^="estudiante_talla"]');
                    if (talla) talla.disabled = true;
                    const fechaNacimiento = estudiante.querySelector('input[name^="estudiante_fecha_nacimiento"]');
                    if (fechaNacimiento) fechaNacimiento.disabled = true;
                    const observaciones = estudiante.querySelector('textarea[name^="estudiante_observaciones_discapacidad"]');
                    if (observaciones) observaciones.disabled = true;
                    
                    // Deshabilitar radio buttons
                    radioButtons.forEach(radio => {
                        radio.disabled = true;
                    });
                }
            });
        }
        
        // Validación del formulario
        document.getElementById('createTitularForm').addEventListener('submit', function(e) {
            let hasErrors = false;
            
            // Validar cédula del titular
            const cedula = document.getElementById('cedula');
            if (!cedula.value.trim() || !/^\d{7,12}$/.test(cedula.value.trim())) {
                showError(cedula, 'cedula-error', 'Por favor, ingrese un número de cédula válido (7-12 dígitos).');
                hasErrors = true;
            } else {
                hideError(cedula, 'cedula-error');
            }
            
            // Validar nombres del titular
            const nombres = document.getElementById('nombres');
            if (!nombres.value.trim()) {
                showError(nombres, 'nombres-error', 'Por favor, ingrese los nombres.');
                hasErrors = true;
            } else {
                hideError(nombres, 'nombres-error');
            }
            
            // Validar apellidos del titular
            const apellidos = document.getElementById('apellidos');
            if (!apellidos.value.trim()) {
                showError(apellidos, 'apellidos-error', 'Por favor, ingrese los apellidos.');
                hasErrors = true;
            } else {
                hideError(apellidos, 'apellidos-error');
            }
            
            // Validar dirección del titular
            const direccion = document.getElementById('direccion');
            if (!direccion.value.trim()) {
                showError(direccion, 'direccion-error', 'Por favor, ingrese la dirección.');
                hasErrors = true;
            } else {
                hideError(direccion, 'direccion-error');
            }
            
            // Validar correo del titular (opcional)
            const email = document.getElementById('email');
            if (email.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
                showError(email, 'email-error', 'Por favor, ingrese un correo electrónico válido.');
                hasErrors = true;
            } else {
                hideError(email, 'email-error');
            }
            
            // Validar correo de la referencia (opcional)
            const refEmail = document.getElementById('referencia_email');
            if (refEmail.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(refEmail.value.trim())) {
                showError(refEmail, 'referencia_email-error', 'Por favor, ingrese un correo electrónico válido.');
                hasErrors = true;
            } else {
                hideError(refEmail, 'referencia_email-error');
            }
            
            // Validar campos de estudiantes
            for (let i = 0; i < estudianteCount; i++) {
                const estudianteElement = document.getElementById(`estudiante-${i}`);
                // Solo validar si el elemento existe (podría haber sido eliminado)
                if (estudianteElement) {
                    // Validar nombres del estudiante
                    const estudiante_nombres = document.getElementById(`estudiante_nombres_${i}`);
                    if (estudiante_nombres && (!estudiante_nombres.value.trim())) {
                        showError(estudiante_nombres, `estudiante_nombres_${i}-error`, 'Por favor, ingrese los nombres.');
                        hasErrors = true;
                    } else if (estudiante_nombres) {
                        hideError(estudiante_nombres, `estudiante_nombres_${i}-error`);
                    }
                    
                    // Validar apellidos del estudiante
                    const estudiante_apellidos = document.getElementById(`estudiante_apellidos_${i}`);
                    if (estudiante_apellidos && (!estudiante_apellidos.value.trim())) {
                        showError(estudiante_apellidos, `estudiante_apellidos_${i}-error`, 'Por favor, ingrese los apellidos.');
                        hasErrors = true;
                    } else if (estudiante_apellidos) {
                        hideError(estudiante_apellidos, `estudiante_apellidos_${i}-error`);
                    }
                    
                    // Validar edad del estudiante
                    const estudiante_edad = document.getElementById(`estudiante_edad_${i}`);
                    if (estudiante_edad && (!estudiante_edad.value || estudiante_edad.value < 1 || estudiante_edad.value > 100)) {
                        showError(estudiante_edad, `estudiante_edad_${i}-error`, 'Por favor, ingrese una edad válida (entre 1 y 100).');
                        hasErrors = true;
                    } else if (estudiante_edad) {
                        hideError(estudiante_edad, `estudiante_edad_${i}-error`);
                    }
                    
                    // Validar curso del estudiante
                    const estudiante_curso_id = document.getElementById(`estudiante_curso_id_${i}`);
                    if (estudiante_curso_id && !estudiante_curso_id.value) {
                        showError(estudiante_curso_id, `estudiante_curso_id_${i}-error`, 'Por favor, seleccione un curso.');
                        hasErrors = true;
                    } else if (estudiante_curso_id) {
                        hideError(estudiante_curso_id, `estudiante_curso_id_${i}-error`);
                    }
                }
            }
            
            // Verificar si hay al menos un estudiante válido
            let estudiantesValidos = false;
            for (let i = 0; i < estudianteCount; i++) {
                const estudiante_nombres = document.getElementById(`estudiante_nombres_${i}`);
                const estudiante_apellidos = document.getElementById(`estudiante_apellidos_${i}`);
                const estudiante_edad = document.getElementById(`estudiante_edad_${i}`);
                const estudiante_curso_id = document.getElementById(`estudiante_curso_id_${i}`);
                
                if (estudiante_nombres && estudiante_apellidos && estudiante_edad && estudiante_curso_id) {
                    if (estudiante_nombres.value.trim() && estudiante_apellidos.value.trim() && 
                        estudiante_edad.value && estudiante_edad.value > 0 && estudiante_edad.value <= 100 && 
                        estudiante_curso_id.value) {
                        estudiantesValidos = true;
                        break;
                    }
                }
            }
            
            // Si no hay estudiantes válidos, mostrar error
            if (!estudiantesValidos) {
                // Mostrar un mensaje de error en la parte superior del formulario
                const mainContent = document.querySelector('.main-content');
                const formHeader = document.querySelector('.header');
                
                const errorMessage = document.createElement('div');
                errorMessage.className = 'alert alert-error';
                errorMessage.innerHTML = '<i class="fas fa-exclamation-circle"></i> Debe completar la información de al menos un estudiante.';
                
                // Insertar después del header
                if (formHeader && formHeader.nextSibling) {
                    mainContent.insertBefore(errorMessage, formHeader.nextSibling);
                } else {
                    mainContent.appendChild(errorMessage);
                }
                
                hasErrors = true;
                
                // Desplazar la página hacia arriba para mostrar el mensaje
                window.scrollTo(0, 0);
            }
            
            // Si hay errores, detener el envío del formulario
            if (hasErrors) {
                e.preventDefault();
            } else {
                // Si todo está bien, reorganizar los índices para enviar correctamente
                reorganizarIndices();
            }
        });
        
        // Función para mostrar mensajes de error
        function showError(input, errorId, message) {
            input.classList.add('error');
            const errorElement = document.getElementById(errorId);
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        
        // Función para ocultar mensajes de error
        function hideError(input, errorId) {
            input.classList.remove('error');
            document.getElementById(errorId).style.display = 'none';
        }
    </script>
</body>
</html>