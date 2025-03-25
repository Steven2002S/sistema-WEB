<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Curso - Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Usar los mismos estilos que en dashboard.php */
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
        
        /* Details Section */
        .details-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
        }
        
        .badge {
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
        
        .detail-item {
            margin-bottom: 15px;
        }
        
        .detail-label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #666;
        }
        
        .detail-value {
            font-size: 16px;
            padding-left: 10px;
        }
        
        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
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
        
        .btn-warning {
            background-color: var(--accent-color);
            color: var(--text-color);
        }
        
        .btn-warning:hover {
            background-color: #e6c200;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #d32f2f;
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            background-color: var(--card-color);
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 60%;
            max-width: 500px;
            position: relative;
        }
        
        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
        }
        
        .modal-title {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }
        
        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
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
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=verPerfil'">
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
            <h1 class="page-title">Detalles del Curso</h1>
            <div class="user-badge">SA</div>
        </div>

        <!-- Details Section -->
        <div class="details-section">
            <div class="section-header">
                <h2 class="section-title"><?php echo htmlspecialchars($curso['nombre']); ?></h2>
                <span class="badge <?php echo $curso['estado'] == 'activo' ? 'badge-active' : 'badge-inactive'; ?>">
                    <?php echo ucfirst($curso['estado']); ?>
                </span>
            </div>
            <div class="detail-item">
                <div class="detail-label">Nombre:</div>
                <div class="detail-value"><?php echo htmlspecialchars($curso['nombre']); ?></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Descripción:</div>
                <div class="detail-value">
                    <?php if (empty($curso['descripcion'])): ?>
                        <em>Sin descripción</em>
                    <?php else: ?>
                        <?php echo nl2br(htmlspecialchars($curso['descripcion'])); ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Estado:</div>
                <div class="detail-value">
                    <span class="badge <?php echo $curso['estado'] == 'activo' ? 'badge-active' : 'badge-inactive'; ?>">
                        <?php echo ucfirst($curso['estado']); ?>
                    </span>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Creado por:</div>
                <div class="detail-value"><?php echo htmlspecialchars($curso['creado_por']); ?></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Fecha de Creación:</div>
                <div class="detail-value"><?php echo date('d/m/Y H:i', strtotime($curso['created_at'])); ?></div>
            </div>

            <div class="buttons">
                <button class="btn btn-secondary" onclick="location.href='index.php?controller=superadmin&action=listarCursos'">
                    <i class="fas fa-arrow-left"></i> Volver
                </button>
                <button class="btn btn-warning" onclick="location.href='index.php?controller=superadmin&action=editarCurso&id=<?php echo $curso['id']; ?>'">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button class="btn btn-danger" onclick="mostrarModalEliminar(<?php echo $curso['id']; ?>)">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div id="modalEliminar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2 class="modal-title">Confirmar eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar este curso? Esta acción no se puede deshacer.</p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                <button class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>

    <script>
        // Modal para eliminar curso
        let cursoIdEliminar = null;
        const modal = document.getElementById('modalEliminar');
        
        function mostrarModalEliminar(id) {
            cursoIdEliminar = id;
            modal.style.display = 'block';
        }
        
        function cerrarModal() {
            modal.style.display = 'none';
        }
        
        // Cierra el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target == modal) {
                cerrarModal();
            }
        }
        
        // Configurar el botón de confirmación de eliminación
        document.getElementById('btnConfirmarEliminar').addEventListener('click', function() {
            if (cursoIdEliminar) {
                // Enviar solicitud para eliminar curso
                fetch('index.php?controller=superadmin&action=eliminarCurso', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${cursoIdEliminar}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirigir a la lista de cursos
                        window.location.href = 'index.php?controller=superadmin&action=listarCursos';
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