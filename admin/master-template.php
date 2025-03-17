<?php
/**
 * Archivo de plantilla maestro para el panel de administración
 * Este archivo se incluye en todas las páginas del panel y maneja la estructura general
 */

// Verificar si se está accediendo directamente al archivo
if (!defined('ADMIN_ACCESS')) {
    header('HTTP/1.0 403 Forbidden');
    exit('Acceso prohibido');
}

// Variables necesarias
$section = $section ?? 'dashboard';
$title = $title ?? 'Panel de Administración';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Panel de Administración - Concejo Deliberante de San Genaro">
    <meta name="author" content="Concejo Deliberante de San Genaro">
    <title><?= $title . ' - ' . SITE_NAME ?></title>
    
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
            z-index: 1001;
        }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding-left: 225px;
            top: 56px;
        }

        @media (max-width: 991.98px) {
            .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
                padding-left: 0;
            }
            
            .sb-nav-fixed #layoutSidenav #layoutSidenav_nav {
                width: 0;
            }
            
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav {
                width: 225px !important;
            }
        }

        #layoutSidenav {
            display: flex;
        }

        #layoutSidenav #layoutSidenav_nav {
            flex-basis: 225px;
            flex-shrink: 0;
            transition: transform .15s ease-in-out;
            z-index: 1002;
            background-color: #212529;
        }

        #layoutSidenav #layoutSidenav_content {
            flex-grow: 1;
            min-width: 0;
            min-height: calc(100vh - 56px);
            position: relative;
            z-index: 1001;
        }

        .sb-sidenav {
            display: flex;
            flex-direction: column;
            height: 100%;
            flex-wrap: nowrap;
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

        .sb-sidenav-menu {
            flex-grow: 1;
        }

        .sb-sidenav-menu .nav {
            flex-direction: column;
            flex-wrap: nowrap;
        }

        .sb-sidenav-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            position: relative;
        }

        .sb-sidenav-menu .nav-link .sb-nav-link-icon {
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }

        .sb-sidenav-footer {
            padding: 0.75rem;
            flex-shrink: 0;
        }

        .sb-topnav {
            padding-left: 0;
            height: 56px;
            z-index: 1002;
        }

        .sb-topnav.navbar-dark #sidebarToggle {
            color: rgba(255, 255, 255, 0.5);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #fff !important;
            background: #0d6efd !important;
            border-color: #0d6efd !important;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .card-dashboard {
            transition: transform 0.2s ease-in-out;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
        }

        .breadcrumb {
            margin-bottom: 20px;
        }

        .action-buttons .btn {
            margin-right: 5px;
        }

        .action-buttons .btn:last-child {
            margin-right: 0;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 0.5rem 1rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .bg-custom-primary {
            background-color: #1e3a8a;
        }

        .note-editor .dropdown-toggle::after {
            display: none;
        }

        .note-toolbar {
            background-color: #f8f9fa;
        }

        .custom-file-label::after {
            content: "Buscar";
        }

        .img-preview {
            max-width: 200px;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        .help-block {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        /* Estilos para el modal de confirmación */
        .modal-confirm .modal-header {
            border-bottom: none;
        }

        .modal-confirm .modal-content {
            border-radius: 0.5rem;
        }

        .modal-confirm .modal-footer {
            border-top: none;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?= ADMIN_URL ?>">Panel de Administración</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar Search-->
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> <?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario' ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?= ADMIN_URL ?>?section=usuarios&action=perfil">Perfil</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="<?= ADMIN_URL ?>/logout.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Principal</div>
                        
                        <!-- Dashboard -->
                        <a class="nav-link <?= $section === 'dashboard' ? 'active' : '' ?>" href="<?= ADMIN_URL ?>?section=dashboard">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Contenido</div>
                        
                        <!-- Noticias -->
                        <a class="nav-link <?= $section === 'noticias' ? 'active' : '' ?>" href="<?= ADMIN_URL ?>?section=noticias">
                            <div class="sb-nav-link-icon"><i class="fas fa-newspaper"></i></div>
                            Noticias
                        </a>
                        
                        <!-- Categorías -->
                        <a class="nav-link <?= $section === 'categorias' ? 'active' : '' ?>" href="<?= ADMIN_URL ?>?section=categorias">
                            <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                            Categorías
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Concejo</div>
                        
                        <!-- Sesiones -->
                        <a class="nav-link <?= $section === 'sesiones' ? 'active' : '' ?>" href="<?= ADMIN_URL ?>?section=sesiones">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                            Sesiones
                        </a>
                        
                        <!-- Ordenanzas -->
                        <a class="nav-link <?= $section === 'ordenanzas' ? 'active' : '' ?>" href="<?= ADMIN_URL ?>?section=ordenanzas">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Ordenanzas
                        </a>
                        
                        <!-- Concejales -->
                        <a class="nav-link <?= $section === 'concejales' ? 'active' : '' ?>" href="<?= ADMIN_URL ?>?section=concejales">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Concejales
                        </a>
                        
                        <!-- Bloques Políticos -->
                        <a class="nav-link <?= $section === 'bloques' ? 'active' : '' ?>" href="<?= ADMIN_URL ?>?section=bloques">
                            <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                            Bloques Políticos
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Administración</div>
                        
                        <!-- Usuarios -->
                        <a class="nav-link <?= $section === 'usuarios' ? 'active' : '' ?>" href="<?= ADMIN_URL ?>?section=usuarios">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                            Usuarios
                        </a>
                        
                        <!-- Configuración -->
                        <a class="nav-link <?= $section === 'configuracion' ? 'active' : '' ?>" href="<?= ADMIN_URL ?>?section=configuracion">
                            <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                            Configuración
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Sesión iniciada como:</div>
                    <?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario' ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <!-- Contenido principal se cargará aquí -->
                <?php if (isset($content)): ?>
                    <?= $content ?>
                <?php endif; ?>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Concejo Deliberante San Genaro <?= date('Y') ?></div>
                        <div>
                            <a href="<?= SITE_URL ?>" target="_blank">Visitar sitio web</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-es-ES.min.js"></script>
    
    <!-- Custom scripts for admin panel -->
    <script>
        // Script para el menú lateral
        window.addEventListener('DOMContentLoaded', event => {
            // Alternar el menú lateral
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
                });
            }

            // Inicializar DataTables en todas las tablas con la clase .datatable
            if ($.fn.DataTable) {
                $('.datatable').DataTable({
                    responsive: true,
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                    }
                });
            }

            // Inicializar el editor Summernote en todos los campos con la clase .summernote
            if ($.fn.summernote) {
                $('.summernote').summernote({
                    lang: 'es-ES',
                    height: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            }

            // Inicializar tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Mostrar nombre del archivo seleccionado en inputs de tipo file
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });

        // Función para confirmar eliminación
        function confirmarEliminar(id, tipo) {
            if (confirm('¿Está seguro de que desea eliminar este ' + tipo + '?')) {
                document.getElementById('form-eliminar-' + id).submit();
            }
        }

        // Función para previsualizar imágenes
        function previsualizarImagen(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result).show();
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html> 