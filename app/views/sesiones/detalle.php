<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <span class="badge <?php echo $sesion['estado'] == 'programada' ? 'bg-primary' : ($sesion['estado'] == 'realizada' ? 'bg-success' : 'bg-danger'); ?> float-end">
                        <?php echo ucfirst($sesion['estado']); ?>
                    </span>
                    <h2 class="mb-0"><?php echo $sesion['titulo']; ?></h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <p class="text-muted">
                            <strong>Fecha:</strong> <?php echo format_date($sesion['fecha']); ?>
                            <br>
                            <strong>Hora:</strong> <?php echo substr($sesion['hora'], 0, 5); ?> hs
                            <br>
                            <strong>Lugar:</strong> <?php echo $sesion['lugar']; ?>
                            <br>
                            <strong>Tipo:</strong> <span class="badge bg-secondary"><?php echo ucfirst($sesion['tipo']); ?></span>
                        </p>
                    </div>
                    
                    <?php if (!empty($sesion['descripcion'])): ?>
                        <div class="mb-4">
                            <h5>Descripción</h5>
                            <p><?php echo nl2br($sesion['descripcion']); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($sesion['video_url']) && $sesion['estado'] == 'realizada'): ?>
                        <div class="mb-4">
                            <h5>Video de la sesión</h5>
                            <div class="ratio ratio-16x9 video-container">
                                <?php
                                // Detectar si es un enlace de YouTube y obtener el ID del video
                                if (strpos($sesion['video_url'], 'youtube.com') !== false || strpos($sesion['video_url'], 'youtu.be') !== false) {
                                    $video_id = '';
                                    if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $sesion['video_url'], $match)) {
                                        $video_id = $match[1];
                                    } elseif (preg_match('/youtu\.be\/([^?]+)/', $sesion['video_url'], $match)) {
                                        $video_id = $match[1];
                                    }
                                    
                                    if (!empty($video_id)) {
                                        echo '<iframe src="https://www.youtube.com/embed/' . $video_id . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                    } else {
                                        echo '<a href="' . $sesion['video_url'] . '" class="btn btn-primary" target="_blank">Ver video</a>';
                                    }
                                } else {
                                    echo '<a href="' . $sesion['video_url'] . '" class="btn btn-primary" target="_blank">Ver video</a>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($sesion['acta']) && $sesion['estado'] == 'realizada'): ?>
                        <div class="mb-4">
                            <h5>Acta de la sesión</h5>
                            <a href="<?php echo SITE_URL; ?>/app/public/uploads/sesiones/<?php echo $sesion['acta']; ?>" class="btn btn-primary" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i> Descargar acta
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (!empty($proyectos)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Proyectos tratados</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($proyectos as $proyecto): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><?php echo $proyecto['titulo']; ?></h5>
                                        <small>
                                            <span class="badge <?php 
                                                echo $proyecto['estado'] == 'aprobado' ? 'bg-success' : 
                                                    ($proyecto['estado'] == 'rechazado' ? 'bg-danger' : 
                                                        ($proyecto['estado'] == 'en_comision' ? 'bg-warning' : 'bg-info')); 
                                            ?>">
                                                <?php echo ucfirst(str_replace('_', ' ', $proyecto['estado'])); ?>
                                            </span>
                                        </small>
                                    </div>
                                    <p class="mb-1"><?php echo substr($proyecto['descripcion'], 0, 200); ?>...</p>
                                    <small>
                                        Presentado por: <?php echo $proyecto['bloque_nombre']; ?> - 
                                        <?php echo format_date($proyecto['fecha_presentacion']); ?>
                                    </small>
                                    <?php if (!empty($proyecto['archivo'])): ?>
                                        <div class="mt-2">
                                            <a href="<?php echo SITE_URL; ?>/app/public/uploads/proyectos/<?php echo $proyecto['archivo']; ?>" 
                                               class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-file-pdf me-1"></i> Ver documento
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-lg-4">
            <?php if (!empty($proximas_sesiones)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Próximas sesiones</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($proximas_sesiones as $proxima): ?>
                            <div class="mb-3 pb-3 border-bottom">
                                <h6><a href="<?php echo SITE_URL; ?>/?page=sesiones&id=<?php echo $proxima['id']; ?>"><?php echo $proxima['titulo']; ?></a></h6>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-calendar-alt me-1"></i> <?php echo format_date($proxima['fecha']); ?>
                                    <br>
                                    <i class="far fa-clock me-1"></i> <?php echo substr($proxima['hora'], 0, 5); ?> hs
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($ultimas_sesiones)): ?>
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Últimas sesiones</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($ultimas_sesiones as $ultima): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?php echo $ultima['titulo']; ?></h6>
                                        <small><?php echo format_date($ultima['fecha']); ?></small>
                                    </div>
                                    <small><?php echo substr($ultima['descripcion'], 0, 100); ?>...</small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 