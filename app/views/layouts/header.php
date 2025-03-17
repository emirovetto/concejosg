<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : SITE_NAME; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/app/public/css/styles.css">
</head>
<body>
    <!-- Encabezado -->
    <header>
        <!-- Barra superior con información de contacto -->
        <div class="bg-primary text-white py-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <small><i class="fas fa-envelope me-2"></i> info@concejosangenaro.gob.ar</small>
                        <small class="ms-3"><i class="fas fa-phone me-2"></i> (03401) 123456</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small><i class="fas fa-map-marker-alt me-2"></i> San Martín 1234, San Genaro, Santa Fe</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navbar principal -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?php echo SITE_URL; ?>">
                    <img src="<?php echo SITE_URL; ?>/app/public/img/logo.png" alt="<?php echo SITE_NAME; ?>" height="60">
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == 'home' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == 'sesiones' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/sesiones">Sesiones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == 'ordenanzas' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/ordenanzas">Ordenanzas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == 'concejales' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/concejales">Concejales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == 'bloques' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/bloques">Bloques</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == 'noticias' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/noticias">Noticias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == 'contacto' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/contacto">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Contenido principal -->
    <main class="py-4">
        <div class="container"><?php if (isset($breadcrumbs)): ?>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Inicio</a></li>
                    <?php foreach ($breadcrumbs as $text => $url): ?>
                        <?php if ($url): ?>
                            <li class="breadcrumb-item"><a href="<?php echo $url; ?>"><?php echo $text; ?></a></li>
                        <?php else: ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $text; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        <?php endif; ?> 