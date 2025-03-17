<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - <?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/app/public/css/styles.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card shadow-sm border-0 p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-warning display-1"></i>
                    </div>
                    <h1 class="display-4 mb-4">Error 404</h1>
                    <h2 class="mb-4">Página no encontrada</h2>
                    <p class="lead mb-5">Lo sentimos, la página que estás buscando no existe o ha sido movida.</p>
                    <div>
                        <a href="<?php echo SITE_URL; ?>" class="btn btn-primary btn-lg">Volver al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>