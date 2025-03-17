<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Panel de Administración - Concejo Deliberante de San Genaro">
    <meta name="author" content="Concejo Deliberante de San Genaro">
    <title><?= isset($title) ? $title : 'Panel de Administración - Concejo Deliberante de San Genaro' ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/app/public/img/favicon.ico">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
    <!-- Custom styles -->
    <style>
        /* Estilos para el panel de administración */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .sb-nav-fixed {
            padding-top: 56px;
        }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_nav {
            width: 225px;
            height: 100vh;
            position: fixed;
            top: 56px;
            left: 0;
            z-index: 1038;
        }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding-left: 225px;
            top: 56px;
        }

        .sb-topnav {
            padding-left: 0;
            height: 56px;
            z-index: 1039;
            position: fixed;
            width: 100%;
            top: 0;
        }

        .sb-sidenav {
            display: flex;
            flex-direction: column;
            height: 100%;
            flex-wrap: nowrap;
        }

        .sb-sidenav .sb-sidenav-menu {
            flex-grow: 1;
            overflow-y: auto;
        }

        .sb-sidenav-dark {
            background-color: #212529;
            color: rgba(255, 255, 255, 0.5);
        }

        .sb-sidenav-dark .sb-sidenav-menu .nav-link {
            color: rgba(255, 255, 255, 0.5);
        }

        .sb-sidenav-dark .sb-sidenav-menu .nav-link:hover {
            color: #fff;
        }

        .sb-sidenav-dark .sb-sidenav-menu .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sb-sidenav-dark .sb-sidenav-footer {
            background-color: #343a40;
        }

        .sb-sidenav-menu-heading {
            padding: 1.75rem 1rem 0.75rem;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .sb-sidenav-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            position: relative;
        }

        .sb-nav-link-icon {
            margin-right: 0.5rem;
        }

        #layoutSidenav {
            display: flex;
        }

        #layoutSidenav_nav {
            flex: 0 0 225px;
            width: 225px;
        }

        #layoutSidenav_content {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            flex-grow: 1;
            min-height: calc(100vh - 56px);
        }

        .sb-sidenav-toggled #layoutSidenav_nav {
            transform: translateX(-225px);
        }

        .sb-sidenav-toggled #layoutSidenav_content {
            margin-left: 0;
        }

        @media (max-width: 991.98px) {
            .sb-nav-fixed #layoutSidenav #layoutSidenav_nav {
                transform: translateX(-225px);
                width: 225px;
            }
            
            .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
                padding-left: 0;
            }
            
            .sb-sidenav-toggled #layoutSidenav_nav {
                transform: translateX(0);
            }
            
            .sb-sidenav-toggled #layoutSidenav_content {
                margin-left: 0;
            }
        }

        @media (min-width: 992px) {
            .sb-nav-fixed #layoutSidenav #layoutSidenav_nav {
                transform: translateX(0);
            }
            
            .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
                padding-left: 225px;
            }
            
            .sb-sidenav-toggled #layoutSidenav_nav {
                transform: translateX(-225px);
            }
            
            .sb-sidenav-toggled #layoutSidenav_content {
                padding-left: 0;
            }
        }

        /* Estilos para las tarjetas del dashboard */
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
            margin-bottom: 1rem;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        /* Estilos para las tablas */
        .table-responsive {
            margin-bottom: 1rem;
        }

        .datatable {
            width: 100% !important;
        }

        /* Estilos para los formularios */
        .form-group {
            margin-bottom: 1rem;
        }

        .required:after {
            content: " *";
            color: #dc3545;
        }

        /* Estilos para los botones de acción en tablas */
        .btn-action {
            margin-right: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        /* Estilos para el editor Summernote */
        .note-editor {
            margin-bottom: 1rem;
        }

        /* Estilos para las alertas */
        .alert {
            margin-bottom: 1.5rem;
        }

        /* Estilos para el footer */
        footer {
            font-size: 0.875rem;
            margin-top: auto;
            padding: 1rem 0;
        }

        /* Estilos para contenedores */
        .container-fluid {
            padding: 1.5rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .page-title {
            margin-bottom: 0;
            font-size: 1.5rem;
            font-weight: 500;
        }

        /* Estilos para dispositivos móviles */
        @media (max-width: 767.98px) {
            .container-fluid {
                padding: 1rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .table-responsive {
                overflow-x: auto;
            }
            
            .btn {
                margin-bottom: 0.5rem;
            }

            .page-header .btn {
                margin-top: 0.5rem;
            }

            .page-header .col-auto {
                width: 100%;
                text-align: left;
                margin-top: 0.5rem;
            }

            .page-title {
                font-size: 1.25rem;
            }
        }

        /* Mejoras para dispositivos móviles */
        @media (max-width: 575.98px) {
            .btn-group {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .btn-group .btn {
                margin-bottom: 0.25rem;
                width: 100%;
            }

            .datatable th, .datatable td {
                white-space: nowrap;
            }
        }
    </style>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Top Navigation -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand -->
        <a class="navbar-brand ps-3" href="<?= ADMIN_URL ?>">
            <img src="<?= BASE_URL ?>/app/public/img/logo-small.png" alt="Logo" height="30" class="me-2">
            Admin Concejo
        </a>
        
        <!-- Sidebar Toggle -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Navbar Search -->
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <!-- Espacio para búsqueda si se necesita -->
        </div>
        
        <!-- Navbar User Menu -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> <?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario' ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?= ADMIN_URL ?>/?section=usuarios&action=perfil">Mi Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= ADMIN_URL ?>/logout.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    
    <div id="layoutSidenav">
        <!-- Sidebar content will be included here -->
    </div>
</body>
</html> 