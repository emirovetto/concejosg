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
        <!-- Main content will be included here -->
    </main>
</div> 