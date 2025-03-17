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
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><?= isset($total_noticias) ? $total_noticias : 0 ?></h4>
                            <div>Noticias</div>
                        </div>
                        <div>
                            <i class="fas fa-newspaper fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= ADMIN_URL ?>/?section=noticias">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><?= isset($total_sesiones) ? $total_sesiones : 0 ?></h4>
                            <div>Sesiones</div>
                        </div>
                        <div>
                            <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= ADMIN_URL ?>/?section=sesiones">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><?= isset($total_ordenanzas) ? $total_ordenanzas : 0 ?></h4>
                            <div>Ordenanzas</div>
                        </div>
                        <div>
                            <i class="fas fa-file-alt fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= ADMIN_URL ?>/?section=ordenanzas">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><?= isset($total_concejales) ? $total_concejales : 0 ?></h4>
                            <div>Concejales</div>
                        </div>
                        <div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= ADMIN_URL ?>/?section=concejales">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-newspaper me-1"></i>
                    Últimas Noticias
                </div>
                <div class="card-body">
                    <?php if (empty($ultimas_noticias)): ?>
                        <p class="text-muted">No hay noticias registradas.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ultimas_noticias as $noticia): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($noticia['titulo']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($noticia['fecha_publicacion'])) ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?= ADMIN_URL ?>/?section=noticias&action=editar&id=<?= $noticia['id'] ?>" class="btn btn-primary btn-sm btn-action" title="Editar" data-bs-toggle="tooltip">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL ?>/noticias/<?= $noticia['slug'] ?>" class="btn btn-info btn-sm btn-action" title="Ver en sitio" target="_blank" data-bs-toggle="tooltip">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <a href="<?= ADMIN_URL ?>/?section=noticias" class="btn btn-primary">Ver Todas</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Próximas Sesiones
                </div>
                <div class="card-body">
                    <?php if (empty($proximas_sesiones)): ?>
                        <p class="text-muted">No hay sesiones programadas próximamente.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($proximas_sesiones as $sesion): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($sesion['titulo']) ?></td>
                                            <td>
                                                <?= date('d/m/Y', strtotime($sesion['fecha'])) ?>
                                                <br>
                                                <small><?= date('H:i', strtotime($sesion['hora'])) ?> hs</small>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?= ADMIN_URL ?>/?section=sesiones&action=editar&id=<?= $sesion['id'] ?>" class="btn btn-primary btn-sm btn-action" title="Editar" data-bs-toggle="tooltip">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL ?>/sesiones/<?= $sesion['id'] ?>" class="btn btn-info btn-sm btn-action" title="Ver en sitio" target="_blank" data-bs-toggle="tooltip">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <a href="<?= ADMIN_URL ?>/?section=sesiones" class="btn btn-primary">Ver Todas</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 