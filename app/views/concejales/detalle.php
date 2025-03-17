<div class="container py-5">
    <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card shadow-sm text-center">
                <?php if (!empty($concejal['foto'])): ?>
                    <img src="<?php echo SITE_URL; ?>/app/public/uploads/concejales/<?php echo $concejal['foto']; ?>" 
                         alt="<?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?>" 
                         class="card-img-top p-3" style="max-height: 300px; object-fit: contain;">
                <?php else: ?>
                    <img src="<?php echo SITE_URL; ?>/app/public/img/concejal-default.jpg" 
                         alt="<?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?>" 
                         class="card-img-top p-3" style="max-height: 300px; object-fit: contain;">
                <?php endif; ?>
                
                <div class="card-body">
                    <h3 class="card-title"><?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?></h3>
                    
                    <?php if (!empty($concejal['cargo'])): ?>
                        <p class="text-muted mb-3"><?php echo $concejal['cargo']; ?></p>
                    <?php endif; ?>
                    
                    <?php if (isset($bloque)): ?>
                        <div class="mb-3">
                            <span class="badge mb-2" style="background-color: <?php echo $bloque['color'] ?? '#0056b3'; ?>;">
                                <?php echo $bloque['nombre']; ?>
                            </span>
                            <br>
                            <a href="<?php echo SITE_URL; ?>/?page=bloques&id=<?php echo $bloque['id']; ?>" 
                               class="btn btn-sm btn-outline-primary">Ver bloque</a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="d-grid gap-2">
                        <?php if (!empty($concejal['email'])): ?>
                            <a href="mailto:<?php echo $concejal['email']; ?>" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-2"></i> Contactar por email
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($concejal['telefono'])): ?>
                            <a href="tel:<?php echo $concejal['telefono']; ?>" class="btn btn-outline-primary">
                                <i class="fas fa-phone me-2"></i> Llamar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card-footer text-muted">
                    <small>Período: <?php echo format_date($concejal['periodo_inicio'], 'd/m/Y'); ?> - 
                    <?php echo !empty($concejal['periodo_fin']) ? format_date($concejal['periodo_fin'], 'd/m/Y') : 'Actualidad'; ?></small>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Biografía</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($concejal['biografia'])): ?>
                        <div class="biografia">
                            <?php echo nl2br($concejal['biografia']); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No hay información biográfica disponible.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 