<!-- views/usuario/finanzas/crear_contrato.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Contrato - Finanzas</title>
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
        
        /* Form section */
        .form-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .form-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
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
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
        }
        
        input:focus, select:focus, textarea:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        .required-label::after {
            content: ' *';
            color: var(--danger-color);
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
        
        .btn-secondary {
            background-color: var(--background-color);
            color: var(--text-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(244, 67, 54, 0.2);
        }
        
        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(76, 175, 80, 0.2);
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
            <h1 class="page-title">Crear Nuevo Contrato</h1>
            <div class="user-badge"><?php echo substr($usuario['nombres'], 0, 1) . substr($usuario['apellidos'], 0, 1); ?></div>
        </div>
        
        <?php if (!empty($mensaje)): ?>
            <div class="alert <?php echo $error ? 'alert-danger' : 'alert-success'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=finanzas&action=crearContrato" method="POST" class="form-section">
            <h2 class="form-title">Datos del Contrato</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_emision" class="required-label">Fecha de Emisión</label>
                    <input type="date" id="fecha_emision" name="fecha_emision" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label for="mes_pagado" class="required-label">Mes Pagado</label>
                    <select id="mes_pagado" name="mes_pagado" required>
                        <option value="">Selecciona un mes</option>
                        <option value="Enero">Enero</option>
                        <option value="Febrero">Febrero</option>
                        <option value="Marzo">Marzo</option>
                        <option value="Abril">Abril</option>
                        <option value="Mayo">Mayo</option>
                        <option value="Junio">Junio</option>
                        <option value="Julio">Julio</option>
                        <option value="Agosto">Agosto</option>
                        <option value="Septiembre">Septiembre</option>
                        <option value="Octubre">Octubre</option>
                        <option value="Noviembre">Noviembre</option>
                        <option value="Diciembre">Diciembre</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="titular_id" class="required-label">Titular</label>
                    <select id="titular_id" name="titular_id" required onchange="cargarEstudiantes()">
                        <option value="">Selecciona un titular</option>
                        <?php foreach ($titulares as $titular): ?>
                            <option value="<?php echo $titular['id']; ?>" <?php echo ($titular_id == $titular['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($titular['nombres'] . ' ' . $titular['apellidos'] . ' - ' . $titular['cedula']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="estudiante_id" class="required-label">Estudiante</label>
                    <select id="estudiante_id" name="estudiante_id" required>
                        <option value="">Selecciona primero un titular</option>
                        <?php foreach ($estudiantes as $estudiante): ?>
                            <option value="<?php echo $estudiante['id']; ?>">
                                <?php echo htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="forma_pago" class="required-label">Forma de Pago</label>
                    <select id="forma_pago" name="forma_pago" required onchange="mostrarCampoBanco()">
                        <option value="">Selecciona una forma de pago</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="cheque">Cheque</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="tarjeta_credito">Tarjeta de Crédito</option>
                    </select>
                </div>
                <div class="form-group" id="banco_container" style="display:none;">
                    <label for="banco">Banco</label>
                    <select id="banco" name="banco">
                        <option value="">Selecciona un banco</option>
                        <option value="Banco Pichincha">Banco Pichincha</option>
                        <option value="Banco Guayaquil">Banco Guayaquil</option>
                        <option value="Banco Pacífico">Banco Pacífico</option>
                        <option value="Produbanco">Produbanco</option>
                        <option value="Banco Internacional">Banco Internacional</option>
                        <option value="Banco Bolivariano">Banco Bolivariano</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="cantidad_recibida" class="required-label">Cantidad Recibida ($)</label>
                    <input type="number" id="cantidad_recibida" name="cantidad_recibida" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="organizacion">Organización</label>
                    <input type="text" id="organizacion" name="organizacion" value="<?php echo htmlspecialchars($usuario['organizacion'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="btn-group">
                <button type="button" class="btn btn-secondary" onclick="location.href='index.php?controller=finanzas&action=dashboard'">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Contrato</button>
            </div>
        </form>
    </div>

    <script>
        // Mostrar/ocultar campo de banco según forma de pago
        function mostrarCampoBanco() {
            const formaPago = document.getElementById('forma_pago').value;
            const bancoContainer = document.getElementById('banco_container');
            const bancoSelect = document.getElementById('banco');
            
            if (formaPago === 'cheque' || formaPago === 'transferencia') {
                bancoContainer.style.display = 'block';
                bancoSelect.required = true;
            } else {
                bancoContainer.style.display = 'none';
                bancoSelect.required = false;
                bancoSelect.value = '';
            }
        }
        
        // Cargar estudiantes al seleccionar un titular
        function cargarEstudiantes() {
            const titularId = document.getElementById('titular_id').value;
            const estudianteSelect = document.getElementById('estudiante_id');
            
            // Limpiar selector de estudiantes
            estudianteSelect.innerHTML = '<option value="">Cargando estudiantes...</option>';
            
            if (!titularId) {
                estudianteSelect.innerHTML = '<option value="">Selecciona primero un titular</option>';
                return;
            }
            
            // Realizar petición AJAX para obtener estudiantes del titular
            fetch(`index.php?controller=finanzas&action=getEstudiantesPorTitular&titular_id=${titularId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        estudianteSelect.innerHTML = '<option value="">Selecciona un estudiante</option>';
                        
                        if (data.data.estudiantes.length === 0) {
                            estudianteSelect.innerHTML = '<option value="">No hay estudiantes para este titular</option>';
                        } else {
                            data.data.estudiantes.forEach(estudiante => {
                                const option = document.createElement('option');
                                option.value = estudiante.id;
                                option.textContent = `${estudiante.nombres} ${estudiante.apellidos}`;
                                estudianteSelect.appendChild(option);
                            });
                        }
                    } else {
                        estudianteSelect.innerHTML = '<option value="">Error al cargar estudiantes</option>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    estudianteSelect.innerHTML = '<option value="">Error al cargar estudiantes</option>';
                });
        }
        
        // Si hay un titular preseleccionado, cargar sus estudiantes
        document.addEventListener('DOMContentLoaded', function() {
            const titularId = document.getElementById('titular_id').value;
            if (titularId) {
                cargarEstudiantes();
            }
            
            // Inicializar el campo de banco
            mostrarCampoBanco();
        });
    </script>
</body>
</html>