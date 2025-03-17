<?php require_once VIEWS_PATH . '/admin/partials/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $accion == 'crear' ? 'Nueva Ordenanza' : 'Editar Ordenanza' ?></h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Formulario de Ordenanza
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>admin/ordenanzas/<?= $accion == 'crear' ? 'guardar' : 'actualizar' ?>" method="post" enctype="multipart/form-data">
                <?php if ($accion == 'editar'): ?>
                    <input type="hidden" name="id" value="<?= $ordenanza['id'] ?>">
                <?php endif; ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="numero" class="form-label">Número <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="numero" name="numero" value="<?= isset($ordenanza['numero']) ? htmlspecialchars($ordenanza['numero']) : '' ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="anio" class="form-label">Año <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="anio" name="anio" value="<?= isset($ordenanza['anio']) ? htmlspecialchars($ordenanza['anio']) : date('Y') ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?= isset($ordenanza['titulo']) ? htmlspecialchars($ordenanza['titulo']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required><?= isset($ordenanza['descripcion']) ? htmlspecialchars($ordenanza['descripcion']) : '' ?></textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fecha_sancion" class="form-label">Fecha de Sanción <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="fecha_sancion" name="fecha_sancion" value="<?= isset($ordenanza['fecha_sancion']) ? $ordenanza['fecha_sancion'] : date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                        <select class="form-select" id="categoria_id" name="categoria_id" required>
                            <option value="">Seleccione una categoría</option>
                            <?php foreach ($categorias as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= (isset($ordenanza['categoria_id']) && $ordenanza['categoria_id'] == $id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="archivo" class="form-label">Documento PDF <?= $accion == 'crear' ? '<span class="text-danger">*</span>' : '' ?></label>
                    <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf" <?= $accion == 'crear' ? 'required' : '' ?>>
                    <?php if ($accion == 'editar' && !empty($ordenanza['archivo'])): ?>
                        <div class="form-text">
                            Documento actual: <a href="<?= BASE_URL ?>uploads/ordenanzas/<?= $ordenanza['archivo'] ?>" target="_blank"><?= $ordenanza['archivo'] ?></a>
                            <p class="text-muted">Suba un nuevo archivo solo si desea reemplazar el actual.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="<?= BASE_URL ?>admin/ordenanzas" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary"><?= $accion == 'crear' ? 'Crear Ordenanza' : 'Actualizar Ordenanza' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/admin/partials/footer.php'; ?> 