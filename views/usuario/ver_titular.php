<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Titular - Usuario</title>
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
        
        /* Detail Section */
        .detail-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 25px;
            color: var(--text-color);
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }
        
        .section-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .detail-item {
            margin-bottom: 15px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #666;
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-size: 16px;
        }
        
        .detail-value.empty {
            color: #999;
            font-style: italic;
        }
        
        .form-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
        
        .btn-warning {
            background-color: var(--warning-color);
            color: white;
        }
        
        /* Estudiantes Section */
        .estudiantes-list {
            margin-top: 20px;
        }
        
        .estudiante-item {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
        }
        
        .estudiante-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }
        
        .estudiante-title {
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .estudiante-title i {
            margin-right: 8px;
            color: var(--primary-color);
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">GestUsers</div>
        <div class="admin-info">
            <div class="admin-avatar">U</div>
            <div class="admin-details">
            <div class="admin-name">Usuario</div>
                <div class="admin-role">Gestor</div>
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
            <h1 class="page-title">Detalles del Titular</h1>
            <div class="user-badge">U</div>
        </div>

        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>Operación realizada con éxito.</span>
        </div>
        <?php endif; ?>

        <!-- Información del Titular -->
        <div class="detail-section">
            <h2 class="section-title"><i class="fas fa-user-tie"></i> Información del Titular</h2>
            
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Cédula:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($titular['cedula']); ?></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Nombres:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($titular['nombres']); ?></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Apellidos:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($titular['apellidos']); ?></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Dirección:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($titular['direccion']); ?></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Correo Electrónico:</div>
                    <div class="detail-value <?php echo empty($titular['email']) ? 'empty' : ''; ?>">
                        <?php echo empty($titular['email']) ? 'No disponible' : htmlspecialchars($titular['email']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Empresa/Organización:</div>
                    <div class="detail-value <?php echo empty($titular['empresa']) ? 'empty' : ''; ?>">
                        <?php echo empty($titular['empresa']) ? 'No disponible' : htmlspecialchars($titular['empresa']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Celular:</div>
                    <div class="detail-value <?php echo empty($titular['celular']) ? 'empty' : ''; ?>">
                        <?php echo empty($titular['celular']) ? 'No disponible' : htmlspecialchars($titular['celular']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Teléfono Casa:</div>
                    <div class="detail-value <?php echo empty($titular['telefono_casa']) ? 'empty' : ''; ?>">
                        <?php echo empty($titular['telefono_casa']) ? 'No disponible' : htmlspecialchars($titular['telefono_casa']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Cargo:</div>
                    <div class="detail-value <?php echo empty($titular['cargo']) ? 'empty' : ''; ?>">
                        <?php echo empty($titular['cargo']) ? 'No disponible' : htmlspecialchars($titular['cargo']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Teléfono Trabajo:</div>
                    <div class="detail-value <?php echo empty($titular['telefono_trabajo']) ? 'empty' : ''; ?>">
                        <?php echo empty($titular['telefono_trabajo']) ? 'No disponible' : htmlspecialchars($titular['telefono_trabajo']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Fecha de Registro:</div>
                    <div class="detail-value"><?php echo date('d/m/Y H:i', strtotime($titular['fecha_registro'])); ?></div>
                </div>
            </div>
        </div>
        
        <!-- Estudiantes del Titular -->
        <div class="detail-section">
            <h2 class="section-title"><i class="fas fa-user-graduate"></i> Estudiantes Asociados</h2>
            
            <?php if (!empty($estudiantes)): ?>
            <div class="estudiantes-list">
                <?php foreach ($estudiantes as $index => $estudiante): ?>
                <div class="estudiante-item">
                    <div class="estudiante-header">
                        <h3 class="estudiante-title">
                            <i class="fas fa-user-graduate"></i>
                            Estudiante <?php echo $index + 1; ?>
                        </h3>
                        <div>
                            <a href="index.php?controller=usuario&action=editarEstudiante&id=<?php echo $estudiante['id']; ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>
                    </div>
                    
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Cédula:</div>
                            <div class="detail-value <?php echo empty($estudiante['cedula']) ? 'empty' : ''; ?>">
                                <?php echo empty($estudiante['cedula']) ? 'No disponible' : htmlspecialchars($estudiante['cedula']); ?>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Nombres:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($estudiante['nombres']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Apellidos:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($estudiante['apellidos']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Edad:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($estudiante['edad']); ?> años</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Curso:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($estudiante['curso_nombre']); ?></div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Talla:</div>
                            <div class="detail-value <?php echo empty($estudiante['talla']) ? 'empty' : ''; ?>">
                                <?php echo empty($estudiante['talla']) ? 'No disponible' : htmlspecialchars($estudiante['talla']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p>No hay estudiantes asociados a este titular.</p>
            <?php endif; ?>
        </div>
        
        <!-- Referencias del Titular -->
        <?php if (!empty($referencias)): ?>
        <div class="detail-section">
            <h2 class="section-title"><i class="fas fa-address-book"></i> Referencia Personal</h2>
            
            <div class="detail-grid">
                <?php foreach ($referencias as $referencia): ?>
                <div class="detail-item">
                    <div class="detail-label">Nombres:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($referencia['nombres']); ?></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Apellidos:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($referencia['apellidos']); ?></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Dirección:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($referencia['direccion']); ?></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Correo Electrónico:</div>
                    <div class="detail-value <?php echo empty($referencia['email']) ? 'empty' : ''; ?>">
                        <?php echo empty($referencia['email']) ? 'No disponible' : htmlspecialchars($referencia['email']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Celular:</div>
                    <div class="detail-value <?php echo empty($referencia['celular']) ? 'empty' : ''; ?>">
                        <?php echo empty($referencia['celular']) ? 'No disponible' : htmlspecialchars($referencia['celular']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Teléfono Casa:</div>
                    <div class="detail-value <?php echo empty($referencia['telefono_casa']) ? 'empty' : ''; ?>">
                        <?php echo empty($referencia['telefono_casa']) ? 'No disponible' : htmlspecialchars($referencia['telefono_casa']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Empresa:</div>
                    <div class="detail-value <?php echo empty($referencia['empresa']) ? 'empty' : ''; ?>">
                        <?php echo empty($referencia['empresa']) ? 'No disponible' : htmlspecialchars($referencia['empresa']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Cargo:</div>
                    <div class="detail-value <?php echo empty($referencia['cargo']) ? 'empty' : ''; ?>">
                        <?php echo empty($referencia['cargo']) ? 'No disponible' : htmlspecialchars($referencia['cargo']); ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Teléfono Trabajo:</div>
                    <div class="detail-value <?php echo empty($referencia['telefono_trabajo']) ? 'empty' : ''; ?>">
                        <?php echo empty($referencia['telefono_trabajo']) ? 'No disponible' : htmlspecialchars($referencia['telefono_trabajo']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="form-buttons">
            <a href="index.php?controller=usuario&action=editarTitular&id=<?php echo $titular['id']; ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar Titular
            </a>
            <a href="index.php?controller=usuario&action=listarTitulares" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button class="btn btn-danger" onclick="mostrarModalEliminar(<?php echo $titular['id']; ?>)">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div id="modalEliminar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2 class="modal-title">Confirmar eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar este titular? Esta acción eliminará también todas sus referencias personales y se perderá esta información.</p>
            <p><strong>Nota:</strong> No se puede eliminar un titular que tenga estudiantes asociados. Debes eliminar primero los estudiantes.</p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                <button class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>

    <script>
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
                        // Redirigir a la lista de titulares
                        window.location.href = 'index.php?controller=usuario&action=listarTitulares&success=1';
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