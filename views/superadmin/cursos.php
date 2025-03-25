<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cursos - Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Usa los mismos estilos que compartiste en dashboard.php */
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
        
        /* Cursos Section */
        .cursos-section {
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
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
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
        
        .search-box {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            width: 100%;
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            text-align: left;
            padding: 12px;
            background-color: var(--background-color);
            color: var(--text-color);
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
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
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-view {
            background-color: rgba(0, 119, 194, 0.1);
            color: var(--primary-color);
        }
        
        .btn-edit {
            background-color: rgba(255, 214, 0, 0.1);
            color: var(--accent-color);
        }
        
        .btn-delete {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
        }
        
        .btn-view:hover {
            background-color: rgba(0, 119, 194, 0.2);
        }
        
        .btn-edit:hover {
            background-color: rgba(255, 214, 0, 0.2);
        }
        
        .btn-delete:hover {
            background-color: rgba(244, 67, 54, 0.2);
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
            <h1 class="page-title">Gestión de Cursos</h1>
            <div class="user-badge">SA</div>
        </div>

        <!-- Cursos Section -->
        <div class="cursos-section">
            <div class="section-header">
                <h2 class="section-title">Listado de Cursos</h2>
                <button class="btn btn-primary" onclick="location.href='index.php?controller=superadmin&action=crearCurso'">Nuevo Curso</button>
            </div>
            
            <input type="text" class="search-box" id="searchCursos" placeholder="Buscar curso...">
            
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Creado por</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cursos)): ?>
                        <?php foreach($cursos as $curso): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($curso['nombre']); ?></td>
                            <td><?php echo htmlspecialchars(substr($curso['descripcion'], 0, 50) . (strlen($curso['descripcion']) > 50 ? '...' : '')); ?></td>
                            <td>
                                <span class="badge <?php echo $curso['estado'] == 'activo' ? 'badge-active' : 'badge-inactive'; ?>">
                                    <?php echo ucfirst($curso['estado']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($curso['creado_por']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($curso['created_at'])); ?></td>
                            <td class="actions">
                                <div class="btn-icon btn-view" title="Ver detalles" onclick="location.href='index.php?controller=superadmin&action=verCurso&id=<?php echo $curso['id']; ?>'">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="btn-icon btn-edit" title="Editar" onclick="location.href='index.php?controller=superadmin&action=editarCurso&id=<?php echo $curso['id']; ?>'">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="btn-icon btn-delete" title="Eliminar" onclick="mostrarModalEliminar(<?php echo $curso['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No hay cursos registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
        // Búsqueda en la tabla
        document.getElementById('searchCursos').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
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
                        // Recargar la página para reflejar los cambios
                        window.location.reload();
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