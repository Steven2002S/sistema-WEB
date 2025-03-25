<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Titulares - Usuario</title>
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
        .titulares-section {
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
            text-decoration: none;
            display: inline-block;
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
            font-size: 14px;
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
            font-weight: 600;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
        }
        
        tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
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
            margin-top: 20px;
            gap: 5px;
        }
        
        .pagination-item {
            width: 36px;
            height: 36px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            background-color: var(--background-color);
        }
        
        .pagination-item.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .pagination-item:hover:not(.active) {
            background-color: var(--border-color);
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
        
        .alert i {
            margin-right: 10px;
            font-size: 18px;
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
            <h1 class="page-title">Gestión de Titulares</h1>
            <div class="user-badge">
                <?php echo htmlspecialchars($iniciales); ?>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>Operación realizada con éxito.</span>
        </div>
        <?php endif; ?>

        <!-- Titulares Section -->
        <div class="titulares-section">
            <div class="section-header">
                <h2 class="section-title">Listado de Titulares</h2>
                <a href="index.php?controller=usuario&action=crearTitular" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Titular
                </a>
            </div>
            
            <input type="text" class="search-box" id="searchTitulares" placeholder="Buscar titular por cédula, nombre, apellido o correo...">
            
            <table>
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($titulares)): ?>
                        <?php foreach($titulares as $titular): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($titular['cedula']); ?></td>
                            <td><?php echo htmlspecialchars($titular['nombres']); ?></td>
                            <td><?php echo htmlspecialchars($titular['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($titular['email']); ?></td>
                            <td><?php echo htmlspecialchars($titular['celular']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($titular['fecha_registro'])); ?></td>
                            <td class="actions">
                                <a href="index.php?controller=usuario&action=verTitular&id=<?php echo $titular['id']; ?>" class="btn-icon btn-view" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?controller=usuario&action=editarTitular&id=<?php echo $titular['id']; ?>" class="btn-icon btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div class="btn-icon btn-delete" title="Eliminar" onclick="mostrarModalEliminar(<?php echo $titular['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No hay titulares registrados</td>
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
        <p>¿Estás seguro de que deseas eliminar este titular? Esta acción también eliminará:</p>
        <ul>
            <li>Todos los estudiantes asociados al titular</li>
            <li>Todas las referencias personales del titular</li>
        </ul>
        <p><strong>Advertencia:</strong> Esta acción no se puede deshacer y se perderá toda la información relacionada.</p>
        <div class="modal-buttons">
            <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            <button class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
        </div>
    </div>
</div>

    <script>
        // Búsqueda en la tabla
        document.getElementById('searchTitulares').addEventListener('keyup', function() {
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
        
        // Modal para eliminar titular
        let titularIdEliminar = null;
        const modal = document.getElementById('modalEliminar');
        
        function mostrarModalEliminar(id) {
            titularIdEliminar = id;
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
            if (titularIdEliminar) {
                // Enviar solicitud para eliminar titular
                fetch('index.php?controller=usuario&action=eliminarTitular', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${titularIdEliminar}`
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