<div class="container py-5">
    <h1 class="mb-4">Concejales</h1>
    
    <!-- Filtros de búsqueda -->
    <div class="card shadow-sm mb-4 search-box">
        <div class="card-body">
            <form action="<?php echo SITE_URL; ?>/?page=concejales" method="get">
                <input type="hidden" name="page" value="concejales">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="bloque" class="form-label">Bloque</label>
                        <select class="form-select" id="bloque" name="bloque">
                            <option value="">Todos los bloques</option>
                            <?php foreach ($bloques as $bloque): ?>
                                <option value="<?php echo $bloque['id']; ?>" <?php echo isset($bloque_id) && $bloque_id == $bloque['id'] ? 'selected' : ''; ?>>
                                    <?php echo $bloque['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Nombre, apellido o cargo" value="<?php echo isset($search) ? $search : ''; ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Lista de concejales -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if (empty($concejales)): ?>
            <div class="col-12">
                <div class="alert alert-info">No se encontraron concejales con los criterios seleccionados.</div>
            </div>
        <?php else: ?>
            <?php foreach ($concejales as $concejal): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($concejal['foto'])): ?>
                            <img src="<?php echo SITE_URL; ?>/app/public/uploads/concejales/<?php echo $concejal['foto']; ?>" 
                                 class="card-img-top" alt="<?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?>">
                        <?php else: ?>
                            <img src="<?php echo SITE_URL; ?>/app/public/img/concejal-placeholder.jpg" 
                                 class="card-img-top" alt="<?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?>">
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?></h5>
                            <p class="card-text">
                                <strong>Cargo:</strong> <?php echo $concejal['cargo']; ?>
                                <br>
                                <strong>Bloque:</strong> <?php echo $bloques[$concejal['bloque_id']]['nombre']; ?>
                            </p>
                            <a href="<?php echo SITE_URL; ?>/?page=concejales&action=detalle&id=<?php echo $concejal['id']; ?>" class="btn btn-primary">Ver perfil</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div> 