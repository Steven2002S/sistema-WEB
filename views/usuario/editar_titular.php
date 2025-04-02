<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Titular - Usuario</title>
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
        
        .btn-warning {
            background-color: var(--warning-color);
            color: white;
        }
        
        .btn-warning:hover {
            background-color: #e08600;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #d32f2f;
        }
        
        .estudiante-container {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
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
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        
        .btn-remove:hover {
            background-color: rgba(244, 67, 54, 0.2);
            border-color: var(--danger-color);
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

        /* Estilos para nuevo estudiante */
        #nuevoEstudianteForm {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #f0f8ff;
            border-radius: 8px;
            border: 1px solid #b3d7ff;
        }

        #nuevoEstudianteForm.active {
            display: block;
        }

        .section-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
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

        /* Estilos para la información de discapacidad en la vista */
        .info-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }

        .badge-si {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
        }

        .badge-no {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .info-field {
            display: flex;
            align-items: center;
        }

        .info-field i {
            margin-right: 8px;
            color: var(--primary-color);
            font-size: 16px;
        }

        .info-field .text-muted {
            color: #6c757d;
            font-style: italic;
        }

        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 10px;
            margin-top: 8px;
        }
        
        /* Estilos para edición inline */
        .editable-container {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        
        .editable-container:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .editable-container.editing {
            background-color: #f0f8ff;
            border-color: var(--primary-color);
            box-shadow: 0 0 12px rgba(0, 119, 194, 0.25);
        }
        
        .editable-view, .editable-form {
            width: 100%;
        }
        
        .editable-form {
            display: none;
        }
        
        .editable-container.editing .editable-view {
            display: none;
        }
        
        .editable-container.editing .editable-form {
            display: block;
        }
        
        .editable-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .editable-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
        }
        
        .editable-title i {
            margin-right: 8px;
            color: var(--primary-color);
        }
        
        .edit-buttons {
            display: flex;
            gap: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            border: 1px solid var(--border-color);
            margin-top: 15px;
        }
        
        .info-group {
            margin-bottom: 15px;
        }
        
        .info-label {
            font-weight: 600;
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 15px;
            line-height: 1.4;
        }
        
        .toggle-edit-btn {
            background-color: var(--background-color);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .toggle-edit-btn:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Confirmación de eliminación */
        .confirm-delete {
            background-color: rgba(0, 0, 0, 0.75);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            transition: all 0.3s ease;
            backdrop-filter: blur(3px);
        }
        
        .confirm-delete-content {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            animation: fadeIn 0.3s;
        }
        
        .confirm-delete-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--danger-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .confirm-delete-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
        }
        
        .confirm-delete-buttons .btn {
            padding: 10px 20px;
            min-width: 120px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Mejoras para curso-fechas */
        .curso-fechas {
            font-weight: 500;
            margin-top: 5px;
            padding: 4px 0;
        }
        
        /* Botones de acción globales */
        .global-actions {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            margin-bottom: 40px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 20px;
            position: sticky;
            bottom: 20px;
            z-index: 100;
        }
        
        .global-actions .btn {
            min-width: 160px;
            font-size: 16px;
            padding: 12px 24px;
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
            <h1 class="page-title">Editar Titular</h1>
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

        <!-- Formulario principal para el titular -->
        <form id="editTitularForm" action="index.php?controller=usuario&action=actualizarTitular" method="POST">
            <input type="hidden" name="id" value="<?php echo $titular['id']; ?>">
            
            <!-- Información del Titular -->
            <div class="form-section">
                <h2 class="form-title"><i class="fas fa-user-tie"></i> Información del Titular</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="cedula">Cédula<span class="form-required">*</span></label>
                        <input type="text" id="cedula" name="cedula" class="form-input" value="<?php echo htmlspecialchars($titular['cedula']); ?>" required>
                        <div class="form-error" id="cedula-error">Por favor, ingrese un número de cédula válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="nombres">Nombres<span class="form-required">*</span></label>
                        <input type="text" id="nombres" name="nombres" class="form-input" value="<?php echo htmlspecialchars($titular['nombres']); ?>" required>
                        <div class="form-error" id="nombres-error">Por favor, ingrese los nombres.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="apellidos">Apellidos<span class="form-required">*</span></label>
                        <input type="text" id="apellidos" name="apellidos" class="form-input" value="<?php echo htmlspecialchars($titular['apellidos']); ?>" required>
                        <div class="form-error" id="apellidos-error">Por favor, ingrese los apellidos.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="direccion">Dirección<span class="form-required">*</span></label>
                        <textarea id="direccion" name="direccion" class="form-textarea" required><?php echo htmlspecialchars($titular['direccion']); ?></textarea>
                        <div class="form-error" id="direccion-error">Por favor, ingrese la dirección.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-input" value="<?php echo htmlspecialchars($titular['email']); ?>">
                        <div class="form-error" id="email-error">Por favor, ingrese un correo válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="empresa">Empresa/Organización</label>
                        <input type="text" id="empresa" name="empresa" class="form-input" value="<?php echo htmlspecialchars($titular['empresa']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="celular">Celular</label>
                        <input type="text" id="celular" name="celular" class="form-input" value="<?php echo htmlspecialchars($titular['celular']); ?>">
                        <div class="form-error" id="celular-error">Por favor, ingrese un número de celular válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="telefono_casa">Teléfono Casa</label>
                        <input type="text" id="telefono_casa" name="telefono_casa" class="form-input" value="<?php echo htmlspecialchars($titular['telefono_casa']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="cargo">Cargo</label>
                        <input type="text" id="cargo" name="cargo" class="form-input" value="<?php echo htmlspecialchars($titular['cargo']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="telefono_trabajo">Teléfono Trabajo</label>
                        <input type="text" id="telefono_trabajo" name="telefono_trabajo" class="form-input" value="<?php echo htmlspecialchars($titular['telefono_trabajo']); ?>">
                    </div>
                </div>
            </div>
        </form>

        <!-- Sección de Estudiantes con edición inline -->
        <div class="form-section">
            <h2 class="form-title"><i class="fas fa-user-graduate"></i> Estudiantes Asociados</h2>
            
            <?php if (!empty($estudiantes)): ?>
                <div class="estudiantes-list">
                <?php foreach ($estudiantes as $index => $estudiante): ?>
                    <div class="editable-container" id="estudiante-<?php echo $estudiante['id']; ?>">
                        <!-- Vista normal (sin edición) -->
                        <div class="editable-view">
                            <div class="editable-header">
                                <h3 class="editable-title">
                                    <i class="fas fa-user-graduate"></i>
                                    Estudiante <?php echo $index + 1; ?>: <?php echo htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']); ?>
                                </h3>
                                <div class="edit-buttons">
                                    <button type="button" class="toggle-edit-btn" onclick="toggleEstudianteEdit(<?php echo $estudiante['id']; ?>)">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button type="button" class="btn-remove" onclick="confirmarEliminarEstudiante(<?php echo $estudiante['id']; ?>)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                            
                            <div class="info-grid">
                                <div class="info-group">
                                    <div class="info-label">Cédula:</div>
                                    <div class="info-value"><?php echo empty($estudiante['cedula']) ? 'No disponible' : htmlspecialchars($estudiante['cedula']); ?></div>
                                </div>
                                
                                <div class="info-group">
                                    <div class="info-label">Edad:</div>
                                    <div class="info-value"><?php echo htmlspecialchars($estudiante['edad']); ?> años</div>
                                </div>
                                
                                <div class="info-group">
                                    <div class="info-label">Fecha de Nacimiento:</div>
                                    <div class="info-value info-field">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?php if (!empty($estudiante['fecha_nacimiento'])): ?>
                                            <?php echo date('d/m/Y', strtotime($estudiante['fecha_nacimiento'])); ?>
                                        <?php else: ?>
                                            <span class="text-muted">No registrada</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="info-group">
                                    <div class="info-label">Curso:</div>
                                    <div class="info-value">
                                        <strong><?php echo htmlspecialchars($estudiante['curso_nombre']); ?></strong>
                                        <?php 
                                            // Mostrar información adicional del curso si está disponible
                                            if (!empty($estudiante['curso_fecha_inicio']) && !empty($estudiante['curso_fecha_fin'])): 
                                        ?>
                                        <div class="info-field curso-fechas">
                                            <i class="fas fa-calendar-week"></i>
                                            <span>Del <?php echo date('d/m/Y', strtotime($estudiante['curso_fecha_inicio'])); ?> 
                                            al <?php echo date('d/m/Y', strtotime($estudiante['curso_fecha_fin'])); ?></span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($estudiante['curso_hora_inicio']) && !empty($estudiante['curso_hora_fin'])): ?>
                                        <div class="info-field">
                                            <i class="fas fa-clock"></i>
                                            <span><?php echo date('H:i', strtotime($estudiante['curso_hora_inicio'])); ?> 
                                            a <?php echo date('H:i', strtotime($estudiante['curso_hora_fin'])); ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="info-group">
                                    <div class="info-label">Talla:</div>
                                    <div class="info-value"><?php echo empty($estudiante['talla']) ? 'No disponible' : htmlspecialchars($estudiante['talla']); ?></div>
                                </div>
                                
                                <div class="info-group">
                                    <div class="info-label">Discapacidad:</div>
                                    <div class="info-value">
                                        <?php if (!empty($estudiante['tiene_discapacidad'])): ?>
                                            <span class="info-field">
                                                <?php if ($estudiante['tiene_discapacidad'] == 'si'): ?>
                                                    <i class="fas fa-wheelchair"></i>
                                                    Sí
                                                    <span class="info-badge badge-si">Requiere atención especial</span>
                                                <?php else: ?>
                                                    <i class="fas fa-check-circle"></i>
                                                    No
                                                    <span class="info-badge badge-no">Sin discapacidad</span>
                                                <?php endif; ?>
                                            </span>
                                            
                                            <?php if ($estudiante['tiene_discapacidad'] == 'si' && !empty($estudiante['observaciones_discapacidad'])): ?>
                                                <div class="info-box">
                                                <strong>Observaciones:</strong> 
                                                    <?php echo htmlspecialchars($estudiante['observaciones_discapacidad']); ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">No registrado</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Formulario de edición (inicialmente oculto) -->
                        <div class="editable-form">
                            <form action="index.php?controller=usuario&action=editarEstudiante" method="POST" class="estudiante-edit-form">
                                <input type="hidden" name="id" value="<?php echo $estudiante['id']; ?>">
                                
                                <div class="editable-header">
                                    <h3 class="editable-title">
                                        <i class="fas fa-edit"></i>
                                        Editar Estudiante
                                    </h3>
                                    <button type="button" class="toggle-edit-btn" onclick="toggleEstudianteEdit(<?php echo $estudiante['id']; ?>)">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                </div>
                                
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="form-label" for="estudiante_cedula_<?php echo $estudiante['id']; ?>">Cédula</label>
                                        <input type="text" id="estudiante_cedula_<?php echo $estudiante['id']; ?>" name="cedula" class="form-input" 
                                            value="<?php echo htmlspecialchars($estudiante['cedula'] ?? ''); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label" for="estudiante_nombres_<?php echo $estudiante['id']; ?>">Nombres<span class="form-required">*</span></label>
                                        <input type="text" id="estudiante_nombres_<?php echo $estudiante['id']; ?>" name="nombres" class="form-input" 
                                            value="<?php echo htmlspecialchars($estudiante['nombres']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label" for="estudiante_apellidos_<?php echo $estudiante['id']; ?>">Apellidos<span class="form-required">*</span></label>
                                        <input type="text" id="estudiante_apellidos_<?php echo $estudiante['id']; ?>" name="apellidos" class="form-input" 
                                            value="<?php echo htmlspecialchars($estudiante['apellidos']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label" for="estudiante_edad_<?php echo $estudiante['id']; ?>">Edad<span class="form-required">*</span></label>
                                        <input type="number" id="estudiante_edad_<?php echo $estudiante['id']; ?>" name="edad" class="form-input" 
                                            value="<?php echo htmlspecialchars($estudiante['edad']); ?>" min="1" max="100" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label" for="estudiante_fecha_nacimiento_<?php echo $estudiante['id']; ?>">Fecha de Nacimiento</label>
                                        <div class="fecha-nacimiento-field">
                                            <i class="fas fa-calendar-alt"></i>
                                            <input type="date" id="estudiante_fecha_nacimiento_<?php echo $estudiante['id']; ?>" name="fecha_nacimiento" class="form-input" 
                                                value="<?php echo $estudiante['fecha_nacimiento'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label" for="estudiante_curso_id_<?php echo $estudiante['id']; ?>">Curso<span class="form-required">*</span></label>
                                        <select id="estudiante_curso_id_<?php echo $estudiante['id']; ?>" name="curso_id" class="form-select" required>
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
                                                <option value="<?php echo $curso['id']; ?>" <?php echo ($estudiante['curso_id'] == $curso['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($curso['nombre']) . $infoHorario . $diasSemana; ?>
                                                </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label" for="estudiante_talla_<?php echo $estudiante['id']; ?>">Talla</label>
                                        <input type="text" id="estudiante_talla_<?php echo $estudiante['id']; ?>" name="talla" class="form-input" 
                                            value="<?php echo htmlspecialchars($estudiante['talla'] ?? ''); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label" for="estudiante_titular_id_<?php echo $estudiante['id']; ?>">Titular/Representante<span class="form-required">*</span></label>
                                        <select id="estudiante_titular_id_<?php echo $estudiante['id']; ?>" name="titular_id" class="form-select" required>
                                            <?php foreach ($titulares as $t): ?>
                                                <option value="<?php echo $t['id']; ?>" <?php echo ($estudiante['titular_id'] == $t['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($t['nombres'] . ' ' . $t['apellidos'] . ' (' . $t['cedula'] . ')'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label">¿Tiene discapacidad?</label>
                                        <div class="radio-group">
                                            <label class="radio-label">
                                                <input type="radio" name="tiene_discapacidad" value="no" <?php echo ($estudiante['tiene_discapacidad'] != 'si') ? 'checked' : ''; ?> 
                                                    onchange="toggleDiscapacidadEdit(<?php echo $estudiante['id']; ?>, 'no')"> No
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="tiene_discapacidad" value="si" <?php echo ($estudiante['tiene_discapacidad'] == 'si') ? 'checked' : ''; ?> 
                                                    onchange="toggleDiscapacidadEdit(<?php echo $estudiante['id']; ?>, 'si')"> Sí
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" id="discapacidad_container_<?php echo $estudiante['id']; ?>" style="<?php echo ($estudiante['tiene_discapacidad'] == 'si') ? 'display: block;' : 'display: none;'; ?>">
                                        <div class="discapacidad-section">
                                            <div class="discapacidad-header">
                                                <i class="fas fa-info-circle"></i>
                                                Observaciones sobre discapacidad
                                            </div>
                                            <textarea id="estudiante_observaciones_discapacidad_<?php echo $estudiante['id']; ?>" name="observaciones_discapacidad" class="form-textarea" 
                                                placeholder="Describa el tipo de discapacidad y cualquier información relevante..."><?php echo htmlspecialchars($estudiante['observaciones_discapacidad'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-buttons">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="toggleEstudianteEdit(<?php echo $estudiante['id']; ?>)">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No hay estudiantes asociados a este titular.</p>
            <?php endif; ?>
            
            <div class="section-actions">
                <button type="button" class="btn btn-add" onclick="toggleNuevoEstudiante()">
                    <i class="fas fa-plus"></i> Agregar Nuevo Estudiante
                </button>
                <a href="index.php?controller=usuario&action=crearEstudiante&titular_id=<?php echo $titular['id']; ?>" class="btn btn-secondary">
                    <i class="fas fa-external-link-alt"></i> Ir a Pantalla Completa
                </a>
            </div>
            
            <!-- Formulario para nuevo estudiante -->
            <div id="nuevoEstudianteForm" style="display:none;">
                <form action="index.php?controller=usuario&action=crearEstudianteInline" method="POST">
                    <input type="hidden" name="titular_id" value="<?php echo $titular['id']; ?>">
                    
                    <h3 class="estudiante-title"><i class="fas fa-user-graduate"></i> Nuevo Estudiante</h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="estudiante_cedula">Cédula</label>
                            <input type="text" id="estudiante_cedula" name="cedula" class="form-input">
                            <div class="form-error" id="estudiante_cedula-error">Por favor, ingrese un número de cédula válido.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_nombres">Nombres<span class="form-required">*</span></label>
                            <input type="text" id="estudiante_nombres" name="nombres" class="form-input" required>
                            <div class="form-error" id="estudiante_nombres-error">Por favor, ingrese los nombres.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_apellidos">Apellidos<span class="form-required">*</span></label>
                            <input type="text" id="estudiante_apellidos" name="apellidos" class="form-input" required>
                            <div class="form-error" id="estudiante_apellidos-error">Por favor, ingrese los apellidos.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_edad">Edad<span class="form-required">*</span></label>
                            <input type="number" id="estudiante_edad" name="edad" class="form-input" min="1" max="100" required>
                            <div class="form-error" id="estudiante_edad-error">Por favor, ingrese una edad válida.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_fecha_nacimiento">Fecha de Nacimiento</label>
                            <div class="fecha-nacimiento-field">
                                <i class="fas fa-calendar-alt"></i>
                                <input type="date" id="estudiante_fecha_nacimiento" name="fecha_nacimiento" class="form-input">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_curso_id">Curso<span class="form-required">*</span></label>
                            <select id="estudiante_curso_id" name="curso_id" class="form-select" required>
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
                            <div class="form-error" id="estudiante_curso_id-error">Por favor, seleccione un curso.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="estudiante_talla">Talla</label>
                            <input type="text" id="estudiante_talla" name="talla" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">¿Tiene discapacidad?</label>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="tiene_discapacidad" value="no" checked onchange="toggleDiscapacidad('nuevo', 'no')"> No
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="tiene_discapacidad" value="si" onchange="toggleDiscapacidad('nuevo', 'si')"> Sí
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="discapacidad_container_nuevo" style="display: none;">
                            <div class="discapacidad-section">
                                <div class="discapacidad-header">
                                    <i class="fas fa-info-circle"></i>
                                    Observaciones sobre discapacidad
                                </div>
                                <textarea id="estudiante_observaciones_discapacidad" name="observaciones_discapacidad" class="form-textarea" 
                                    placeholder="Describa el tipo de discapacidad y cualquier información relevante..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Estudiante
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="toggleNuevoEstudiante()">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sección de Referencia Personal con edición inline -->
        <div class="form-section">
            <h2 class="form-title"><i class="fas fa-address-book"></i> Referencia Personal</h2>
            
            <?php if (!empty($referencias)): ?>
                <?php $referencia = $referencias[0]; // Tomamos la primera referencia ?>
                <div class="editable-container" id="referencia-<?php echo $referencia['id']; ?>">
                    <!-- Vista normal (sin edición) -->
                    <div class="editable-view">
                        <div class="editable-header">
                            <h3 class="editable-title">
                                <i class="fas fa-address-book"></i>
                                Información de Contacto
                            </h3>
                            <button type="button" class="toggle-edit-btn" onclick="toggleReferenciaEdit(<?php echo $referencia['id']; ?>)">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        </div>
                        
                        <div class="info-grid">
                            <div class="info-group">
                                <div class="info-label">Nombres:</div>
                                <div class="info-value"><?php echo htmlspecialchars($referencia['nombres']); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Apellidos:</div>
                                <div class="info-value"><?php echo htmlspecialchars($referencia['apellidos']); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Dirección:</div>
                                <div class="info-value"><?php echo htmlspecialchars($referencia['direccion']); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Email:</div>
                                <div class="info-value"><?php echo empty($referencia['email']) ? 'No disponible' : htmlspecialchars($referencia['email']); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Celular:</div>
                                <div class="info-value"><?php echo empty($referencia['celular']) ? 'No disponible' : htmlspecialchars($referencia['celular']); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Teléfono Casa:</div>
                                <div class="info-value"><?php echo empty($referencia['telefono_casa']) ? 'No disponible' : htmlspecialchars($referencia['telefono_casa']); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Empresa:</div>
                                <div class="info-value"><?php echo empty($referencia['empresa']) ? 'No disponible' : htmlspecialchars($referencia['empresa']); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Cargo:</div>
                                <div class="info-value"><?php echo empty($referencia['cargo']) ? 'No disponible' : htmlspecialchars($referencia['cargo']); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Teléfono Trabajo:</div>
                                <div class="info-value"><?php echo empty($referencia['telefono_trabajo']) ? 'No disponible' : htmlspecialchars($referencia['telefono_trabajo']); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Formulario de edición (inicialmente oculto) -->
                    <div class="editable-form">
                        <form action="index.php?controller=usuario&action=actualizarReferencia" method="POST" class="referencia-edit-form">
                            <input type="hidden" name="id" value="<?php echo $referencia['id']; ?>">
                            <input type="hidden" name="titular_id" value="<?php echo $titular['id']; ?>">
                            
                            <div class="editable-header">
                                <h3 class="editable-title">
                                    <i class="fas fa-edit"></i>
                                    Editar Referencia Personal
                                </h3>
                                <button type="button" class="toggle-edit-btn" onclick="toggleReferenciaEdit(<?php echo $referencia['id']; ?>)">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label" for="referencia_nombres_<?php echo $referencia['id']; ?>">Nombres<span class="form-required">*</span></label>
                                    <input type="text" id="referencia_nombres_<?php echo $referencia['id']; ?>" name="nombres" class="form-input" 
                                        value="<?php echo htmlspecialchars($referencia['nombres']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_apellidos_<?php echo $referencia['id']; ?>">Apellidos<span class="form-required">*</span></label>
                                    <input type="text" id="referencia_apellidos_<?php echo $referencia['id']; ?>" name="apellidos" class="form-input" 
                                        value="<?php echo htmlspecialchars($referencia['apellidos']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_direccion_<?php echo $referencia['id']; ?>">Dirección<span class="form-required">*</span></label>
                                    <textarea id="referencia_direccion_<?php echo $referencia['id']; ?>" name="direccion" class="form-textarea" required><?php echo htmlspecialchars($referencia['direccion']); ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_email_<?php echo $referencia['id']; ?>">Correo Electrónico</label>
                                    <input type="email" id="referencia_email_<?php echo $referencia['id']; ?>" name="email" class="form-input" 
                                        value="<?php echo htmlspecialchars($referencia['email'] ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_celular_<?php echo $referencia['id']; ?>">Celular</label>
                                    <input type="text" id="referencia_celular_<?php echo $referencia['id']; ?>" name="celular" class="form-input" 
                                        value="<?php echo htmlspecialchars($referencia['celular'] ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_telefono_casa_<?php echo $referencia['id']; ?>">Teléfono Casa</label>
                                    <input type="text" id="referencia_telefono_casa_<?php echo $referencia['id']; ?>" name="telefono_casa" class="form-input" 
                                        value="<?php echo htmlspecialchars($referencia['telefono_casa'] ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_empresa_<?php echo $referencia['id']; ?>">Empresa</label>
                                    <input type="text" id="referencia_empresa_<?php echo $referencia['id']; ?>" name="empresa" class="form-input" 
                                        value="<?php echo htmlspecialchars($referencia['empresa'] ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_cargo_<?php echo $referencia['id']; ?>">Cargo</label>
                                    <input type="text" id="referencia_cargo_<?php echo $referencia['id']; ?>" name="cargo" class="form-input" 
                                        value="<?php echo htmlspecialchars($referencia['cargo'] ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_telefono_trabajo_<?php echo $referencia['id']; ?>">Teléfono Trabajo</label>
                                    <input type="text" id="referencia_telefono_trabajo_<?php echo $referencia['id']; ?>" name="telefono_trabajo" class="form-input" 
                                        value="<?php echo htmlspecialchars($referencia['telefono_trabajo'] ?? ''); ?>">
                                </div>
                            </div>
                            
                            <div class="form-buttons">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="toggleReferenciaEdit(<?php echo $referencia['id']; ?>)">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <!-- Si no hay referencias, mostrar formulario para crear una nueva -->
                <div class="editable-container" id="nueva-referencia">
                    <div class="editable-view">
                        <p>No hay referencias personales asociadas a este titular.</p>
                        <div class="form-buttons">
                            <button type="button" class="btn btn-add" onclick="toggleNuevaReferencia()">
                                <i class="fas fa-plus"></i> Agregar Referencia
                            </button>
                        </div>
                    </div>
                    
                    <!-- Formulario para crear referencia (inicialmente oculto) -->
                    <div class="editable-form" style="display: none;">
                        <form action="index.php?controller=usuario&action=crearReferencia" method="POST" class="referencia-create-form">
                            <input type="hidden" name="titular_id" value="<?php echo $titular['id']; ?>">
                            
                            <div class="editable-header">
                                <h3 class="editable-title">
                                    <i class="fas fa-plus"></i>
                                    Nueva Referencia Personal
                                </h3>
                                <button type="button" class="toggle-edit-btn" onclick="toggleNuevaReferencia()">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label" for="referencia_nombres">Nombres<span class="form-required">*</span></label>
                                    <input type="text" id="referencia_nombres" name="nombres" class="form-input" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_apellidos">Apellidos<span class="form-required">*</span></label>
                                    <input type="text" id="referencia_apellidos" name="apellidos" class="form-input" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_direccion">Dirección<span class="form-required">*</span></label>
                                    <textarea id="referencia_direccion" name="direccion" class="form-textarea" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_email">Correo Electrónico</label>
                                    <input type="email" id="referencia_email" name="email" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_celular">Celular</label>
                                    <input type="text" id="referencia_celular" name="celular" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_telefono_casa">Teléfono Casa</label>
                                    <input type="text" id="referencia_telefono_casa" name="telefono_casa" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_empresa">Empresa</label>
                                    <input type="text" id="referencia_empresa" name="empresa" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_cargo">Cargo</label>
                                    <input type="text" id="referencia_cargo" name="cargo" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="referencia_telefono_trabajo">Teléfono Trabajo</label>
                                    <input type="text" id="referencia_telefono_trabajo" name="telefono_trabajo" class="form-input">
                                </div>
                            </div>
                            
                            <div class="form-buttons">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Referencia
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="toggleNuevaReferencia()">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Botones de acción globales al final de la página -->
        <div class="global-actions">
            <button type="button" class="btn btn-primary" onclick="document.getElementById('editTitularForm').submit();">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <button type="button" class="btn btn-secondary" onclick="volverAListadoTitulares()">
                <i class="fas fa-arrow-left"></i> Volver al Listado de Titulares
            </button>
        </div>
    </div>
    
    <!-- Confirmación de eliminación (reemplaza los modales) -->
    <div id="confirmDeleteEstudiante" class="confirm-delete" style="display: none;">
        <div class="confirm-delete-content">
            <h3 class="confirm-delete-title"><i class="fas fa-trash"></i> Confirmar eliminación</h3>
            <p>¿Estás seguro de que deseas eliminar este estudiante? Esta acción no se puede deshacer.</p>
            <div class="confirm-delete-buttons">
                <button class="btn btn-secondary" onclick="cancelarEliminarEstudiante()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button class="btn btn-danger" id="btnConfirmarEliminarEstudiante">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Variables globales para gestionar la eliminación
        let estudianteIdEliminar = null;
        
        // Validación del formulario principal
        document.getElementById('editTitularForm').addEventListener('submit', function(e) {
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
            
           // Si hay errores, detener el envío del formulario
           if (hasErrors) {
                e.preventDefault();
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
        
        // Funciones para edición inline de estudiantes
        function toggleEstudianteEdit(id) {
            const container = document.getElementById('estudiante-' + id);
            container.classList.toggle('editing');
        }
        
        // Funciones para edición inline de referencia
        function toggleReferenciaEdit(id) {
            const container = document.getElementById('referencia-' + id);
            container.classList.toggle('editing');
        }
        
        // Función para mostrar/ocultar formulario de nueva referencia
        function toggleNuevaReferencia() {
            const container = document.getElementById('nueva-referencia');
            container.classList.toggle('editing');
        }
        
        // Funcionalidad para mostrar/ocultar formulario de nuevo estudiante
        function toggleNuevoEstudiante() {
            const form = document.getElementById('nuevoEstudianteForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
        
        // Función para mostrar/ocultar el campo de observaciones de discapacidad
        function toggleDiscapacidad(id, valor) {
            const container = document.getElementById(`discapacidad_container_${id}`);
            if (valor === 'si') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
                // Limpiar el campo cuando se deselecciona
                if (id === 'nuevo') {
                    document.getElementById('estudiante_observaciones_discapacidad').value = '';
                }
            }
        }
        
        // Función específica para los estudiantes editables
        function toggleDiscapacidadEdit(id, valor) {
            const container = document.getElementById(`discapacidad_container_${id}`);
            if (valor === 'si') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
                // No limpiamos el campo en este caso para que no se pierdan datos accidentalmente
            }
        }
        
        // Validación para el formulario de nuevo estudiante
        document.querySelector('#nuevoEstudianteForm form').addEventListener('submit', function(e) {
            let hasErrors = false;
            
            // Validar nombres del estudiante
            const estudiante_nombres = document.getElementById('estudiante_nombres');
            if (!estudiante_nombres.value.trim()) {
                showError(estudiante_nombres, 'estudiante_nombres-error', 'Por favor, ingrese los nombres.');
                hasErrors = true;
            } else {
                hideError(estudiante_nombres, 'estudiante_nombres-error');
            }
            
            // Validar apellidos del estudiante
            const estudiante_apellidos = document.getElementById('estudiante_apellidos');
            if (!estudiante_apellidos.value.trim()) {
                showError(estudiante_apellidos, 'estudiante_apellidos-error', 'Por favor, ingrese los apellidos.');
                hasErrors = true;
            } else {
                hideError(estudiante_apellidos, 'estudiante_apellidos-error');
            }
            
            // Validar edad del estudiante
            const estudiante_edad = document.getElementById('estudiante_edad');
            if (!estudiante_edad.value || estudiante_edad.value < 1 || estudiante_edad.value > 100) {
                showError(estudiante_edad, 'estudiante_edad-error', 'Por favor, ingrese una edad válida (entre 1 y 100).');
                hasErrors = true;
            } else {
                hideError(estudiante_edad, 'estudiante_edad-error');
            }
            
            // Validar curso del estudiante
            const estudiante_curso_id = document.getElementById('estudiante_curso_id');
            if (!estudiante_curso_id.value) {
                showError(estudiante_curso_id, 'estudiante_curso_id-error', 'Por favor, seleccione un curso.');
                hasErrors = true;
            } else {
                hideError(estudiante_curso_id, 'estudiante_curso_id-error');
            }
            
            // Validar cédula del estudiante (opcional)
            const estudiante_cedula = document.getElementById('estudiante_cedula');
            if (estudiante_cedula.value.trim() && !/^\d{7,12}$/.test(estudiante_cedula.value.trim())) {
                showError(estudiante_cedula, 'estudiante_cedula-error', 'Por favor, ingrese un número de cédula válido (7-12 dígitos).');
                hasErrors = true;
            } else {
                hideError(estudiante_cedula, 'estudiante_cedula-error');
            }
            
            // Si hay errores, detener el envío del formulario
            if (hasErrors) {
                e.preventDefault();
            }
        });
        
        // Funciones para confirmar eliminación de estudiante
function confirmarEliminarEstudiante(id) {
    estudianteIdEliminar = id;
    document.getElementById('confirmDeleteEstudiante').style.display = 'flex';
    
    // Importante: evitar que el evento se propague y cause otros problemas
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
}

function cancelarEliminarEstudiante() {
    document.getElementById('confirmDeleteEstudiante').style.display = 'none';
    estudianteIdEliminar = null;
}

// Configurar el botón de confirmación de eliminación
document.getElementById('btnConfirmarEliminarEstudiante').addEventListener('click', function() {
    if (estudianteIdEliminar) {
        // Mostrar mensaje de carga directamente en el contenedor de estudiante
        const estudianteElement = document.getElementById('estudiante-' + estudianteIdEliminar);
        
        if (estudianteElement) {
            // Agregar indicador de carga directamente en el estudiante que se está eliminando
            estudianteElement.style.position = 'relative';
            const loader = document.createElement('div');
            loader.className = 'estudiante-loader';
            loader.innerHTML = '<div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); display: flex; align-items: center; justify-content: center; z-index: 10;"><i class="fas fa-spinner fa-spin" style="font-size: 24px; color: var(--primary-color);"></i> <span style="margin-left: 10px; font-weight: bold;">Eliminando...</span></div>';
            estudianteElement.appendChild(loader);
        }
        
        // Enviar solicitud para eliminar estudiante
        fetch('index.php?controller=usuario&action=eliminarEstudiante', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${estudianteIdEliminar}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remover el estudiante de la interfaz sin recargar
                if (estudianteElement) {
                    estudianteElement.style.transition = 'all 0.5s ease';
                    estudianteElement.style.opacity = '0';
                    estudianteElement.style.maxHeight = '0';
                    estudianteElement.style.overflow = 'hidden';
                    estudianteElement.style.marginBottom = '0';
                    estudianteElement.style.padding = '0';
                    estudianteElement.style.border = 'none';
                    
                    setTimeout(() => {
                        if (estudianteElement.parentNode) {
                            estudianteElement.parentNode.removeChild(estudianteElement);
                            
                            // Mostrar mensaje de éxito en la parte superior de la página
                            const alertContainer = document.createElement('div');
                            alertContainer.className = 'alert alert-success';
                            alertContainer.innerHTML = '<i class="fas fa-check-circle"></i> Estudiante eliminado correctamente';
                            
                            // Insertar al principio de main-content
                            const mainContent = document.querySelector('.main-content');
                            const firstChild = mainContent.firstChild;
                            mainContent.insertBefore(alertContainer, firstChild);
                            
                            // Remover el mensaje después de unos segundos
                            setTimeout(() => {
                                if (alertContainer.parentNode) {
                                    alertContainer.parentNode.removeChild(alertContainer);
                                }
                            }, 5000);
                        }
                    }, 500);
                }
            } else {
                // Remover el indicador de carga si existe
                if (estudianteElement) {
                    const loader = estudianteElement.querySelector('.estudiante-loader');
                    if (loader) {
                        loader.parentNode.removeChild(loader);
                    }
                }
                
                // Mostrar mensaje de error en un alert
                alert('Error al eliminar el estudiante: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Remover el indicador de carga si existe
            if (estudianteElement) {
                const loader = estudianteElement.querySelector('.estudiante-loader');
                if (loader) {
                    loader.parentNode.removeChild(loader);
                }
            }
            
            // Mostrar mensaje de error en un alert
            alert('Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo.');
        })
        .finally(() => {
            // Cerrar el diálogo en cualquier caso
            cancelarEliminarEstudiante();
        });
    } else {
        cancelarEliminarEstudiante();
    }
});
        
        // Validar formularios de estudiantes al enviar
        document.querySelectorAll('.estudiante-edit-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                let hasErrors = false;
                const formElements = this.elements;
                
                // Validar campos obligatorios
                for (let i = 0; i < formElements.length; i++) {
                    const element = formElements[i];
                    if (element.required && !element.value.trim()) {
                        element.classList.add('error');
                        hasErrors = true;
                    } else {
                        element.classList.remove('error');
                    }
                }
                
                if (hasErrors) {
                    e.preventDefault();
                    alert('Por favor, complete todos los campos obligatorios correctamente.');
                }
            });
        });
        
        // Validar formularios de referencias al enviar
        document.querySelectorAll('.referencia-edit-form, .referencia-create-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                let hasErrors = false;
                const formElements = this.elements;
                
                // Validar campos obligatorios
                for (let i = 0; i < formElements.length; i++) {
                    const element = formElements[i];
                    if (element.required && !element.value.trim()) {
                        element.classList.add('error');
                        hasErrors = true;
                    } else {
                        element.classList.remove('error');
                    }
                }
                
                if (hasErrors) {
                    e.preventDefault();
                    alert('Por favor, complete todos los campos obligatorios correctamente.');
                }
            });
        });
        
        // Función para volver al listado de titulares
        function volverAListadoTitulares() {
            window.location.href = 'index.php?controller=usuario&action=listarTitulares';
        }
    </script>
</body>
</html>