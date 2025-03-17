<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h2 class="mb-0">Ordenanza N° <?php echo $ordenanza['numero']; ?>/<?php echo $ordenanza['anio']; ?></h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <p class="text-muted">
                            <strong>Fecha de sanción:</strong> <?php echo format_date($ordenanza['fecha_sancion']); ?>
                            <?php if (!empty($ordenanza['fecha_promulgacion'])): ?>
                                <br><strong>Fecha de promulgación:</strong> <?php echo format_date($ordenanza['fecha_promulgacion']); ?>
                            <?php endif; ?>
                            <?php if (!empty($categoria)): ?>
                                <br><strong>Categoría:</strong> <?php echo $categoria['nombre']; ?>
                            <?php endif; ?>
                            <br><strong>Estado:</strong> 
                            <span class="badge <?php echo $ordenanza['estado'] == 'vigente' ? 'bg-success' : ($ordenanza['estado'] == 'derogada' ? 'bg-danger' : 'bg-warning'); ?>">
                                <?php echo ucfirst($ordenanza['estado']); ?>
                            </span>
                        </p>
                    </div>
                    
                    <?php if (!empty($ordenanza['titulo'])): ?>
                        <h4 class="mb-3"><?php echo $ordenanza['titulo']; ?></h4>
                    <?php endif; ?>
                    
                    <?php if (!empty($ordenanza['descripcion'])): ?>
                        <div class="mb-4">
                            <h5>Descripción</h5>
                            <p><?php echo nl2br($ordenanza['descripcion']); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($ordenanza['contenido'])): ?>
                        <div class="mb-4">
                            <h5>Contenido</h5>
                            <div class="ordenanza-contenido">
                                <?php echo nl2br($ordenanza['contenido']); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($ordenanza['archivo'])): ?>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a href="<?php echo SITE_URL; ?>/app/public/uploads/ordenanzas/<?php echo $ordenanza['archivo']; ?>" 
                               class="btn btn-primary" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i> Descargar PDF
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (isset($ordenanza['estado']) && $ordenanza['estado'] == 'modificada' && !empty($ordenanza['ordenanza_modificada_id'])): ?>
                <div class="alert alert-warning">
                    <p><strong>Nota:</strong> Esta ordenanza modifica la 
                        <a href="<?php echo SITE_URL; ?>/?page=ordenanzas&id=<?php echo $ordenanza['ordenanza_modificada_id']; ?>">
                            Ordenanza N° <?php echo isset($ordenanza_modificada) ? $ordenanza_modificada['numero'] : ''; ?>/<?php echo isset($ordenanza_modificada) ? $ordenanza_modificada['anio'] : ''; ?>
                        </a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-lg-4">
            <?php if (!empty($relacionadas)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Ordenanzas relacionadas</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($relacionadas as $rel): ?>
                                <a href="<?php echo SITE_URL; ?>/?page=ordenanzas&id=<?php echo $rel['id']; ?>" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">N° <?php echo $rel['numero']; ?>/<?php echo $rel['anio']; ?></h6>
                                        <small><?php echo format_date($rel['fecha_sancion'], 'd/m/Y'); ?></small>
                                    </div>
                                    <small><?php echo substr($rel['descripcion'], 0, 100); ?>...</small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Buscar ordenanzas</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo SITE_URL; ?>/?page=ordenanzas" method="get">
                        <input type="hidden" name="page" value="ordenanzas">
                        <div class="mb-3">
                            <label for="search_sidebar" class="form-label">Palabra clave</label>
                            <input type="text" class="form-control" id="search_sidebar" name="search" placeholder="Número, título o contenido">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 