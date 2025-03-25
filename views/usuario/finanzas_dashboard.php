<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Finanzas - Usuario</title>
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
        
        /* Stats */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: var(--card-color);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 42px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stat-card:nth-child(1) .stat-number {
            color: var(--primary-color);
        }
        
        .stat-card:nth-child(2) .stat-number {
            color: var(--accent-color);
        }
        
        .stat-card:nth-child(3) .stat-number {
            color: var(--success-color);
        }
        
        /* User List */
        .section {
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">WeSystem</div>
        <div class="admin-info">
            <div class="admin-avatar"><?php echo substr($usuario['nombres'], 0, 1); ?></div>
            <div class="admin-details">
                <div class="admin-name"><?php echo $usuario['nombres'] . ' ' . $usuario['apellidos']; ?></div>
                <div class="admin-role">Usuario</div>
            </div>
        </div>
        <ul class="menu">
            <li class="menu-item" onclick="location.href='index.php?controller=usuario&action=dashboard'">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=usuario&action=listarTitulares'">
                <i class="fas fa-user-tie"></i>
                <span>Titulares</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=usuario&action=listarEstudiantes'">
                <i class="fas fa-user-graduate"></i>
                <span>Estudiantes</span>
            </li>
            <li class="menu-item active" onclick="location.href='index.php?controller=finanzas&action=dashboard'">
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
            <h1 class="page-title">Dashboard de Finanzas</h1>
            <div class="user-badge"><?php echo substr($usuario['nombres'], 0, 1) . substr($usuario['apellidos'], 0, 1); ?></div>
        </div>

        <!-- Stats -->
        <div class="stats-container">
            <div class="stat-card">
                <h3>Contratos Emitidos</h3>
                <div class="stat-number"><?php echo count($contratos); ?></div>
            </div>
            <div class="stat-card">
                <h3>Consecutivo Mensual</h3>
                <div class="stat-number"><?php echo $consecutivo_mensual; ?></div>
            </div>
            <div class="stat-card">
                <h3>Consecutivo General</h3>
                <div class="stat-number"><?php echo $consecutivo_general; ?></div>
            </div>
        </div>

        <!-- Recent Contracts -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Contratos Recientes</h2>
                <a href="index.php?controller=finanzas&action=crearContrato" class="btn btn-primary">Nuevo Contrato</a>
            </div>
            
            <input type="text" class="search-box" id="searchContracts" placeholder="Buscar contrato...">
            
            <table>
                <thead>
                    <tr>
                        <th>N° Contrato</th>
                        <th>Fecha</th>
                        <th>Titular</th>
                        <th>Estudiante</th>
                        <th>Monto</th>
                        <th>Forma de Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($contratos)): ?>
                        <?php foreach(array_slice($contratos, 0, 5) as $contrato): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contrato['numero_contrato']); ?></td>
                            <td><?php echo htmlspecialchars($contrato['fecha_emision']); ?></td>
                            <td><?php echo htmlspecialchars($contrato['titular_nombres'] . ' ' . $contrato['titular_apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($contrato['estudiante_nombres'] . ' ' . $contrato['estudiante_apellidos']); ?></td>
                            <td>$<?php echo number_format($contrato['cantidad_recibida'], 2); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($contrato['forma_pago'])); ?></td>
                            <td class="actions">
                                <div class="btn-icon btn-view" title="Ver detalles" onclick="location.href='index.php?controller=finanzas&action=verContrato&id=<?php echo $contrato['id']; ?>'">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="btn-icon btn-edit" title="Editar" onclick="location.href='index.php?controller=finanzas&action=editarContrato&id=<?php echo $contrato['id']; ?>'">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="btn-icon btn-delete" title="Eliminar" onclick="confirmarEliminar(<?php echo $contrato['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No hay contratos registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <?php if (!empty($contratos) && count($contratos) > 5): ?>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="index.php?controller=finanzas&action=listarContratos" style="color: var(--primary-color); text-decoration: none;">Ver todos los contratos</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Búsqueda en la tabla
        document.getElementById('searchContracts').addEventListener('keyup', function() {
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
        
        // Función para confirmar eliminación
        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este contrato? Esta acción no se puede deshacer.')) {
                // Enviar solicitud para eliminar contrato
                fetch('index.php?controller=finanzas&action=eliminarContrato', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
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
        }
    </script>
</body>
</html>