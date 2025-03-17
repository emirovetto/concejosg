<div class="container-fluid px-4 pt-4">
    <h1 class="page-title mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Panel de Control</li>
    </ol>
    
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><?= isset($noticias_count) ? $noticias_count : 0 ?></h4>
                            <div>Noticias</div>
                        </div>
                        <div>
                            <i class="fas fa-newspaper fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= ADMIN_URL ?>?section=noticias">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><?= isset($sesiones_count) ? $sesiones_count : 0 ?></h4>
                            <div>Sesiones</div>
                        </div>
                        <div>
                            <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= ADMIN_URL ?>?section=sesiones">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><?= isset($ordenanzas_count) ? $ordenanzas_count : 0 ?></h4>
                            <div>Ordenanzas</div>
                        </div>
                        <div>
                            <i class="fas fa-file-alt fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= ADMIN_URL ?>?section=ordenanzas">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><?= isset($concejales_count) ? $concejales_count : 0 ?></h4>
                            <div>Concejales</div>
                        </div>
                        <div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= ADMIN_URL ?>?section=concejales">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Información del Sistema
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Bienvenido al Panel de Administración</h5>
                            <p>Desde aquí podrá gestionar todo el contenido del sitio web del Concejo Deliberante de San Genaro.</p>
                            <p>Utilice el menú lateral para navegar entre las diferentes secciones.</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Estadísticas</h5>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Noticias
                                    <span class="badge bg-primary rounded-pill"><?= isset($noticias_count) ? $noticias_count : 0 ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Sesiones
                                    <span class="badge bg-success rounded-pill"><?= isset($sesiones_count) ? $sesiones_count : 0 ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Ordenanzas
                                    <span class="badge bg-warning rounded-pill"><?= isset($ordenanzas_count) ? $ordenanzas_count : 0 ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Concejales
                                    <span class="badge bg-danger rounded-pill"><?= isset($concejales_count) ? $concejales_count : 0 ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 