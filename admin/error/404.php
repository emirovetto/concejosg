<?php
// Iniciar sesión
session_start();

// Incluir archivos de configuración
require_once '../../app/config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página No Encontrada</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .error-container {
            text-align: center;
            padding: 100px 0;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #ffc107;
        }
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="error-code">404</div>
            <h1 class="mb-4">Página No Encontrada</h1>
            <p class="lead mb-5">Lo sentimos, la página que estás buscando no existe o ha sido movida.</p>
            <a href="<?= ADMIN_URL ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-home me-2"></i> Volver al Dashboard
            </a>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 