<div class="container py-5">
    <h1 class="mb-4">Sesiones del Concejo</h1>
    
    <!-- Filtros de búsqueda -->
    <div class="card shadow-sm mb-4 search-box">
        <div class="card-body">
            <form action="<?php echo SITE_URL; ?>/?page=sesiones" method="get">
                <input type="hidden" name="page" value="sesiones">
                <div class="row">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="year" class="form-label">Año</label>
                        <select class="form-select" id="year" name="year">
                            <option value="">Todos los años</option>
                            <?php if(isset($years)): ?>
                                <?php foreach ($years as $y): ?>
                                    <option value="<?php echo $y; ?>" <?php echo isset($year) && $year == $y ? 'selected' : ''; ?>>
                                        <?php echo $y; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">Todos los tipos</option>
                            <option value="ordinaria" <?php echo isset($tipo) && $tipo == 'ordinaria' ? 'selected' : ''; ?>>Ordinaria</option>
                            <option value="extraordinaria" <?php echo isset($tipo) && $tipo == 'extraordinaria' ? 'selected' : ''; ?>>Extraordinaria</option>
                            <option value="especial" <?php echo isset($tipo) && $tipo == 'especial' ? 'selected' : ''; ?>>Especial</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Título o descripción" value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Pestañas para filtrar por estado -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link <?php echo !isset($estado) || $estado == '' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/?page=sesiones">
                Todas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($estado) && $estado == 'programada' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/?page=sesiones&estado=programada">
                Próximas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($estado) && $estado == 'realizada' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/?page=sesiones&estado=realizada">
                Realizadas
            </a>
        </li>
    </ul>
    
    <!-- Listado de sesiones -->
    <?php if (empty($sesiones)): ?>
        <div class="alert alert-info">No se encontraron sesiones con los criterios seleccionados.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($sesiones as $sesion): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <span class="badge <?php echo $sesion['estado'] == 'programada' ? 'bg-primary' : ($sesion['estado'] == 'realizada' ? 'bg-success' : 'bg-danger'); ?> float-end">
                                <?php echo ucfirst($sesion['estado']); ?>
                            </span>
                            <h5 class="card-title mb-0"><?php echo $sesion['titulo']; ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                <i class="far fa-calendar-alt me-1"></i> <?php echo format_date($sesion['fecha']); ?>
                                <i class="far fa-clock ms-3 me-1"></i> <?php echo substr($sesion['hora'], 0, 5); ?> hs
                                <br>
                                <i class="fas fa-map-marker-alt me-1"></i> <?php echo $sesion['lugar']; ?>
                                <br>
                                <span class="badge bg-secondary"><?php echo ucfirst($sesion['tipo']); ?></span>
                            </p>
                            
                            <?php if (!empty($sesion['descripcion'])): ?>
                                <p class="card-text"><?php echo substr($sesion['descripcion'], 0, 150); ?>...</p>
                            <?php endif; ?>
                            
                            <div class="d-grid gap-2">
                                <a href="<?php echo SITE_URL; ?>/?page=sesiones&action=detalle&id=<?php echo $sesion['id']; ?>" class="btn btn-primary">
                                    Ver detalles
                                </a>
                                
                                <?php if (!empty($sesion['video_url']) && $sesion['estado'] == 'realizada'): ?>
                                    <a href="<?php echo $sesion['video_url']; ?>" class="btn btn-outline-primary" target="_blank">
                                        <i class="fas fa-video me-1"></i> Ver video
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($sesion['acta']) && $sesion['estado'] == 'realizada'): ?>
                                    <a href="<?php echo SITE_URL; ?>/app/public/uploads/sesiones/<?php echo $sesion['acta']; ?>" class="btn btn-outline-primary" target="_blank">
                                        <i class="fas fa-file-pdf me-1"></i> Descargar acta
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Paginación -->
        <?php if (isset($total_pages) && $total_pages > 1): ?>
            <nav aria-label="Navegación de páginas">
                <ul class="pagination justify-content-center">
                    <?php if (isset($current_page) && $current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo SITE_URL; ?>/?page=sesiones&p=<?php echo $current_page - 1; ?><?php echo isset($url_params) ? $url_params : ''; ?>">
                                Anterior
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link">Anterior</span>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo isset($current_page) && $i == $current_page ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo SITE_URL; ?>/?page=sesiones&p=<?php echo $i; ?><?php echo isset($url_params) ? $url_params : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if (isset($current_page) && isset($total_pages) && $current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo SITE_URL; ?>/?page=sesiones&p=<?php echo $current_page + 1; ?><?php echo isset($url_params) ? $url_params : ''; ?>">
                                Siguiente
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link">Siguiente</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div> 