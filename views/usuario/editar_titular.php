<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Titular - Usuario</title>
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
        
        /* Form Section */
        .form-section {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .form-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 25px;
            color: var(--text-color);
            display: flex;
            align-items: center;
        }
        
        .form-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-required {
            color: var(--danger-color);
            margin-left: 4px;
        }
        
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        .form-input.error,
        .form-select.error,
        .form-textarea.error {
            border-color: var(--danger-color);
        }
        
        .form-help {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }
        
        .form-error {
            font-size: 13px;
            color: var(--danger-color);
            margin-top: 5px;
            display: none;
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
        
        .btn-add {
            background-color: var(--success-color);
            color: white;
        }
        
        .btn-add:hover {
            background-color: #3d9140;
        }
        
        .estudiante-container {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #f9f9f9;
        }
        
        .estudiante-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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
        
        .btn-remove {
            padding: 6px 12px;
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
        }
        
        .btn-remove:hover {
            background-color: rgba(244, 67, 54, 0.2);
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
        
        .separator {
            border-top: 1px solid var(--border-color);
            margin: 30px 0;
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

        /* Estilos para nuevo estudiante */
        #nuevoEstudianteForm {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #f0f8ff;
            border-radius: 8px;
            border: 1px solid #b3d7ff;
        }

        #nuevoEstudianteForm.active {
            display: block;
        }

        .section-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
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
            <h1 class="page-title">Editar Titular</h1>
            <div class="user-badge">
                <?php echo htmlspecialchars($iniciales); ?>
            </div>
        </div>

        <?php if (isset($mensaje) && !empty($mensaje)): ?>
        <div class="alert <?php echo $error ? 'alert-error' : 'alert-success'; ?>">
            <i class="fas <?php echo $error ? 'fa-exclamation-circle' : 'fa-check-circle'; ?>"></i>
            <span><?php echo htmlspecialchars($mensaje); ?></span>
        </div>
        <?php endif; ?>

        <!-- Formulario principal para el titular -->
        <form id="editTitularForm" action="index.php?controller=usuario&action=actualizarTitular" method="POST">
            <input type="hidden" name="id" value="<?php echo $titular['id']; ?>">
            
            <!-- Información del Titular -->
            <div class="form-section">
                <h2 class="form-title"><i class="fas fa-user-tie"></i> Información del Titular</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="cedula">Cédula<span class="form-required">*</span></label>
                        <input type="text" id="cedula" name="cedula" class="form-input" value="<?php echo htmlspecialchars($titular['cedula']); ?>" required>
                        <div class="form-error" id="cedula-error">Por favor, ingrese un número de cédula válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="nombres">Nombres<span class="form-required">*</span></label>
                        <input type="text" id="nombres" name="nombres" class="form-input" value="<?php echo htmlspecialchars($titular['nombres']); ?>" required>
                        <div class="form-error" id="nombres-error">Por favor, ingrese los nombres.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="apellidos">Apellidos<span class="form-required">*</span></label>
                        <input type="text" id="apellidos" name="apellidos" class="form-input" value="<?php echo htmlspecialchars($titular['apellidos']); ?>" required>
                        <div class="form-error" id="apellidos-error">Por favor, ingrese los apellidos.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="direccion">Dirección<span class="form-required">*</span></label>
                        <textarea id="direccion" name="direccion" class="form-textarea" required><?php echo htmlspecialchars($titular['direccion']); ?></textarea>
                        <div class="form-error" id="direccion-error">Por favor, ingrese la dirección.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-input" value="<?php echo htmlspecialchars($titular['email']); ?>">
                        <div class="form-error" id="email-error">Por favor, ingrese un correo válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="empresa">Empresa/Organización</label>
                        <input type="text" id="empresa" name="empresa" class="form-input" value="<?php echo htmlspecialchars($titular['empresa']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="celular">Celular</label>
                        <input type="text" id="celular" name="celular" class="form-input" value="<?php echo htmlspecialchars($titular['celular']); ?>">
                        <div class="form-error" id="celular-error">Por favor, ingrese un número de celular válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="telefono_casa">Teléfono Casa</label>
                        <input type="text" id="telefono_casa" name="telefono_casa" class="form-input" value="<?php echo htmlspecialchars($titular['telefono_casa']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="cargo">Cargo</label>
                        <input type="text" id="cargo" name="cargo" class="form-input" value="<?php echo htmlspecialchars($titular['cargo']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="telefono_trabajo">Teléfono Trabajo</label>
                        <input type="text" id="telefono_trabajo" name="telefono_trabajo" class="form-input" value="<?php echo htmlspecialchars($titular['telefono_trabajo']); ?>">
                    </div>
                </div>
            </div>

            <!-- Sección de Estudiantes (dentro del mismo formulario) -->
            <div class="form-section">
                <h2 class="form-title"><i class="fas fa-user-graduate"></i> Estudiantes Asociados</h2>
                
                <?php if (!empty($estudiantes)): ?>
                    <div class="estudiantes-list">
                        <?php foreach ($estudiantes as $index => $estudiante): ?>
                        <div class="estudiante-container">
                            <div class="estudiante-header">
                                <h3 class="estudiante-title">
                                    <i class="fas fa-user-graduate"></i>
                                    Estudiante <?php echo $index + 1; ?>: <?php echo htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']); ?>
                                </h3>
                                <div>
                                    <a href="index.php?controller=usuario&action=editarEstudiante&id=<?php echo $estudiante['id']; ?>" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <button type="button" class="btn-remove" onclick="mostrarModalEliminarEstudiante(<?php echo $estudiante['id']; ?>)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Cédula:</label>
                                    <div><?php echo empty($estudiante['cedula']) ? 'No disponible' : htmlspecialchars($estudiante['cedula']); ?></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Edad:</label>
                                    <div><?php echo htmlspecialchars($estudiante['edad']); ?> años</div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Curso:</label>
                                    <div><?php echo htmlspecialchars($estudiante['curso_nombre']); ?></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Talla:</label>
                                    <div><?php echo empty($estudiante['talla']) ? 'No disponible' : htmlspecialchars($estudiante['talla']); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No hay estudiantes asociados a este titular.</p>
                <?php endif; ?>
                
                <div class="section-actions">
                    <button type="button" class="btn btn-add" onclick="toggleNuevoEstudiante()">
                        <i class="fas fa-plus"></i> Agregar Nuevo Estudiante
                    </button>
                    <a href="index.php?controller=usuario&action=crearEstudiante&titular_id=<?php echo $titular['id']; ?>" class="btn btn-secondary">
                        <i class="fas fa-external-link-alt"></i> Ir a Pantalla Completa
                    </a>
                </div>
            </div>
            
            <!-- Información de Referencia Personal (dentro del mismo formulario) -->
            <?php if (!empty($referencias)): ?>
                <?php $referencia = $referencias[0]; // Tomamos la primera referencia ?>
                <div class="form-section">
                    <h2 class="form-title"><i class="fas fa-address-book"></i> Referencia Personal</h2>
                    
                    <!-- Mostramos la información de la referencia pero sin campos editables -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nombres:</label>
                            <div><?php echo htmlspecialchars($referencia['nombres']); ?></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Apellidos:</label>
                            <div><?php echo htmlspecialchars($referencia['apellidos']); ?></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email:</label>
                            <div><?php echo htmlspecialchars($referencia['email']); ?></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Celular:</label>
                            <div><?php echo htmlspecialchars($referencia['celular']); ?></div>
                        </div>
                    </div>
                    
                    <p class="form-help">Para editar la referencia, use el botón de Editar Referencia después de guardar los cambios del titular.</p>
                    
                    <div class="form-buttons">
                        <a href="index.php?controller=usuario&action=editarReferencia&id=<?php echo $referencia['id']; ?>" class="btn btn-secondary">
                            <i class="fas fa-edit"></i> Editar Referencia
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="form-section">
                    <h2 class="form-title"><i class="fas fa-address-book"></i> Referencia Personal</h2>
                    <p>No hay referencias personales asociadas a este titular.</p>
                    <p class="form-help">Puede agregar una referencia después de guardar los cambios del titular.</p>
                </div>
            <?php endif; ?>
            
            <!-- Botones de acción para el formulario principal (AL FINAL) -->
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="index.php?controller=usuario&action=listarTitulares" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
        
        <!-- Formulario para nuevo estudiante (fuera del formulario principal) -->
        <div id="nuevoEstudianteForm" style="display:none;">
            <form action="index.php?controller=usuario&action=crearEstudianteInline" method="POST">
                <input type="hidden" name="titular_id" value="<?php echo $titular['id']; ?>">
                
                <h3 class="estudiante-title"><i class="fas fa-user-graduate"></i> Nuevo Estudiante</h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="estudiante_cedula">Cédula</label>
                        <input type="text" id="estudiante_cedula" name="cedula" class="form-input">
                        <div class="form-error" id="estudiante_cedula-error">Por favor, ingrese un número de cédula válido.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="estudiante_nombres">Nombres<span class="form-required">*</span></label>
                        <input type="text" id="estudiante_nombres" name="nombres" class="form-input" required>
                        <div class="form-error" id="estudiante_nombres-error">Por favor, ingrese los nombres.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="estudiante_apellidos">Apellidos<span class="form-required">*</span></label>
                        <input type="text" id="estudiante_apellidos" name="apellidos" class="form-input" required>
                        <div class="form-error" id="estudiante_apellidos-error">Por favor, ingrese los apellidos.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="estudiante_edad">Edad<span class="form-required">*</span></label>
                        <input type="number" id="estudiante_edad" name="edad" class="form-input" min="1" max="100" required>
                        <div class="form-error" id="estudiante_edad-error">Por favor, ingrese una edad válida.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="estudiante_curso_id">Curso<span class="form-required">*</span></label>
                        <select id="estudiante_curso_id" name="curso_id" class="form-select" required>
                            <option value="">Seleccione un curso...</option>
                            <?php foreach ($cursos as $curso): ?>
                                <?php if ($curso['estado'] === 'activo'): ?>
                                <option value="<?php echo $curso['id']; ?>"><?php echo htmlspecialchars($curso['nombre']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-error" id="estudiante_curso_id-error">Por favor, seleccione un curso.</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="estudiante_talla">Talla</label>
                        <input type="text" id="estudiante_talla" name="talla" class="form-input">
                    </div>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Estudiante
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="toggleNuevoEstudiante()">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para confirmar eliminación de estudiante -->
    <div id="modalEliminarEstudiante" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModalEstudiante()">&times;</span>
            <h2 class="modal-title">Confirmar eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar este estudiante? Esta acción no se puede deshacer.</p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" onclick="cerrarModalEstudiante()">Cancelar</button>
                <button class="btn btn-danger" id="btnConfirmarEliminarEstudiante">Eliminar</button>
            </div>
        </div>
    </div>
    
    <script>
        // Validación del formulario
        document.getElementById('editTitularForm').addEventListener('submit', function(e) {
            let hasErrors = false;
            
            // Validar cédula del titular
            const cedula = document.getElementById('cedula');
            if (!cedula.value.trim() || !/^\d{7,12}$/.test(cedula.value.trim())) {
                showError(cedula, 'cedula-error', 'Por favor, ingrese un número de cédula válido (7-12 dígitos).');
                hasErrors = true;
            } else {
                hideError(cedula, 'cedula-error');
            }
            
            // Validar nombres del titular
            const nombres = document.getElementById('nombres');
            if (!nombres.value.trim()) {
                showError(nombres, 'nombres-error', 'Por favor, ingrese los nombres.');
                hasErrors = true;
            } else {
                hideError(nombres, 'nombres-error');
            }
            
            // Validar apellidos del titular
            const apellidos = document.getElementById('apellidos');
            if (!apellidos.value.trim()) {
                showError(apellidos, 'apellidos-error', 'Por favor, ingrese los apellidos.');
                hasErrors = true;
            } else {
                hideError(apellidos, 'apellidos-error');
            }
            
            // Validar dirección del titular
            const direccion = document.getElementById('direccion');
            if (!direccion.value.trim()) {
                showError(direccion, 'direccion-error', 'Por favor, ingrese la dirección.');
                hasErrors = true;
            } else {
                hideError(direccion, 'direccion-error');
            }
            
            // Validar correo del titular (opcional)
            const email = document.getElementById('email');
            if (email.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
                showError(email, 'email-error', 'Por favor, ingrese un correo electrónico válido.');
                hasErrors = true;
            } else {
                hideError(email, 'email-error');
            }
            
            // Si hay errores, detener el envío del formulario
            if (hasErrors) {
                e.preventDefault();
            }
        });
        
        // Función para mostrar mensajes de error
        function showError(input, errorId, message) {
            input.classList.add('error');
            const errorElement = document.getElementById(errorId);
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        
        // Función para ocultar mensajes de error
        function hideError(input, errorId) {
            input.classList.remove('error');
            document.getElementById(errorId).style.display = 'none';
        }
        
        // Modal para eliminar estudiante
        let estudianteIdEliminar = null;
        const modalEstudiante = document.getElementById('modalEliminarEstudiante');
        
        function mostrarModalEliminarEstudiante(id) {
            estudianteIdEliminar = id;
            modalEstudiante.style.display = 'block';
        }
        
        function cerrarModalEstudiante() {
            modalEstudiante.style.display = 'none';
        }
        
        // Cierra el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target == modalEstudiante) {
                cerrarModalEstudiante();
            }
        }
        
        // Configurar el botón de confirmación de eliminación
        document.getElementById('btnConfirmarEliminarEstudiante').addEventListener('click', function() {
            if (estudianteIdEliminar) {
                // Enviar solicitud para eliminar estudiante
                fetch('index.php?controller=usuario&action=eliminarEstudiante', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${estudianteIdEliminar}`
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
            cerrarModalEstudiante();
        });
        
        // Funcionalidad para mostrar/ocultar formulario de nuevo estudiante
        function toggleNuevoEstudiante() {
            const form = document.getElementById('nuevoEstudianteForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
        
        // Validación para el formulario de nuevo estudiante
        document.querySelector('#nuevoEstudianteForm form').addEventListener('submit', function(e) {
            let hasErrors = false;
            
            // Validar nombres del estudiante
            const estudiante_nombres = document.getElementById('estudiante_nombres');
            if (!estudiante_nombres.value.trim()) {
                showError(estudiante_nombres, 'estudiante_nombres-error', 'Por favor, ingrese los nombres.');
                hasErrors = true;
            } else {
                hideError(estudiante_nombres, 'estudiante_nombres-error');
            }
            
            // Validar apellidos del estudiante
            const estudiante_apellidos = document.getElementById('estudiante_apellidos');
            if (!estudiante_apellidos.value.trim()) {
                showError(estudiante_apellidos, 'estudiante_apellidos-error', 'Por favor, ingrese los apellidos.');
                hasErrors = true;
            } else {
                hideError(estudiante_apellidos, 'estudiante_apellidos-error');
            }
            
            // Validar edad del estudiante
            const estudiante_edad = document.getElementById('estudiante_edad');
            if (!estudiante_edad.value || estudiante_edad.value < 1 || estudiante_edad.value > 100) {
                showError(estudiante_edad, 'estudiante_edad-error', 'Por favor, ingrese una edad válida (entre 1 y 100).');
                hasErrors = true;
            } else {
                hideError(estudiante_edad, 'estudiante_edad-error');
            }
            
            // Validar curso del estudiante
            const estudiante_curso_id = document.getElementById('estudiante_curso_id');
            if (!estudiante_curso_id.value) {
                showError(estudiante_curso_id, 'estudiante_curso_id-error', 'Por favor, seleccione un curso.');
                hasErrors = true;
            } else {
                hideError(estudiante_curso_id, 'estudiante_curso_id-error');
            }
            
            // Validar cédula del estudiante (opcional)
            const estudiante_cedula = document.getElementById('estudiante_cedula');
            if (estudiante_cedula.value.trim() && !/^\d{7,12}$/.test(estudiante_cedula.value.trim())) {
                showError(estudiante_cedula, 'estudiante_cedula-error', 'Por favor, ingrese un número de cédula válido (7-12 dígitos).');
                hasErrors = true;
            } else {
                hideError(estudiante_cedula, 'estudiante_cedula-error');
            }
            
            // Si hay errores, detener el envío del formulario
            if (hasErrors) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>