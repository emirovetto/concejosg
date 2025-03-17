<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-4">Noticias</h1>
            
            <?php if (!empty($categoria)): ?>
                <div class="alert alert-info mb-4">
                    Mostrando noticias de la categoría: <strong><?php echo $categoria['nombre']; ?></strong>
                    <a href="<?php echo SITE_URL; ?>/?page=noticias" class="float-end">Ver todas</a>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($bloque)): ?>
                <div class="alert alert-info mb-4">
                    Mostrando noticias del bloque: <strong><?php echo $bloque['nombre']; ?></strong>
                    <a href="<?php echo SITE_URL; ?>/?page=noticias" class="float-end">Ver todas</a>
                </div>
            <?php endif; ?>
            
            <?php if (empty($noticias)): ?>
                <div class="alert alert-info">No hay noticias disponibles en este momento.</div>
            <?php else: ?>
                <?php foreach ($noticias as $noticia): ?>
                    <div class="card mb-4 shadow-sm">
                        <div class="row g-0">
                            <?php if (!empty($noticia['imagen'])): ?>
                                <div class="col-md-4">
                                    <img src="<?php echo SITE_URL; ?>/app/public/uploads/noticias/<?php echo $noticia['imagen']; ?>" 
                                         class="img-fluid rounded-start" alt="<?php echo $noticia['titulo']; ?>"
                                         style="height: 100%; object-fit: cover;">
                                </div>
                                <div class="col-md-8">
                            <?php else: ?>
                                <div class="col-12">
                            <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $noticia['titulo']; ?></h5>
                                    <p class="text-muted small mb-2">
                                        <i class="far fa-calendar-alt me-1"></i> <?php echo format_date($noticia['fecha_publicacion']); ?>
                                        <?php if (isset($noticia['categoria_nombre'])): ?>
                                            <span class="badge bg-primary ms-2"><?php echo $noticia['categoria_nombre']; ?></span>
                                        <?php endif; ?>
                                        <?php if (isset($noticia['bloque_nombre'])): ?>
                                            <span class="badge ms-2" style="background-color: <?php echo $noticia['bloque_color'] ?? '#0056b3'; ?>;">
                                                <?php echo $noticia['bloque_nombre']; ?>
                                            </span>
                                        <?php endif; ?>
                                    </p>
                                    <p class="card-text"><?php echo $noticia['resumen']; ?></p>
                                    <a href="<?php echo SITE_URL; ?>/?page=noticias&action=detalle&id=<?php echo $noticia['id']; ?>" 
                                       class="btn btn-primary">Leer más</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <!-- Paginación -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Navegación de páginas">
                        <ul class="pagination justify-content-center">
                            <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo SITE_URL; ?>/?page=noticias&p=<?php echo $current_page - 1; ?><?php echo $url_params; ?>">
                                        Anterior
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link">Anterior</span>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?php echo SITE_URL; ?>/?page=noticias&p=<?php echo $i; ?><?php echo $url_params; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($current_page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo SITE_URL; ?>/?page=noticias&p=<?php echo $current_page + 1; ?><?php echo $url_params; ?>">
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
        
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Buscar noticias</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo SITE_URL; ?>/?page=noticias" method="get">
                        <input type="hidden" name="page" value="noticias">
                        <div class="mb-3">
                            <label for="search" class="form-label">Palabra clave</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php if (!empty($categorias)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Categorías</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($categorias as $cat): ?>
                                <a href="<?php echo SITE_URL; ?>/?page=noticias&categoria=<?php echo $cat['id']; ?>" 
                                   class="list-group-item list-group-item-action <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id']) ? 'active' : ''; ?>">
                                    <?php echo $cat['nombre']; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($bloques_sidebar)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Bloques políticos</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($bloques_sidebar as $blq): ?>
                                <a href="<?php echo SITE_URL; ?>/?page=noticias&bloque=<?php echo $blq['id']; ?>" 
                                   class="list-group-item list-group-item-action <?php echo (isset($_GET['bloque']) && $_GET['bloque'] == $blq['id']) ? 'active' : ''; ?>">
                                    <?php echo $blq['nombre']; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($noticias_destacadas)): ?>
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Noticias destacadas</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($noticias_destacadas as $destacada): ?>
                            <div class="mb-3 pb-3 border-bottom">
                                <h6><a href="<?php echo SITE_URL; ?>/?page=noticias&id=<?php echo $destacada['id']; ?>"><?php echo $destacada['titulo']; ?></a></h6>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-calendar-alt me-1"></i> <?php echo format_date($destacada['fecha_publicacion']); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 