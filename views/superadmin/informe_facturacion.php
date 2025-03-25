<!-- views/superadmin/finanzas/informe_facturacion.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Facturación - SuperAdmin</title>
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
        
        /* Filter Section */
        .filter-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            flex: 1;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
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
        
        .btn-secondary {
            background-color: var(--background-color);
            color: var(--text-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        /* Table Section */
        .table-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
            overflow-x: auto;
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
        
        .btn-export {
            background-color: var(--success-color);
            color: white;
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
            white-space: nowrap;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
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
            font-size: 32px;
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">WeSystem</div>
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
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=listarCursos'">
                <i class="fas fa-book"></i>
                <span>Gestión de Cursos</span>
            </li>
            <li class="menu-item" onclick="location.href='index.php?controller=superadmin&action=gestionarRoles'">
                <i class="fas fa-user-tag"></i>
                <span>Roles</span>
            </li>
            <li class="menu-item active" onclick="location.href='index.php?controller=finanzas&action=informeFacturacion'">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Facturación</span>
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
            <h1 class="page-title">Informe de Facturación</h1>
            <div class="user-badge">SA</div>
        </div>

        <!-- Stats -->
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total de Facturas</h3>
                <div class="stat-number"><?php echo count($facturas); ?></div>
            </div>
            <div class="stat-card">
                <h3>Monto Total</h3>
                <div class="stat-number">$<?php echo number_format(array_sum(array_column($facturas, 'cantidad_recibida')), 2); ?></div>
            </div>
            <div class="stat-card">
                <h3>Usuarios Facturando</h3>
                <div class="stat-number"><?php echo count(array_unique(array_column($facturas, 'verificado_por'))); ?></div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="filter-section">
            <h2 class="section-title" style="margin-bottom: 15px;">Filtros</h2>
            
            <form action="index.php" method="GET">
                <input type="hidden" name="controller" value="finanzas">
                <input type="hidden" name="action" value="informeFacturacion">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha_inicio ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="fecha_fin">Fecha Fin</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="usuario_id">Usuario</label>
                        <select id="usuario_id" name="usuario_id">
                            <option value="">Todos los usuarios</option>
                            <?php foreach ($usuarios as $user): ?>
                                <option value="<?php echo $user['id']; ?>" <?php echo ($usuario_id == $user['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($user['nombres'] . ' ' . $user['apellidos']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div style="text-align: right;">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                    <a href="index.php?controller=finanzas&action=informeFacturacion" class="btn btn-secondary">Limpiar Filtros</a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-section">
            <div class="section-header">
                <h2 class="section-title">Registros de Facturación</h2>
                <button class="btn btn-export" onclick="exportarCSV()">
                    <i class="fas fa-file-export"></i> Exportar a CSV
                </button>
            </div>
            
            <input type="text" class="search-box" id="searchTable" placeholder="Buscar en la tabla...">
            
            <table id="facturacionTable">
                <thead>
                    <tr>
                        <th>N° Contrato</th>
                        <th>Cons. General</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Cédula Usuario</th>
                        <th>Titular</th>
                        <th>Cédula Titular</th>
                        <th>Estudiante</th>
                        <th>Cédula Estudiante</th>
                        <th>Mes Pagado</th>
                        <th>Monto</th>
                        <th>Forma de Pago</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($facturas)): ?>
                        <?php foreach($facturas as $factura): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($factura['numero_contrato']); ?></td>
                            <td><?php echo htmlspecialchars($factura['consecutivo_general'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($factura['fecha_emision']); ?></td>
                            <td><?php echo htmlspecialchars($factura['usuario_nombres'] . ' ' . $factura['usuario_apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($factura['usuario_cedula']); ?></td>
                            <td><?php echo htmlspecialchars($factura['titular_nombres'] . ' ' . $factura['titular_apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($factura['titular_cedula']); ?></td>
                            <td><?php echo htmlspecialchars($factura['estudiante_nombres'] . ' ' . $factura['estudiante_apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($factura['estudiante_cedula']); ?></td>
                            <td><?php echo htmlspecialchars($factura['mes_pagado']); ?></td>
                            <td>$<?php echo number_format($factura['cantidad_recibida'], 2); ?></td>
                            <td><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($factura['forma_pago']))); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" style="text-align: center;">No hay registros de facturación que coincidan con los filtros</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Búsqueda en tabla
        document.getElementById('searchTable').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#facturacionTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Exportar a CSV
        function exportarCSV() {
            const table = document.getElementById('facturacionTable');
            let csv = [];
            const rows = table.querySelectorAll('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = [], cols = rows[i].querySelectorAll('td, th');
                
                for (let j = 0; j < cols.length; j++) {
                    // Reemplazar comas y comillas para evitar problemas en CSV
                    let text = cols[j].innerText.replace(/"/g, '""');
                    row.push('"' + text + '"');
                }
                
                csv.push(row.join(','));
            }
            
            // Descargar el archivo CSV
            const csvString = csv.join('\n');
            const filename = 'informe_facturacion_' + new Date().toISOString().slice(0, 10) + '.csv';
            const link = document.createElement('a');
            link.style.display = 'none';
            link.setAttribute('target', '_blank');
            link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvString));
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>