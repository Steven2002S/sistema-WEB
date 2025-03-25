<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Usuario - Administrador</title>
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
        
        /* Details Section */
        .details-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: var(--text-color);
        }
        
        .user-profile {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            background-color: var(--background-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: var(--primary-color);
        }
        
        .profile-info {
            flex-grow: 1;
        }
        
        .profile-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .profile-email {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .profile-meta {
            display: flex;
            gap: 20px;
        }
        
        .meta-item {
            background-color: var(--background-color);
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        
        .meta-item i {
            margin-right: 8px;
            color: var(--primary-color);
        }
        
        .detail-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 25px;
        }
        
        .detail-tab {
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 500;
            border-bottom: 3px solid transparent;
        }
        
        .detail-tab.active {
            border-bottom-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .detail-group {
            margin-bottom: 20px;
        }
        
        .detail-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-size: 16px;
            font-weight: 500;
        }
        
        .detail-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .badge-active {
            background-color: rgba(76, 175, 80, 0.2);
            color: var(--success-color);
        }
        
        .badge-inactive {
            background-color: rgba(244, 67, 54, 0.2);
            color: var(--danger-color);
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
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
        
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
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
            <li class="menu-item active" onclick="location.href='index.php?controller=superadmin&action=listarUsuarios'">
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
            <h1 class="page-title">Detalles de Usuario</h1>
            <div class="user-badge">SA</div>
        </div>

        <!-- Details Section -->
        <div class="details-section">
            <div class="user-profile">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <h2 class="profile-name"><?php echo htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']); ?></h2>
                    <div class="profile-email"><?php echo htmlspecialchars($usuario['correo']); ?></div>
                    <div class="profile-meta">
                        <div class="meta-item">
                            <i class="fas fa-id-card"></i>
                            <span><?php echo htmlspecialchars($usuario['cedula']); ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-user-tag"></i>
                            <span><?php echo htmlspecialchars($usuario['rol_nombre']); ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-circle"></i>
                            <span class="<?php echo $usuario['estado'] == 'activo' ? 'text-success' : 'text-danger'; ?>">
                                <?php echo ucfirst($usuario['estado']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-tabs">
                <div class="detail-tab active" data-tab="informacion">Información Personal</div>
                <div class="detail-tab" data-tab="acceso">Acceso</div>
            </div>

            <!-- Tab: Información Personal -->
            <div class="tab-content active" id="tab-informacion">
                <div class="detail-grid">
                    <div class="detail-group">
                        <div class="detail-label">Nombres</div>
                        <div class="detail-value"><?php echo htmlspecialchars($usuario['nombres']); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Apellidos</div>
                        <div class="detail-value"><?php echo htmlspecialchars($usuario['apellidos']); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Cédula</div>
                        <div class="detail-value"><?php echo htmlspecialchars($usuario['cedula']); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Fecha de Nacimiento</div>
                        <div class="detail-value"><?php echo date('d/m/Y', strtotime($usuario['fecha_nacimiento'])); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Género</div>
                        <div class="detail-value"><?php echo ucfirst($usuario['genero']); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Ciudad</div>
                        <div class="detail-value"><?php echo htmlspecialchars($usuario['ciudad']); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">País</div>
                        <div class="detail-value"><?php echo htmlspecialchars($usuario['pais']); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Organización</div>
                        <div class="detail-value"><?php echo htmlspecialchars($usuario['organizacion']); ?></div>
                    </div>
                </div>
            </div>

            <!-- Tab: Acceso -->
            <div class="tab-content" id="tab-acceso">
                <div class="detail-grid">
                    <div class="detail-group">
                        <div class="detail-label">Correo Electrónico</div>
                        <div class="detail-value"><?php echo htmlspecialchars($usuario['correo']); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Rol</div>
                        <div class="detail-value"><?php echo htmlspecialchars($usuario['rol_nombre']); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Estado</div>
                        <div class="detail-value">
                            <span class="detail-badge <?php echo $usuario['estado'] == 'activo' ? 'badge-active' : 'badge-inactive'; ?>">
                                <?php echo ucfirst($usuario['estado']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Fecha de Creación</div>
                        <div class="detail-value"><?php echo date('d/m/Y H:i', strtotime($usuario['created_at'])); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Creado por</div>
                        <div class="detail-value"><?php echo htmlspecialchars($creador['nombre'] ?? 'SuperAdmin'); ?></div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="index.php?controller=superadmin&action=editar_usuario&id=<?php echo $usuario['id']; ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Usuario
                </a>
                <a href="index.php?controller=superadmin&action=listarUsuarios" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a la Lista
                </a>
                <?php if ($usuario['estado'] == 'activo'): ?>
                <button class="btn btn-danger" onclick="mostrarModalCambiarEstado(<?php echo $usuario['id']; ?>, 'inactivo')">
                    <i class="fas fa-ban"></i> Desactivar Usuario
                </button>
                <?php else: ?>
                <button class="btn btn-primary" onclick="mostrarModalCambiarEstado(<?php echo $usuario['id']; ?>, 'activo')">
                    <i class="fas fa-check"></i> Activar Usuario
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal para cambiar estado -->
    <div id="modalCambiarEstado" class="modal" style="display: none; position: fixed; z-index: 100; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-content" style="background-color: white; margin: 10% auto; padding: 20px; border-radius: 8px; width: 60%; max-width: 500px; position: relative;">
            <span class="close" onclick="cerrarModal()" style="position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer;">&times;</span>
            <h2 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">Confirmar cambio de estado</h2>
            <p id="mensajeCambioEstado"></p>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                <button class="btn btn-primary" id="btnConfirmarCambioEstado">Confirmar</button>
            </div>
        </div>
    </div>

    <script>
        // Tabs de detalles
        const tabs = document.querySelectorAll('.detail-tab');
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
        
        // Modal para cambiar estado
        let usuarioIdCambioEstado = null;
        let nuevoEstado = null;
        const modalCambiarEstado = document.getElementById('modalCambiarEstado');
        const mensajeCambioEstado = document.getElementById('mensajeCambioEstado');
        
        function mostrarModalCambiarEstado(id, estado) {
            usuarioIdCambioEstado = id;
            nuevoEstado = estado;
            
            mensajeCambioEstado.textContent = `¿Estás seguro de que deseas ${estado === 'activo' ? 'activar' : 'desactivar'} este usuario?`;
            
            modalCambiarEstado.style.display = 'block';
        }
        
        function cerrarModal() {
            modalCambiarEstado.style.display = 'none';
        }
        
        // Cierra el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target == modalCambiarEstado) {
                cerrarModal();
            }
        }
        
        // Configurar el botón de confirmación de cambio de estado
        document.getElementById('btnConfirmarCambioEstado').addEventListener('click', function() {
            if (usuarioIdCambioEstado && nuevoEstado) {
                // Enviar solicitud para cambiar estado
                fetch('index.php?controller=superadmin&action=cambiar_estado_usuario', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${usuarioIdCambioEstado}&estado=${nuevoEstado}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Recargar la página para reflejar los cambios
                        window.location.href = 'index.php?controller=superadmin&action=ver_usuario&id=' + usuarioIdCambioEstado + '&success=1';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al procesar la solicitud');
                });
            }
            cerrarModal();
        });
    </script>
</body>
</html>