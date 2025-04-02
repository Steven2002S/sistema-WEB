<!-- views/usuario/finanzas/ver_contrato.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Contrato - Finanzas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

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
        
        /* Detail Sections */
        .detail-section {
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
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
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
        
        .btn-secondary {
            background-color: var(--background-color);
            color: var(--text-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-print {
            background-color: var(--accent-color);
            color: var(--text-color);
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .detail-item {
            margin-bottom: 15px;
        }
        
        .detail-label {
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--primary-color);
        }
        
        .detail-value {
            color: var(--text-color);
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(76, 175, 80, 0.2);
        }
        
        /* Recibo section */
        .recibo-section {
            margin-top: 30px;
        }
        
        .recibo-card {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .recibo-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .recibo-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .recibo-subtitle {
            font-size: 16px;
            color: #777;
        }
        
        .recibo-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .recibo-number {
            font-size: 18px;
            font-weight: bold;
        }
        
        .recibo-date {
            text-align: right;
        }
        
        .recibo-details {
            margin-bottom: 30px;
        }
        
        .recibo-row {
            display: flex;
            margin-bottom: 10px;
        }
        
        .recibo-label {
            flex: 1;
            font-weight: bold;
        }
        
        .recibo-value {
            flex: 2;
        }
        
        .recibo-amount {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .recibo-signatures {
        display: flex;
        justify-content: center;
        gap: 100px;
        margin-top: 50px;
        align-items: flex-end; 
        }

        .signature-line {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 200px;
        }

        .qr-code {
        margin-bottom: 25px; 
        }

        .signature-placeholder {
        width: 100%;
        border-top: 1px solid var(--text-color);
        margin-top: 10px; 
        height: 1px;
        }

        .qr-code img {
        width: 150px;
        height: 150px;
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
            <h1 class="page-title">Detalles del Contrato</h1>
            <div class="user-badge"><?php echo substr($usuario['nombres'], 0, 1) . substr($usuario['apellidos'], 0, 1); ?></div>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Operación realizada con éxito.
            </div>
        <?php endif; ?>

        <div class="detail-section">
            <div class="section-header">
                <h2 class="section-title">Información del Contrato #<?php echo htmlspecialchars($contrato['numero_contrato']); ?></h2>
                <button class="btn btn-primary" onclick="imprimirContrato()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
            
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Número de Contrato:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['numero_contrato']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Fecha de Emisión:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['fecha_emision']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Mes Pagado:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['mes_pagado']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Forma de Pago:</div>
                    <div class="detail-value"><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($contrato['forma_pago']))); ?></div>
                </div>
                
                <?php if (!empty($contrato['banco'])): ?>
                <div class="detail-item">
                    <div class="detail-label">Banco:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['banco']); ?></div>
                </div>
                <?php endif; ?>
                
                <div class="detail-item">
                    <div class="detail-label">Organización:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['organizacion']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Cantidad Recibida:</div>
                    <div class="detail-value">$<?php echo number_format($contrato['cantidad_recibida'], 2); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Fecha de Registro:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['created_at']); ?></div>
                </div>
            </div>
            
            <div class="section-header" style="margin-top: 30px;">
                <h2 class="section-title">Información del Titular y Estudiante</h2>
            </div>
            
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Titular:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['titular_nombres'] . ' ' . $contrato['titular_apellidos']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Estudiante:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['estudiante_nombres'] . ' ' . $contrato['estudiante_apellidos']); ?></div>
                </div>
            </div>
            
            <div class="section-header" style="margin-top: 30px;">
                <h2 class="section-title">Información del Verificador</h2>
            </div>
            
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Verificado por:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['verificador_nombres'] . ' ' . $contrato['verificador_apellidos']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Ejecutivo:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($contrato['ejecutivo_nombres'] . ' ' . $contrato['ejecutivo_apellidos']); ?></div>
                </div>
            </div>
            
            <div class="btn-group">
            <a href="index.php?controller=finanzas&action=dashboard" class="btn btn-secondary">Volver a la Lista</a>
            <a href="index.php?controller=finanzas&action=editarContrato&id=<?php echo $contrato['id']; ?>" class="btn btn-primary">Editar Contrato</a>
            </div>
        </div>

        <!-- Recibo Section -->
        <?php if (!empty($recibos)): ?>
        <div class="recibo-section" id="imprimible">
            <h2 class="section-title" style="margin-bottom: 15px;">Recibo</h2>
            
            <div class="recibo-card">
                <div class="recibo-header">
                    <div class="recibo-title">RECIBO DE PAGO</div>
                    <div class="recibo-subtitle">WeSystem - Gestión Educativa</div>
                </div>
                
                <div class="recibo-info">
                    <div class="recibo-number">
                        <div>Recibo N°: <?php echo htmlspecialchars($contrato['numero_contrato']); ?></div>
                    </div>
                    <div class="recibo-date">
                        <div>Fecha: <?php echo htmlspecialchars($contrato['fecha_emision']); ?></div>
                    </div>
                </div>
                
                <div class="recibo-details">
                    <div class="recibo-row">
                        <div class="recibo-label">Recibimos de:</div>
                        <div class="recibo-value"><?php echo htmlspecialchars($contrato['titular_nombres'] . ' ' . $contrato['titular_apellidos']); ?></div>
                    </div>
                    <div class="recibo-row">
                        <div class="recibo-label">Estudiante:</div>
                        <div class="recibo-value"><?php echo htmlspecialchars($contrato['estudiante_nombres'] . ' ' . $contrato['estudiante_apellidos']); ?></div>
                    </div>
                    <div class="recibo-row">
                        <div class="recibo-label">Concepto:</div>
                        <div class="recibo-value">Pago correspondiente al mes de <?php echo htmlspecialchars($contrato['mes_pagado']); ?></div>
                    </div>
                    <div class="recibo-row">
                        <div class="recibo-label">Forma de Pago:</div>
                        <div class="recibo-value"><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($contrato['forma_pago']))); ?></div>
                    </div>
                    <?php if (!empty($contrato['banco'])): ?>
                    <div class="recibo-row">
                        <div class="recibo-label">Banco:</div>
                        <div class="recibo-value"><?php echo htmlspecialchars($contrato['banco']); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="recibo-amount">
                    <div>TOTAL RECIBIDO: $<?php echo number_format($contrato['cantidad_recibida'], 2); ?></div>
                </div>
                
                <div class="recibo-signatures">
    <div class="signature-line">
        <div id="qrcode" class="qr-code"></div>
        <div>Firma del Vendedor</div>
    </div>
    <div class="signature-line">
        <div class="signature-placeholder"></div>
        <div>Firma del Titular</div>
    </div>
</div>
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
                <button class="btn btn-print" onclick="imprimirRecibo()">
                    <i class="fas fa-print"></i> Imprimir Recibo
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script>
        // Imprimir contrato
        function imprimirContrato() {
            window.print();
        }
        
        // Imprimir solo el recibo
        function imprimirRecibo() {
            const reciboSection = document.getElementById('imprimible');
            const contenidoOriginal = document.body.innerHTML;
            
            document.body.innerHTML = reciboSection.innerHTML;
            window.print();
            document.body.innerHTML = contenidoOriginal;
        }
        document.addEventListener('DOMContentLoaded', function() {
    // Generar el código QR
    new QRCode(document.getElementById("qrcode"), {
        text: "VENDEDOR: <?php echo $usuario['nombres'] . ' ' . $usuario['apellidos']; ?> | ID: <?php echo $usuario['id']; ?> | FECHA: <?php echo date('Y-m-d H:i:s'); ?> | CONTRATO: <?php echo $contrato['numero_contrato']; ?>",
        width: 150,
        height: 150,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
});
    </script>
</body>
</html>