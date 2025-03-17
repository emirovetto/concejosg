<!-- Barra lateral -->
<div class="row">
    <div class="col-md-3 col-lg-2 px-0">
        <div class="sidebar">
            <div class="d-flex flex-column flex-shrink-0 p-3">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="<?php echo ADMIN_URL; ?>" class="nav-link <?php echo $section === 'dashboard' ? 'active' : ''; ?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo ADMIN_URL; ?>/?section=sesiones" class="nav-link <?php echo $section === 'sesiones' ? 'active' : ''; ?>">
                            <i class="fas fa-calendar-alt"></i> Sesiones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo ADMIN_URL; ?>/?section=ordenanzas" class="nav-link <?php echo $section === 'ordenanzas' ? 'active' : ''; ?>">
                            <i class="fas fa-file-alt"></i> Ordenanzas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo ADMIN_URL; ?>/?section=concejales" class="nav-link <?php echo $section === 'concejales' ? 'active' : ''; ?>">
                            <i class="fas fa-users"></i> Concejales
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo ADMIN_URL; ?>/?section=bloques" class="nav-link <?php echo $section === 'bloques' ? 'active' : ''; ?>">
                            <i class="fas fa-building"></i> Bloques
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo ADMIN_URL; ?>/?section=noticias" class="nav-link <?php echo $section === 'noticias' ? 'active' : ''; ?>">
                            <i class="fas fa-newspaper"></i> Noticias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo ADMIN_URL; ?>/?section=usuarios" class="nav-link <?php echo $section === 'usuarios' ? 'active' : ''; ?>">
                            <i class="fas fa-user-cog"></i> Usuarios
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Contenido principal -->
    <div class="col-md-9 col-lg-10">
        <div class="content">
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['flash_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
            <?php endif; ?> 