<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Administrador</title>
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
        
        /* Users Section */
        .users-section {
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
            display: inline-block;
            text-decoration: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .search-filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .search-box {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            flex-grow: 1;
        }
        
        .filter-dropdown {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
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
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            margin-top: 20px;
        }
        
        .pagination-item {
            margin: 0 5px;
        }
        
        .pagination-link {
            display: flex;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--card-color);
            color: var(--text-color);
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .pagination-link:hover, .pagination-link.active {
            background-color: var(--primary-color);
            color: white;
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
            <h1 class="page-title">Gestión de Usuarios</h1>
            <div class="user-badge">SA</div>
        </div>

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>La operación se ha completado con éxito.</span>
        </div>
        <?php endif; ?>

        <!-- Users Section -->
        <div class="users-section">
            <div class="section-header">
                <h2 class="section-title">Listado de Usuarios</h2>
                <a href="index.php?controller=superadmin&action=crear_usuario" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Crear Usuario
                </a>
            </div>
            
            <div class="search-filters">
                <input type="text" class="search-box" id="searchUsers" placeholder="Buscar por nombre, cédula, correo...">
                <select class="filter-dropdown" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
                <select class="filter-dropdown" id="filterRol">
                    <option value="">Todos los roles</option>
                    <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['id']; ?>"><?php echo htmlspecialchars($rol['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['cedula']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombres']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                            <td>
                                <span class="badge <?php echo $usuario['estado'] == 'activo' ? 'badge-active' : 'badge-inactive'; ?>">
                                    <?php echo ucfirst($usuario['estado']); ?>
                                </span>
                            </td>
                            <td class="actions">
                                <div class="btn-icon btn-view" title="Ver detalles" onclick="location.href='index.php?controller=superadmin&action=ver_usuario&id=<?php echo $usuario['id']; ?>'">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="btn-icon btn-edit" title="Editar" onclick="location.href='index.php?controller=superadmin&action=editar_usuario&id=<?php echo $usuario['id']; ?>'">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <?php if ($usuario['estado'] == 'activo'): ?>
                                <div class="btn-icon btn-delete" title="Desactivar" onclick="mostrarModalCambiarEstado(<?php echo $usuario['id']; ?>, 'inactivo')">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <?php else: ?>
                                <div class="btn-icon btn-view" title="Activar" onclick="mostrarModalCambiarEstado(<?php echo $usuario['id']; ?>, 'activo')">
                                    <i class="fas fa-check"></i>
                                </div>
                                <?php endif; ?>
                                <div class="btn-icon btn-delete" title="Eliminar" onclick="mostrarModalEliminar(<?php echo $usuario['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No hay usuarios registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <!-- Pagination example, you can implement actual pagination in PHP -->
            <ul class="pagination">
                <li class="pagination-item">
                    <a href="#" class="pagination-link"><i class="fas fa-chevron-left"></i></a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="pagination-link active">1</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="pagination-link">2</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="pagination-link">3</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="pagination-link"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div id="modalEliminar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal('modalEliminar')">&times;</span>
            <h2 class="modal-title">Confirmar eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.</p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" onclick="cerrarModal('modalEliminar')">Cancelar</button>
                <button class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>
    
    <!-- Modal para cambiar estado -->
    <div id="modalCambiarEstado" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal('modalCambiarEstado')">&times;</span>
            <h2 class="modal-title">Confirmar cambio de estado</h2>
            <p id="mensajeCambioEstado"></p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" onclick="cerrarModal('modalCambiarEstado')">Cancelar</button>
                <button class="btn btn-primary" id="btnConfirmarCambioEstado">Confirmar</button>
            </div>
        </div>
    </div>

    <script>
        // Búsqueda y filtrado en la tabla
        document.getElementById('searchUsers').addEventListener('keyup', filtrarTabla);
        document.getElementById('filterEstado').addEventListener('change', filtrarTabla);
        document.getElementById('filterRol').addEventListener('change', filtrarTabla);
        
        function filtrarTabla() {
            const searchTerm = document.getElementById('searchUsers').value.toLowerCase();
            const estadoFiltro = document.getElementById('filterEstado').value.toLowerCase();
            const rolFiltro = document.getElementById('filterRol').value;
            
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const cedula = row.cells[0].textContent.toLowerCase();
                const nombres = row.cells[1].textContent.toLowerCase();
                const apellidos = row.cells[2].textContent.toLowerCase();
                const correo = row.cells[3].textContent.toLowerCase();
                const rol = row.cells[4].textContent.toLowerCase();
                const estado = row.cells[5].textContent.toLowerCase();
                
                // Filtrar por término de búsqueda
                const matchesSearch = cedula.includes(searchTerm) || 
                                    nombres.includes(searchTerm) || 
                                    apellidos.includes(searchTerm) || 
                                    correo.includes(searchTerm);
                
                // Filtrar por estado
                const matchesEstado = estadoFiltro === '' || estado.includes(estadoFiltro);
                
                // Filtrar por rol (necesitaría un atributo data-rol-id en la fila para esto)
                const matchesRol = rolFiltro === '' || rol.includes(rolFiltro);
                
                if (matchesSearch && matchesEstado && matchesRol) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Modal para eliminar usuario
        let usuarioIdEliminar = null;
        const modalEliminar = document.getElementById('modalEliminar');
        
        function mostrarModalEliminar(id) {
            usuarioIdEliminar = id;
            modalEliminar.style.display = 'block';
        }
        
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
        
        function cerrarModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Cierra el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target == modalEliminar) {
                cerrarModal('modalEliminar');
            }
            if (event.target == modalCambiarEstado) {
                cerrarModal('modalCambiarEstado');
            }
        }
        
        // Configurar el botón de confirmación de eliminación
        document.getElementById('btnConfirmarEliminar').addEventListener('click', function() {
            if (usuarioIdEliminar) {
                // Enviar solicitud para eliminar usuario
                fetch('index.php?controller=superadmin&action=eliminar_usuario', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${usuarioIdEliminar}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Recargar la página para reflejar los cambios
                        window.location.href = 'index.php?controller=superadmin&action=listarUsuarios&success=1';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al procesar la solicitud');
                });
            }
            cerrarModal('modalEliminar');
        });
        
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
                        window.location.href = 'index.php?controller=superadmin&action=listarUsuarios&success=1';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al procesar la solicitud');
                });
            }
            cerrarModal('modalCambiarEstado');
        });
    </script>
</body>
</html>