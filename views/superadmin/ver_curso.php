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

        /* Nuevos estilos para el horario */
        .schedule-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin: 30px 0;
            position: relative;
            overflow: hidden;
        }

        .schedule-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 8px;
            height: 100%;
            background: var(--primary-color);
        }

        .schedule-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding-bottom: 15px;
        }

        .schedule-title {
            font-size: 20px;
            font-weight: bold;
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }

        .schedule-title i {
            margin-right: 10px;
            font-size: 24px;
        }

        .schedule-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-download {
            background-color: #4361ee;
            color: white;
            border: none;
        }

        .btn-download:hover {
            background-color: #3a56d4;
            transform: translateY(-2px);
        }

        .btn-print {
            background-color: #4cc9f0;
            color: white;
            border: none;
        }

        .btn-print:hover {
            background-color: #33b8e0;
            transform: translateY(-2px);
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .schedule-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item i {
            font-size: 20px;
            color: var(--primary-color);
            width: 25px;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
            min-width: 100px;
        }

        .info-value {
            font-weight: 500;
        }

        .days-container {
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .days-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: #495057;
        }

        .days-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .day-badge {
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 14px;
            background-color: rgba(0, 119, 194, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .day-badge i {
            font-size: 16px;
        }

        /* Para la impresión del horario */
        @media print {
            body * {
                visibility: hidden;
            }
            #printable-schedule, #printable-schedule * {
                visibility: visible;
            }
            #printable-schedule {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .schedule-actions {
                display: none;
            }
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
            <li class="menu-item" onclick="location.href='index.php?controller=finanzas&action=informeFacturacion'">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Facturación</span>
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

            <!-- Nuevo Bloque de Horario del Curso -->
            <?php if (!empty($curso['fecha_inicio']) || !empty($curso['hora_inicio']) || !empty($curso['dias_semana'])): ?>
            <div class="schedule-card" id="printable-schedule">
                <div class="schedule-header">
                    <div class="schedule-title">
                        <i class="fas fa-calendar-alt"></i> Horario del Curso
                    </div>
                    <div class="schedule-actions">
                        <button class="action-btn btn-download" onclick="descargarHorario()">
                            <i class="fas fa-download"></i> Descargar
                        </button>
                        <button class="action-btn btn-print" onclick="imprimirHorario()">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                    </div>
                </div>
                
                <div class="schedule-grid">
                    <div class="schedule-info">
                        <?php if (!empty($curso['fecha_inicio']) && !empty($curso['fecha_fin'])): ?>
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span class="info-label">Fechas:</span>
                            <span class="info-value">
                                Del <?php echo date('d/m/Y', strtotime($curso['fecha_inicio'])); ?> 
                                al <?php echo date('d/m/Y', strtotime($curso['fecha_fin'])); ?>
                            </span>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($curso['hora_inicio']) && !empty($curso['hora_fin'])): ?>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span class="info-label">Horario:</span>
                            <span class="info-value">
                                De <?php echo date('H:i', strtotime($curso['hora_inicio'])); ?> 
                                a <?php echo date('H:i', strtotime($curso['hora_fin'])); ?>
                            </span>
                        </div>
                        <?php endif; ?>

                        <div class="info-item">
                            <i class="fas fa-hourglass-half"></i>
                            <span class="info-label">Duración:</span>
                            <span class="info-value">
                                <?php 
                                if (!empty($curso['hora_inicio']) && !empty($curso['hora_fin'])) {
                                    $inicio = new DateTime($curso['hora_inicio']);
                                    $fin = new DateTime($curso['hora_fin']);
                                    $duracion = $inicio->diff($fin);
                                    echo $duracion->format('%h horas y %i minutos');
                                } else {
                                    echo "No especificada";
                                }
                                ?>
                            </span>
                        </div>

                        <?php if (!empty($curso['fecha_inicio']) && !empty($curso['fecha_fin'])): ?>
                        <div class="info-item">
                            <i class="far fa-calendar-plus"></i>
                            <span class="info-label">Duración Total:</span>
                            <span class="info-value">
                                <?php 
                                $fecha_inicio = new DateTime($curso['fecha_inicio']);
                                $fecha_fin = new DateTime($curso['fecha_fin']);
                                $dias_totales = $fecha_inicio->diff($fecha_fin);
                                echo $dias_totales->format('%a días');
                                ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="days-container">
                        <div class="days-title">Días de Clase:</div>
                        <div class="days-grid">
                            <?php 
                            $dias_semana = json_decode($curso['dias_semana'] ?? '[]', true);
                            $dias_mapping = [
                                'lunes' => ['Lunes', 'calendar-day'],
                                'martes' => ['Martes', 'calendar-day'],
                                'miercoles' => ['Miércoles', 'calendar-day'],
                                'jueves' => ['Jueves', 'calendar-day'],
                                'viernes' => ['Viernes', 'calendar-day'],
                                'sabado' => ['Sábado', 'calendar-week'],
                                'domingo' => ['Domingo', 'calendar-week']
                            ];
                            
                            if (empty($dias_semana)): 
                            ?>
                                <div class="day-badge">
                                    <i class="fas fa-info-circle"></i> No especificados
                                </div>
                            <?php else: ?>
                                <?php foreach ($dias_semana as $dia): ?>
                                <div class="day-badge">
                                    <i class="fas fa-<?php echo $dias_mapping[$dia][1]; ?>"></i>
                                    <?php echo $dias_mapping[$dia][0]; ?>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

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

        // Función para imprimir el horario
        function imprimirHorario() {
            window.print();
        }

        // Función para descargar el horario como PDF
        function descargarHorario() {
            // Esto normalmente requeriría una librería como html2pdf.js
            // Para mantenerlo sencillo, usaremos una alternativa
            alert('Para implementar completamente esta función, necesitarás añadir la librería html2pdf.js al proyecto. Por ahora, puedes usar la función de imprimir y guardar como PDF desde el navegador.');
            
            // Simulación del proceso de descarga
            const downloadPrompt = document.createElement('div');
            downloadPrompt.style.position = 'fixed';
            downloadPrompt.style.top = '50%';
            downloadPrompt.style.left = '50%';
            downloadPrompt.style.transform = 'translate(-50%, -50%)';
            downloadPrompt.style.background = 'white';
            downloadPrompt.style.padding = '20px';
            downloadPrompt.style.borderRadius = '8px';
            downloadPrompt.style.boxShadow = '0 4px 20px rgba(0,0,0,0.2)';
            downloadPrompt.style.zIndex = '9999';
            downloadPrompt.style.maxWidth = '400px';
            downloadPrompt.style.textAlign = 'center';
            
            downloadPrompt.innerHTML = `
                <h3 style="margin-bottom:15px;">Descargar Horario</h3>
                <p style="margin-bottom:20px;">Utiliza el botón de imprimir y selecciona "Guardar como PDF" para descargar el horario.</p>
                <button id="printNow" style="background:#4361ee; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; margin-right:10px;">Imprimir ahora</button>
                <button id="closePrompt" style="background:#e0e0e0; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">Cerrar</button>
            `;
            
            document.body.appendChild(downloadPrompt);
            
            document.getElementById('printNow').addEventListener('click', function() {
                document.body.removeChild(downloadPrompt);
                setTimeout(function() {
                    window.print();
                }, 500);
            });
            
            document.getElementById('closePrompt').addEventListener('click', function() {
                document.body.removeChild(downloadPrompt);
            });
        }
    </script>
</body>
</html>