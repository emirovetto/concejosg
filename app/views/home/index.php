<!-- Banner principal -->
<div class="container-fluid px-0 mb-5">
    <div id="carouselMain" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo SITE_URL; ?>/app/public/img/banner1.jpg" class="d-block w-100" alt="Concejo Deliberante">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Concejo Deliberante de San Genaro</h2>
                    <p>Trabajando por el bienestar de nuestra comunidad</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo SITE_URL; ?>/app/public/img/banner2.jpg" class="d-block w-100" alt="Sesiones">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Sesiones Transparentes</h2>
                    <p>Accede a todas nuestras sesiones en video</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo SITE_URL; ?>/app/public/img/banner3.jpg" class="d-block w-100" alt="Ordenanzas">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Ordenanzas Municipales</h2>
                    <p>Consulta todas las ordenanzas vigentes</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMain" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselMain" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</div>

<!-- Accesos directos -->
<div class="container mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="fas fa-video fa-4x text-primary mb-3"></i>
                    <h3 class="card-title">Sesiones</h3>
                    <p class="card-text">Accede a todas las sesiones del Concejo Deliberante, con videos y actas.</p>
                    <a href="<?php echo SITE_URL; ?>/?page=sesiones" class="btn btn-outline-primary">Ver sesiones</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="fas fa-file-alt fa-4x text-primary mb-3"></i>
                    <h3 class="card-title">Ordenanzas</h3>
                    <p class="card-text">Consulta todas las ordenanzas municipales vigentes y su historial.</p>
                    <a href="<?php echo SITE_URL; ?>/?page=ordenanzas" class="btn btn-outline-primary">Ver ordenanzas</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="fas fa-users fa-4x text-primary mb-3"></i>
                    <h3 class="card-title">Concejales</h3>
                    <p class="card-text">Conoce a los concejales que representan a nuestra comunidad.</p>
                    <a href="<?php echo SITE_URL; ?>/?page=concejales" class="btn btn-outline-primary">Ver concejales</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Últimas noticias y próximas sesiones -->
<div class="container mb-5">
    <div class="row">
        <!-- Últimas noticias -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <h2 class="border-bottom pb-2 mb-4">Últimas Noticias</h2>
            
            <?php if (empty($noticias)): ?>
                <div class="alert alert-info">No hay noticias disponibles en este momento.</div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($noticias as $noticia): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="<?php echo SITE_URL; ?>/app/public/uploads/noticias/<?php echo $noticia['imagen']; ?>" class="card-img-top" alt="<?php echo $noticia['titulo']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $noticia['titulo']; ?></h5>
                                    <p class="text-muted small mb-2">
                                        <i class="far fa-calendar-alt me-1"></i> <?php echo format_date($noticia['fecha_publicacion']); ?>
                                    </p>
                                    <p class="card-text"><?php echo substr($noticia['resumen'], 0, 100); ?>...</p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="<?php echo SITE_URL; ?>/?page=noticias&id=<?php echo $noticia['id']; ?>" class="btn btn-sm btn-primary">Leer más</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-end mt-3">
                    <a href="<?php echo SITE_URL; ?>/?page=noticias" class="btn btn-outline-primary">Ver todas las noticias</a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Próximas sesiones -->
        <div class="col-lg-4">
            <h2 class="border-bottom pb-2 mb-4">Próximas Sesiones</h2>
            
            <?php if (empty($sesiones)): ?>
                <div class="alert alert-info">No hay sesiones programadas en este momento.</div>
            <?php else: ?>
                <?php foreach ($sesiones as $sesion): ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $sesion['titulo']; ?></h5>
                            <p class="text-muted mb-2">
                                <i class="far fa-calendar-alt me-1"></i> <?php echo format_date($sesion['fecha']); ?>
                                <i class="far fa-clock ms-3 me-1"></i> <?php echo substr($sesion['hora'], 0, 5); ?> hs
                            </p>
                            <p class="card-text"><?php echo $sesion['descripcion']; ?></p>
                            <a href="<?php echo SITE_URL; ?>/?page=sesiones&id=<?php echo $sesion['id']; ?>" class="btn btn-sm btn-primary">Más información</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="text-end mt-3">
                    <a href="<?php echo SITE_URL; ?>/?page=sesiones" class="btn btn-outline-primary">Ver todas las sesiones</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Estadísticas -->
<div class="bg-light py-5 mb-5">
    <div class="container">
        <h2 class="text-center mb-5">El Concejo en Números</h2>
        <div class="row text-center">
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="display-4 fw-bold text-primary mb-2">150+</div>
                <h5>Ordenanzas Aprobadas</h5>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="display-4 fw-bold text-primary mb-2">50+</div>
                <h5>Sesiones Realizadas</h5>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="display-4 fw-bold text-primary mb-2">12</div>
                <h5>Concejales</h5>
            </div>
            <div class="col-md-3">
                <div class="display-4 fw-bold text-primary mb-2">4</div>
                <h5>Bloques Políticos</h5>
            </div>
        </div>
    </div>
</div> 