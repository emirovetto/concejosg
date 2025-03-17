<div class="container py-5">
    <h1 class="mb-4">Ordenanzas</h1>
    
    <!-- Filtros de búsqueda -->
    <div class="card shadow-sm mb-4 search-box">
        <div class="card-body">
            <form action="<?php echo SITE_URL; ?>/?page=ordenanzas" method="get" id="ordenanzasFilter">
                <input type="hidden" name="page" value="ordenanzas">
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
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Todas las categorías</option>
                            <?php if(isset($categorias)): ?>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo isset($categoria_id) && $categoria_id == $cat['id'] ? 'selected' : ''; ?>>
                                        <?php echo $cat['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Número, título o contenido" value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Listado de ordenanzas -->
    <div id="ordenanzasList">
        <?php if (empty($ordenanzas)): ?>
            <div class="alert alert-info">No se encontraron ordenanzas con los criterios seleccionados.</div>
        <?php else: ?>
            <?php foreach ($ordenanzas as $ordenanza): ?>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Ordenanza N° <?php echo $ordenanza['numero']; ?>/<?php echo $ordenanza['anio']; ?></h5>
                        <p class="text-muted mb-2">
                            <i class="far fa-calendar-alt me-1"></i> <?php echo format_date($ordenanza['fecha_sancion']); ?>
                            <?php if (!empty($ordenanza['categoria_nombre'])): ?>
                                <span class="badge bg-primary ms-2"><?php echo $ordenanza['categoria_nombre']; ?></span>
                            <?php endif; ?>
                        </p>
                        <p class="card-text"><?php echo $ordenanza['descripcion']; ?></p>
                        <a href="<?php echo SITE_URL; ?>/?page=ordenanzas&action=detalle&id=<?php echo $ordenanza['id']; ?>" class="btn btn-sm btn-primary">Ver detalles</a>
                        <?php if (!empty($ordenanza['archivo'])): ?>
                            <a href="<?php echo SITE_URL; ?>/app/public/uploads/ordenanzas/<?php echo $ordenanza['archivo']; ?>" 
                               class="btn btn-sm btn-outline-primary ms-2" target="_blank">
                                <i class="fas fa-file-pdf me-1"></i> Descargar PDF
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <!-- Paginación -->
            <?php if (isset($total_pages) && $total_pages > 1): ?>
                <nav aria-label="Navegación de páginas">
                    <ul class="pagination justify-content-center">
                        <?php if (isset($current_page) && $current_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo SITE_URL; ?>/?page=ordenanzas&p=<?php echo $current_page - 1; ?><?php echo isset($url_params) ? $url_params : ''; ?>">
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
                                <a class="page-link" href="<?php echo SITE_URL; ?>/?page=ordenanzas&p=<?php echo $i; ?><?php echo isset($url_params) ? $url_params : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if (isset($current_page) && isset($total_pages) && $current_page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo SITE_URL; ?>/?page=ordenanzas&p=<?php echo $current_page + 1; ?><?php echo isset($url_params) ? $url_params : ''; ?>">
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
</div> 