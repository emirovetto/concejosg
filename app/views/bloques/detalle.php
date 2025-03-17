<div class="container py-5">
    <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
            <?php if (!empty($bloque['logo'])): ?>
                <div class="text-center mb-4">
                    <img src="<?php echo SITE_URL; ?>/app/public/uploads/bloques/<?php echo $bloque['logo']; ?>" 
                         alt="<?php echo $bloque['nombre']; ?>" 
                         class="img-fluid" style="max-width: 200px;">
                </div>
            <?php endif; ?>
            
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: <?php echo $bloque['color'] ?? '#0056b3'; ?>; color: white;">
                    <h5 class="card-title mb-0"><?php echo $bloque['nombre']; ?></h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($bloque['descripcion'])): ?>
                        <p><?php echo nl2br($bloque['descripcion']); ?></p>
                    <?php else: ?>
                        <p class="text-muted">No hay descripción disponible.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <h2 class="border-bottom pb-2 mb-4">Concejales del Bloque</h2>
            
            <?php if (empty($concejales)): ?>
                <div class="alert alert-info">No hay concejales asignados a este bloque.</div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($concejales as $concejal): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <?php if (!empty($concejal['foto'])): ?>
                                            <img src="<?php echo SITE_URL; ?>/app/public/uploads/concejales/<?php echo $concejal['foto']; ?>" 
                                                 class="img-fluid rounded-start" alt="<?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?>"
                                                 style="height: 100%; object-fit: cover;">
                                        <?php else: ?>
                                            <img src="<?php echo SITE_URL; ?>/app/public/img/concejal-default.jpg" 
                                                 class="img-fluid rounded-start" alt="<?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?>"
                                                 style="height: 100%; object-fit: cover;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?></h5>
                                            <?php if (!empty($concejal['cargo'])): ?>
                                                <p class="card-text"><small class="text-muted"><?php echo $concejal['cargo']; ?></small></p>
                                            <?php endif; ?>
                                            <a href="<?php echo SITE_URL; ?>/?page=concejales&id=<?php echo $concejal['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">Ver perfil</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($noticias)): ?>
                <h2 class="border-bottom pb-2 mb-4 mt-5">Noticias del Bloque</h2>
                
                <div class="row">
                    <?php foreach ($noticias as $noticia): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <?php if (!empty($noticia['imagen'])): ?>
                                    <img src="<?php echo SITE_URL; ?>/app/public/uploads/noticias/<?php echo $noticia['imagen']; ?>" 
                                         class="card-img-top" alt="<?php echo $noticia['titulo']; ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $noticia['titulo']; ?></h5>
                                    <p class="text-muted small mb-2">
                                        <i class="far fa-calendar-alt me-1"></i> <?php echo format_date($noticia['fecha_publicacion']); ?>
                                    </p>
                                    <p class="card-text"><?php echo substr($noticia['resumen'], 0, 100); ?>...</p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="<?php echo SITE_URL; ?>/?page=noticias&id=<?php echo $noticia['id']; ?>" 
                                       class="btn btn-sm btn-primary">Leer más</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-end mt-3">
                    <a href="<?php echo SITE_URL; ?>/?page=noticias&bloque=<?php echo $bloque['id']; ?>" 
                       class="btn btn-outline-primary">Ver todas las noticias del bloque</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 