<div class="container py-5">
    <h1 class="mb-4">Bloques Políticos</h1>
    
    <div class="row">
        <?php if (empty($bloques)): ?>
            <div class="col-12">
                <div class="alert alert-info">No hay bloques políticos disponibles en este momento.</div>
            </div>
        <?php else: ?>
            <?php foreach ($bloques as $bloque): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($bloque['logo'])): ?>
                            <div class="text-center pt-4">
                                <img src="<?php echo SITE_URL; ?>/app/public/uploads/bloques/<?php echo $bloque['logo']; ?>" 
                                     alt="<?php echo $bloque['nombre']; ?>" 
                                     class="img-fluid" style="max-height: 120px;">
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $bloque['nombre']; ?></h5>
                            <div class="card-text">
                                <?php if (!empty($bloque['descripcion'])): ?>
                                    <p><?php echo substr($bloque['descripcion'], 0, 150); ?>...</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="<?php echo SITE_URL; ?>/?page=bloques&action=detalle&id=<?php echo $bloque['id']; ?>" 
                               class="btn btn-primary">Ver detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div> 