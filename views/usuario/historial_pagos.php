<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pagos - Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
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
            font-size: 28px;
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .user-badge {
            background-color: var(--accent-color);
            color: var(--text-color);
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
        }
        
        .section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
            transition: transform 0.3s;
        }
        
        .section:hover {
            transform: translateY(-5px);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 10px;
        }
        
        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            color: var(--accent-color);
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-export {
            background-color: var(--success-color);
            color: white;
        }
        
        .btn-export:hover {
            background-color: #3d8b40;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-back {
            background-color: var(--background-color);
            color: var(--text-color);
            margin-bottom: 20px;
        }
        
        .search-box {
            padding: 12px;
            border-radius: 25px;
            border: 1px solid var(--border-color);
            width: 100%;
            margin-bottom: 20px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #f8f8f8;
        }
        
        .search-box:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 119, 194, 0.2);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            text-align: left;
            padding: 15px;
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
            position: sticky;
            top: 0;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background-color: rgba(0, 119, 194, 0.05);
        }
        
        tr:hover {
            background-color: rgba(0, 119, 194, 0.1);
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            margin-right: 8px;
        }
        
        .badge-active {
            background-color: rgba(76, 175, 80, 0.2);
            color: var(--success-color);
        }
        
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
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
        
        .btn-view:hover, .btn-edit:hover, .btn-delete:hover {
            transform: scale(1.2);
        }
        
        .payment-progress {
            height: 10px;
            border-radius: 5px;
            background: linear-gradient(to right, #0077c2, #00c6ff);
            transition: width 0.5s ease-in-out;
            box-shadow: 0 2px 4px rgba(0, 119, 194, 0.2);
        }
        
        .payment-amount {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .payment-method {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .filter-form {
            background-color: #e9f5ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }
        
        .chart-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .chart-box {
            flex: 1;
            min-width: 300px;
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--accent-color);
        }
        
        .chart-box h3 {
            margin-bottom: 15px;
            text-align: center;
            color: var(--primary-color);
            font-size: 18px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #888;
        }
        
        .no-data i {
            font-size: 48px;
            margin-bottom: 10px;
            opacity: 0.5;
        }
        
        /* Animaciones y efectos adicionales */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateX(50px); }
            10% { opacity: 1; transform: translateX(0); }
            90% { opacity: 1; transform: translateX(0); }
            100% { opacity: 0; transform: translateX(50px); }
        }
        
        /* Estilos para tooltips personalizados */
        .tooltip {
            position: relative;
            display: inline-block;
        }
        
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        
        /* Mejoras para la vista móvil */
        @media (max-width: 768px) {
            .chart-container {
                flex-direction: column;
            }
            
            .chart-box {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar (mantener para la navegación) -->
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
        <!-- Encabezado con botón de regreso -->
        <a href="index.php?controller=finanzas&action=dashboard" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Volver a Finanzas
        </a>
        
        <div class="header animate-fadeIn">
            <h1 class="page-title"><i class="fas fa-history" style="color: var(--accent-color);"></i> Historial de Pagos</h1>
            <div class="user-badge"><?php echo substr($usuario['nombres'], 0, 1) . substr($usuario['apellidos'], 0, 1); ?></div>
        </div>

        <!-- Visualizaciones gráficas -->
        <div class="chart-container animate-fadeIn" style="animation-delay: 0.1s;">
            <div class="chart-box">
                <h3><i class="fas fa-chart-line"></i> Tendencia de Pagos Mensuales</h3>
                <canvas id="paymentsChart" height="250"></canvas>
            </div>
            <div class="chart-box">
                <h3><i class="fas fa-chart-pie"></i> Distribución por Método de Pago</h3>
                <canvas id="methodsChart" height="250"></canvas>
            </div>
        </div>

        <!-- Filtros -->
        <div class="section animate-fadeIn" style="animation-delay: 0.2s;">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-filter"></i> Filtrar Historial</h2>
            </div>
            
            <form method="GET" action="index.php" class="filter-form">
                <input type="hidden" name="controller" value="finanzas">
                <input type="hidden" name="action" value="historialPagos">
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label for="titular_id"><i class="fas fa-user-tie"></i> Titular:</label>
                        <select name="titular_id" id="titular_id" class="search-box" onchange="cargarEstudiantes()">
                            <option value="">Todos los titulares</option>
                            <?php foreach ($titulares as $titular): ?>
                                <option value="<?php echo $titular['id']; ?>" <?php echo ($titular_id == $titular['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($titular['nombres'] . ' ' . $titular['apellidos']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label for="estudiante_id"><i class="fas fa-user-graduate"></i> Estudiante:</label>
                        <select name="estudiante_id" id="estudiante_id" class="search-box">
                            <option value="">Todos los estudiantes</option>
                            <?php foreach ($estudiantes as $estudiante): ?>
                                <option value="<?php echo $estudiante['id']; ?>" <?php echo ($estudiante_id == $estudiante['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label for="fecha_inicio"><i class="fas fa-calendar-alt"></i> Desde:</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="search-box" value="<?php echo $fecha_inicio; ?>">
                    </div>
                    
                    <div>
                        <label for="fecha_fin"><i class="fas fa-calendar-alt"></i> Hasta:</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="search-box" value="<?php echo $fecha_fin; ?>">
                    </div>
                </div>
                
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Aplicar Filtros
                    </button>
                    <a href="index.php?controller=finanzas&action=historialPagos" class="btn" style="background-color: #f5f5f5; color: #333;">
                        <i class="fas fa-broom"></i> Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Historial de Pagos -->
        <div class="section animate-fadeIn" style="animation-delay: 0.3s;">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-receipt"></i> Registros de Pagos</h2>
                <div>
                    <a href="javascript:void(0)" onclick="exportarCSV()" class="btn btn-export" style="margin-right: 10px;">
                        <i class="fas fa-file-export"></i> Exportar a CSV
                    </a>
                    <a href="index.php?controller=finanzas&action=crearContrato" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Pago
                    </a>
                </div>
            </div>
            
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 15px; color: #888;"></i>
                <input type="text" class="search-box" id="searchPayments" placeholder="Buscar pago por contrato, titular, estudiante..." style="padding-left: 40px;">
            </div>
            
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="border-radius: 8px 0 0 0;"><i class="fas fa-hashtag"></i> N° Contrato</th>
                            <th><i class="fas fa-calendar"></i> Fecha</th>
                            <th><i class="fas fa-calendar-week"></i> Mes Pagado</th>
                            <th><i class="fas fa-user-tie"></i> Titular</th>
                            <th><i class="fas fa-user-graduate"></i> Estudiante</th>
                            <th><i class="fas fa-money-bill-wave"></i> Monto</th>
                            <th><i class="fas fa-credit-card"></i> Forma de Pago</th>
                            <th style="border-radius: 0 8px 0 0;"><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pagos)): ?>
                            <?php foreach($pagos as $pago): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($pago['numero_contrato']); ?></strong></td>
                                <td>
                                    <?php
                                        $fechaEmision = new DateTime($pago['fecha_emision']);
                                        $hoy = new DateTime();
                                        $diff = $hoy->diff($fechaEmision)->days;
                                        
                                        if ($diff <= 30) {
                                            echo '<span class="badge" style="background-color: rgba(76, 175, 80, 0.2); color: var(--success-color);">Reciente</span>';
                                        } else if ($diff <= 90) {
                                            echo '<span class="badge" style="background-color: rgba(255, 193, 7, 0.2); color: var(--warning-color);">Trimestral</span>';
                                        } else {
                                            echo '<span class="badge" style="background-color: rgba(0, 119, 194, 0.2); color: var(--primary-color);">Anterior</span>';
                                        }
                                    ?>
                                    <?php echo htmlspecialchars($pago['fecha_emision']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($pago['mes_pagado']); ?></td>
                                <td><?php echo htmlspecialchars($pago['titular_nombres'] . ' ' . $pago['titular_apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($pago['estudiante_nombres'] . ' ' . $pago['estudiante_apellidos']); ?></td>
                                <td>
                                    <div class="payment-amount">
                                        <div class="payment-progress" style="width: <?php echo min(($pago['cantidad_recibida'] / 1000) * 100, 100); ?>px;"></div>
                                        <span style="font-weight: bold;">$<?php echo number_format($pago['cantidad_recibida'], 2); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                        $icon = '';
                                        $color = '';
                                        switch($pago['forma_pago']) {
                                            case 'efectivo':
                                                $icon = 'fa-money-bill';
                                                $color = 'var(--success-color)';
                                                break;
                                            case 'cheque':
                                                $icon = 'fa-money-check';
                                                $color = 'var(--warning-color)';
                                                break;
                                            case 'transferencia':
                                                $icon = 'fa-university';
                                                $color = 'var(--primary-color)';
                                                break;
                                            case 'tarjeta_credito':
                                                $icon = 'fa-credit-card';
                                                $color = 'var(--accent-color)';
                                                break;
                                        }
                                    ?>
                                    <div class="payment-method">
                                        <i class="fas <?php echo $icon; ?>" style="color: <?php echo $color; ?>; margin-right: 8px;"></i>
                                        <span><?php echo ucfirst(htmlspecialchars($pago['forma_pago'])); ?></span>
                                    </div>
                                </td>
                                <td class="actions">
                                    <div class="btn-icon btn-view tooltip" title="Ver detalles" onclick="location.href='index.php?controller=finanzas&action=verContrato&id=<?php echo $pago['id']; ?>'">
                                        <i class="fas fa-eye"></i>
                                        <span class="tooltiptext">Ver detalles</span>
                                    </div>
                                    <div class="btn-icon btn-edit tooltip" title="Editar" onclick="location.href='index.php?controller=finanzas&action=editarContrato&id=<?php echo $pago['id']; ?>'">
                                        <i class="fas fa-edit"></i>
                                        <span class="tooltiptext">Editar pago</span>
                                    </div>
                                    <div class="btn-icon btn-delete tooltip" title="Eliminar" onclick="confirmarEliminar(<?php echo $pago['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                        <span class="tooltiptext">Eliminar pago</span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">
                                    <div class="no-data">
                                        <i class="fas fa-search"></i>
                                        <p>No se encontraron pagos con los criterios seleccionados</p>
                                        <p>Intenta con otros filtros o <a href="index.php?controller=finanzas&action=historialPagos">ver todos los pagos</a></p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Búsqueda en la tabla
        document.getElementById('searchPayments').addEventListener('keyup', function() {
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
            if (confirm('¿Estás seguro de que deseas eliminar este pago? Esta acción no se puede deshacer.')) {
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
                        // Mostrar notificación de éxito
                        showNotification('Pago eliminado con éxito', 'success');
                        
                        // Ocultar la fila eliminada con animación
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        if (row) {
                            row.style.transition = 'all 0.5s';
                            row.style.opacity = '0';
                            row.style.height = '0';
                            setTimeout(() => {
                                row.remove();
                            }, 500);
                        } else {
                            // Recargar la página si no se puede encontrar la fila
                            window.location.reload();
                        }
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Ocurrió un error al procesar la solicitud', 'error');
                });
            }
        }
        
        // Función para cargar estudiantes según el titular seleccionado
        function cargarEstudiantes() {
            const titularId = document.getElementById('titular_id').value;
            
            if (!titularId) {
                // Si no hay titular seleccionado, limpiar lista de estudiantes
                const estudianteSelect = document.getElementById('estudiante_id');
                estudianteSelect.innerHTML = '<option value="">Todos los estudiantes</option>';
                return;
            }
            
            // Mostrar un indicador de carga
            const estudianteSelect = document.getElementById('estudiante_id');
            estudianteSelect.innerHTML = '<option value="">Cargando estudiantes...</option>';
            
            // Cargar estudiantes por AJAX
            fetch(`index.php?controller=finanzas&action=getEstudiantesPorTitular&titular_id=${titularId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const estudianteSelect = document.getElementById('estudiante_id');
                        estudianteSelect.innerHTML = '<option value="">Todos los estudiantes</option>';
                        
                        data.data.estudiantes.forEach(estudiante => {
                            const option = document.createElement('option');
                            option.value = estudiante.id;
                            option.textContent = `${estudiante.nombres} ${estudiante.apellidos}`;
                            estudianteSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const estudianteSelect = document.getElementById('estudiante_id');
                    estudianteSelect.innerHTML = '<option value="">Error al cargar estudiantes</option>';
                });
        }

        // Función para exportar a CSV
        function exportarCSV() {
            // Mostrar indicador de proceso
            showNotification('Preparando archivo CSV...', 'info');
            
            // Obtener datos de la tabla
            const table = document.querySelector('table');
            const rows = table.querySelectorAll('tbody tr');
            
            // Crear contenido CSV
            let csv = 'Contrato,Fecha,Mes Pagado,Titular,Estudiante,Monto,Forma de Pago\n';
            
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    const cells = row.querySelectorAll('td');
                    const rowData = [];
                    
                    // Obtener solo los primeros 7 campos (excluyendo las acciones)
                    for (let i = 0; i < 7; i++) {
                        let cellText = cells[i].innerText.trim();
                        // Eliminar etiquetas como "Reciente" o "Trimestral"
                        if (i === 1) { // Columna fecha
                            cellText = cellText.split('\n').pop().trim();
                        }
                        // Escapar comillas si es necesario
                        cellText = cellText.replace(/"/g, '""');
                        // Envolver en comillas si contiene comas
                        if (cellText.includes(',')) {
                            cellText = `"${cellText}"`;
                        }
                        rowData.push(cellText);
                    }
                    
                    csv += rowData.join(',') + '\n';
                }
            });
            
            // Crear blob y descargar
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'historial_pagos.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Mostrar notificación de éxito
            showNotification('CSV descargado con éxito', 'success');
        }

        // Función para mostrar notificaciones
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.padding = '15px 20px';
            notification.style.borderRadius = '4px';
            notification.style.color = 'white';
            notification.style.zIndex = '1000';
            notification.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
            notification.style.animation = 'fadeInOut 5s forwards';
            notification.style.display = 'flex';
            notification.style.alignItems = 'center';
            notification.style.gap = '10px';
            
            // Agregar icono según el tipo
            let icon = '';
            switch(type) {
                case 'success':
                    notification.style.backgroundColor = 'var(--success-color)';
                    icon = 'fa-check-circle';
                    break;
                case 'error':
                    notification.style.backgroundColor = 'var(--danger-color)';
                    icon = 'fa-times-circle';
                    break;
                case 'info':
                    notification.style.backgroundColor = 'var(--primary-color)';
                    icon = 'fa-info-circle';
                    break;
                default:
                    notification.style.backgroundColor = 'var(--primary-color)';
                    icon = 'fa-info-circle';
            }
            
            notification.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
            
            document.body.appendChild(notification);
            
            // Remover la notificación después de 5 segundos
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 5000);
        }

        // Crear gráficos cuando el documento esté listo
        window.addEventListener('load', function() {
            // Datos para el gráfico de pagos por mes
            const pagosData = <?php 
                $pagos_por_mes = [];
                foreach ($pagos as $pago) {
                    $mes = substr($pago['fecha_emision'], 0, 7);
                    if (!isset($pagos_por_mes[$mes])) {
                        $pagos_por_mes[$mes] = 0;
                    }
                    $pagos_por_mes[$mes] += $pago['cantidad_recibida'];
                }
                
                // Ordenar por fecha
                ksort($pagos_por_mes);
                
                // Formatear nombres de meses
                $meses_formateados = [];
                foreach (array_keys($pagos_por_mes) as $clave) {
                    $fecha = new DateTime($clave . '-01');
                    $meses_formateados[] = $fecha->format('M Y');
                }
                
                echo json_encode([
                    'labels' => $meses_formateados,
                    'values' => array_values($pagos_por_mes)
                ]);
            ?>;
            
            // Datos para el gráfico de métodos de pago
            const metodosData = <?php 
                $metodos = [];
                foreach ($pagos as $pago) {
                    $metodo = $pago['forma_pago'];
                    if (!isset($metodos[$metodo])) {
                        $metodos[$metodo] = 0;
                    }
                    $metodos[$metodo]++;
                }
                
                // Traducir nombres de métodos
                $metodos_traducidos = [];
                foreach ($metodos as $key => $value) {
                    switch ($key) {
                        case 'efectivo':
                            $metodos_traducidos['Efectivo'] = $value;
                            break;
                        case 'cheque':
                            $metodos_traducidos['Cheque'] = $value;
                            break;
                        case 'transferencia':
                            $metodos_traducidos['Transferencia'] = $value;
                            break;
                        case 'tarjeta_credito':
                            $metodos_traducidos['Tarjeta de Crédito'] = $value;
                            break;
                        default:
                            $metodos_traducidos[ucfirst($key)] = $value;
                    }
                }
                
                echo json_encode([
                    'labels' => array_keys($metodos_traducidos),
                    'values' => array_values($metodos_traducidos)
                ]);
            ?>;
            
            // Crear gráfico de pagos por mes
            if (pagosData.labels && pagosData.labels.length > 0) {
                const paymentsCtx = document.getElementById('paymentsChart').getContext('2d');
                new Chart(paymentsCtx, {
                    type: 'bar',
                    data: {
                        labels: pagosData.labels,
                        datasets: [{
                            label: 'Monto de pagos por mes',
                            data: pagosData.values,
                            backgroundColor: 'rgba(0, 119, 194, 0.6)',
                            borderColor: 'rgba(0, 119, 194, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        return '$' + value;
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    return '$' + Number(tooltipItem.yLabel).toFixed(2);
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            } else {
                document.getElementById('paymentsChart').parentNode.innerHTML = '<div class="no-data" style="text-align: center; padding: 50px;"><i class="fas fa-chart-bar" style="font-size: 48px; color: #ddd;"></i><p>No hay datos suficientes para mostrar</p></div>';
            }
            
            // Crear gráfico de métodos de pago
            if (metodosData.labels && metodosData.labels.length > 0) {
                const methodsCtx = document.getElementById('methodsChart').getContext('2d');
                
                // Asignar colores según la forma de pago
                const backgroundColors = [];
                const borderColors = [];
                
                for (let i = 0; i < metodosData.labels.length; i++) {
                    const label = metodosData.labels[i].toLowerCase();
                    if (label.includes('efectivo')) {
                        backgroundColors.push('rgba(76, 175, 80, 0.6)');
                        borderColors.push('rgba(76, 175, 80, 1)');
                    } else if (label.includes('cheque')) {
                        backgroundColors.push('rgba(255, 193, 7, 0.6)');
                        borderColors.push('rgba(255, 193, 7, 1)');
                    } else if (label.includes('transferencia')) {
                        backgroundColors.push('rgba(0, 119, 194, 0.6)');
                        borderColors.push('rgba(0, 119, 194, 1)');
                    } else if (label.includes('tarjeta')) {
                        backgroundColors.push('rgba(255, 87, 34, 0.6)');
                        borderColors.push('rgba(255, 87, 34, 1)');
                    } else {
                        backgroundColors.push('rgba(158, 158, 158, 0.6)');
                        borderColors.push('rgba(158, 158, 158, 1)');
                    }
                }
                
                new Chart(methodsCtx, {
                    type: 'doughnut',
                    data: {
                        labels: metodosData.labels,
                        datasets: [{
                            label: 'Métodos de pago',
                            data: metodosData.values,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'right'
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    const dataset = data.datasets[tooltipItem.datasetIndex];
                                    const total = dataset.data.reduce((acc, curr) => acc + curr, 0);
                                    const currentValue = dataset.data[tooltipItem.index];
                                    const percentage = ((currentValue / total) * 100).toFixed(1);
                                    return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 1500,
                            easing: 'easeOutBack'
                        }
                    }
                });
            } else {
                document.getElementById('methodsChart').parentNode.innerHTML = '<div class="no-data" style="text-align: center; padding: 50px;"><i class="fas fa-chart-pie" style="font-size: 48px; color: #ddd;"></i><p>No hay datos suficientes para mostrar</p></div>';
            }
        });

        // Añadir atributo data-id a cada fila para facilitar la eliminación
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const actionCell = row.querySelector('td:last-child');
                if (actionCell) {
                    const deleteButton = actionCell.querySelector('.btn-delete');
                    if (deleteButton) {
                        const onClick = deleteButton.getAttribute('onclick');
                        if (onClick) {
                            const idMatch = onClick.match(/confirmarEliminar\((\d+)\)/);
                            if (idMatch && idMatch[1]) {
                                row.setAttribute('data-id', idMatch[1]);
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>