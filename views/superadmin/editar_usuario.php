<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Administrador</title>
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
        .form-select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-input:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        .form-input.error,
        .form-select.error {
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
        
        .form-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 25px;
        }
        
        .form-tab {
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 500;
            border-bottom: 3px solid transparent;
        }
        
        .form-tab.active {
            border-bottom-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
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
        
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
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
        
        /* Status toggle */
        .status-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .toggle-label {
            font-weight: 500;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: var(--success-color);
        }
        
        input:focus + .toggle-slider {
            box-shadow: 0 0 1px var(--success-color);
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        
        .toggle-status {
            font-size: 14px;
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
            <li class="menu-item active">
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
            <h1 class="page-title">Editar Usuario</h1>
            <div class="user-badge">SA</div>
        </div>

        <?php if (isset($mensaje) && !empty($mensaje)): ?>
        <div class="alert <?php echo $error ? 'alert-error' : 'alert-success'; ?>">
            <i class="fas <?php echo $error ? 'fa-exclamation-circle' : 'fa-check-circle'; ?>"></i>
            <span><?php echo htmlspecialchars($mensaje); ?></span>
        </div>
        <?php endif; ?>

        <!-- Form Section -->
        <div class="form-section">
            <div class="form-tabs">
                <div class="form-tab active" data-tab="informacion">Información Personal</div>
                <div class="form-tab" data-tab="seguridad">Seguridad</div>
                <div class="form-tab" data-tab="estado">Estado</div>
            </div>
            
            <form id="editUserForm" action="index.php?controller=superadmin&action=editar_usuario&id=<?php echo $usuario['id']; ?>" method="POST">                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                
                <!-- Tab: Información Personal -->
                <div class="tab-content active" id="tab-informacion">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="cedula">Cédula<span class="form-required">*</span></label>
                            <input type="text" id="cedula" name="cedula" class="form-input" required value="<?php echo htmlspecialchars($usuario['cedula']); ?>">
                            <div class="form-error" id="cedula-error">Por favor, ingrese un número de cédula válido.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="nombres">Nombres<span class="form-required">*</span></label>
                            <input type="text" id="nombres" name="nombres" class="form-input" required value="<?php echo htmlspecialchars($usuario['nombres']); ?>">
                            <div class="form-error" id="nombres-error">Por favor, ingrese los nombres.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="apellidos">Apellidos<span class="form-required">*</span></label>
                            <input type="text" id="apellidos" name="apellidos" class="form-input" required value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                            <div class="form-error" id="apellidos-error">Por favor, ingrese los apellidos.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento<span class="form-required">*</span></label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-input" required value="<?php echo htmlspecialchars($usuario['fecha_nacimiento']); ?>">
                            <div class="form-error" id="fecha_nacimiento-error">Por favor, seleccione una fecha válida.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="correo">Correo Electrónico<span class="form-required">*</span></label>
                            <input type="email" id="correo" name="correo" class="form-input" required value="<?php echo htmlspecialchars($usuario['correo']); ?>">
                            <div class="form-error" id="correo-error">Por favor, ingrese un correo válido.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="ciudad">Ciudad<span class="form-required">*</span></label>
                            <input type="text" id="ciudad" name="ciudad" class="form-input" required value="<?php echo htmlspecialchars($usuario['ciudad']); ?>">
                            <div class="form-error" id="ciudad-error">Por favor, ingrese la ciudad.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="pais">País<span class="form-required">*</span></label>
                            <input type="text" id="pais" name="pais" class="form-input" required value="<?php echo htmlspecialchars($usuario['pais']); ?>">
                            <div class="form-error" id="pais-error">Por favor, ingrese el país.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="genero">Género<span class="form-required">*</span></label>
                            <select id="genero" name="genero" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <option value="masculino" <?php echo $usuario['genero'] == 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                                <option value="femenino" <?php echo $usuario['genero'] == 'femenino' ? 'selected' : ''; ?>>Femenino</option>
                                <option value="otro" <?php echo $usuario['genero'] == 'otro' ? 'selected' : ''; ?>>Otro</option>
                            </select>
                            <div class="form-error" id="genero-error">Por favor, seleccione un género.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="organizacion">Organización<span class="form-required">*</span></label>
                            <input type="text" id="organizacion" name="organizacion" class="form-input" required value="<?php echo htmlspecialchars($usuario['organizacion']); ?>">
                            <div class="form-error" id="organizacion-error">Por favor, ingrese la organización.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="rol_id">Rol<span class="form-required">*</span></label>
                            <select id="rol_id" name="rol_id" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($roles as $rol): ?>
                                <option value="<?php echo $rol['id']; ?>" <?php echo $usuario['rol_id'] == $rol['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($rol['nombre']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-error" id="rol_id-error">Por favor, seleccione un rol.</div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab: Seguridad -->
                <div class="tab-content" id="tab-seguridad">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="password">Nueva Contraseña</label>
                            <input type="password" id="password" name="password" class="form-input">
                            <div class="form-help">Dejar en blanco para mantener la contraseña actual. La nueva contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una minúscula y un número.</div>
                            <div class="form-error" id="password-error">La contraseña debe tener al menos 8 caracteres.</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="confirmar_password">Confirmar Nueva Contraseña</label>
                            <input type="password" id="confirmar_password" name="confirmar_password" class="form-input">
                            <div class="form-error" id="confirmar_password-error">Las contraseñas no coinciden.</div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab: Estado -->
                <div class="tab-content" id="tab-estado">
                    <div class="status-toggle">
                        <span class="toggle-label">Estado del usuario:</span>
                        <label class="toggle-switch">
                            <input type="checkbox" name="estado" value="activo" <?php echo $usuario['estado'] == 'activo' ? 'checked' : ''; ?>>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-status" id="estado-text">
                            <?php echo $usuario['estado'] == 'activo' ? 'Activo' : 'Inactivo'; ?>
                        </span>
                    </div>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="index.php?controller=superadmin&action=listarUsuarios" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tabs de formulario
        const tabs = document.querySelectorAll('.form-tab');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const tabId = tab.getAttribute('data-tab');
                
                // Activar tab
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                // Mostrar contenido del tab
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    if (content.id === `tab-${tabId}`) {
                        content.classList.add('active');
                    }
                });
            });
        });
        
        // Toggle de estado
        const estadoToggle = document.querySelector('input[name="estado"]');
        const estadoText = document.getElementById('estado-text');
        
        estadoToggle.addEventListener('change', function() {
            estadoText.textContent = this.checked ? 'Activo' : 'Inactivo';
        });
        
        // Validación del formulario
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            let hasErrors = false;
            
            // Validar cédula
            const cedula = document.getElementById('cedula');
            if (!cedula.value.trim() || !/^\d{7,12}$/.test(cedula.value.trim())) {
                showError(cedula, 'cedula-error', 'Por favor, ingrese un número de cédula válido (7-12 dígitos).');
                hasErrors = true;
            } else {
                hideError(cedula, 'cedula-error');
            }
            
            // Validar nombres
            const nombres = document.getElementById('nombres');
            if (!nombres.value.trim()) {
                showError(nombres, 'nombres-error', 'Por favor, ingrese los nombres.');
                hasErrors = true;
            } else {
                hideError(nombres, 'nombres-error');
            }
            
            // Validar apellidos
            const apellidos = document.getElementById('apellidos');
            if (!apellidos.value.trim()) {
                showError(apellidos, 'apellidos-error', 'Por favor, ingrese los apellidos.');
                hasErrors = true;
            } else {
                hideError(apellidos, 'apellidos-error');
            }
            
            // Validar fecha de nacimiento
            const fechaNacimiento = document.getElementById('fecha_nacimiento');
            if (!fechaNacimiento.value) {
                showError(fechaNacimiento, 'fecha_nacimiento-error', 'Por favor, seleccione una fecha válida.');
                hasErrors = true;
            } else {
                // Verificar que la fecha no sea en el futuro
                const fechaSeleccionada = new Date(fechaNacimiento.value);
                const hoy = new Date();
                
                if (fechaSeleccionada > hoy) {
                    showError(fechaNacimiento, 'fecha_nacimiento-error', 'La fecha de nacimiento no puede ser en el futuro.');
                    hasErrors = true;
                } else {
                    hideError(fechaNacimiento, 'fecha_nacimiento-error');
                }
            }
            
            // Validar correo
            const correo = document.getElementById('correo');
            if (!correo.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo.value.trim())) {
                showError(correo, 'correo-error', 'Por favor, ingrese un correo electrónico válido.');
                hasErrors = true;
            } else {
                hideError(correo, 'correo-error');
            }
            
            // Validar ciudad
            const ciudad = document.getElementById('ciudad');
            if (!ciudad.value.trim()) {
                showError(ciudad, 'ciudad-error', 'Por favor, ingrese la ciudad.');
                hasErrors = true;
            } else {
                hideError(ciudad, 'ciudad-error');
            }
            
            // Validar país
            const pais = document.getElementById('pais');
            if (!pais.value.trim()) {
                showError(pais, 'pais-error', 'Por favor, ingrese el país.');
                hasErrors = true;
            } else {
                hideError(pais, 'pais-error');
            }
            
            // Validar género
            const genero = document.getElementById('genero');
            if (!genero.value) {
                showError(genero, 'genero-error', 'Por favor, seleccione un género.');
                hasErrors = true;
            } else {
                hideError(genero, 'genero-error');
            }
            
            // Validar organización
            const organizacion = document.getElementById('organizacion');
            if (!organizacion.value.trim()) {
                showError(organizacion, 'organizacion-error', 'Por favor, ingrese la organización.');
                hasErrors = true;
            } else {
                hideError(organizacion, 'organizacion-error');
            }
            
            // Validar rol
            const rolId = document.getElementById('rol_id');
            if (!rolId.value) {
                showError(rolId, 'rol_id-error', 'Por favor, seleccione un rol.');
                hasErrors = true;
            } else {
                hideError(rolId, 'rol_id-error');
            }
            
            // Validar contraseña si se proporciona
            const password = document.getElementById('password');
            const confirmarPassword = document.getElementById('confirmar_password');
            
            if (password.value) {
                if (password.value.length < 8) {
                    showError(password, 'password-error', 'La contraseña debe tener al menos 8 caracteres.');
                    hasErrors = true;
                } else {
                    // Verificar si la contraseña cumple con los requisitos de seguridad
                    const regexPass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
                    
                    if (!regexPass.test(password.value)) {
                        showError(password, 'password-error', 'La contraseña debe incluir al menos una letra mayúscula, una minúscula y un número.');
                        hasErrors = true;
                    } else {
                        hideError(password, 'password-error');
                    }
                }
                
                // Validar confirmación de contraseña
                if (password.value !== confirmarPassword.value) {
                    showError(confirmarPassword, 'confirmar_password-error', 'Las contraseñas no coinciden.');
                    hasErrors = true;
                } else {
                    hideError(confirmarPassword, 'confirmar_password-error');
                }
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
            
            // Cambiar a la pestaña que contiene el error
            const tabContent = input.closest('.tab-content');
            if (tabContent && !tabContent.classList.contains('active')) {
                const tabId = tabContent.id.replace('tab-', '');
                document.querySelector(`.form-tab[data-tab="${tabId}"]`).click();
            }
        }
        
        // Función para ocultar mensajes de error
        function hideError(input, errorId) {
            input.classList.remove('error');
            document.getElementById(errorId).style.display = 'none';
        }
    </script>
</body>
</html>