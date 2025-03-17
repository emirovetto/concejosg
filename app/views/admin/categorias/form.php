<?php require_once VIEWS_PATH . '/admin/partials/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $action === 'guardar' ? 'Nueva Categoría' : 'Editar Categoría' ?></h1>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>/?section=categorias">Categorías</a></li>
            <li class="breadcrumb-item active"><?= $action === 'guardar' ? 'Nueva' : 'Editar' ?></li>
        </ol>
        <a href="<?= ADMIN_URL ?>/?section=categorias" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
    
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            <?= $action === 'guardar' ? 'Crear nueva categoría' : 'Modificar categoría existente' ?>
        </div>
        <div class="card-body">
            <form action="<?= ADMIN_URL ?>/?section=categorias&action=<?= $action ?>" method="post">
                <?php if ($action === 'actualizar'): ?>
                    <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
                    <div class="form-text">El nombre debe ser único y descriptivo.</div>
                </div>
                
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($categoria['descripcion']) ?></textarea>
                    <div class="form-text">Una breve descripción de la categoría (opcional).</div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="<?= ADMIN_URL ?>/?section=categorias" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> <?= $action === 'guardar' ? 'Crear Categoría' : 'Actualizar Categoría' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . '/admin/partials/footer.php'; ?> 