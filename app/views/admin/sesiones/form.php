<div class="container-fluid px-4 pt-4">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title"><?= $action === 'crear' ? 'Nueva Sesión' : 'Editar Sesión' ?></h1>
            </div>
            <div class="col-auto">
                <a href="<?= ADMIN_URL ?>/?section=sesiones" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <i class="fas fa-calendar-alt me-1"></i>
            <?= $action === 'crear' ? 'Crear nueva sesión' : 'Actualizar datos de sesión' ?>
        </div>
        <div class="card-body">
            <form action="<?= ADMIN_URL ?>/?section=sesiones&action=<?= $action === 'crear' ? 'guardar' : 'actualizar' ?>" method="post" enctype="multipart/form-data">
                <?php if (isset($sesion['id'])): ?>
                    <input type="hidden" name="id" value="<?= $sesion['id'] ?>">
                <?php endif; ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titulo" class="form-label required">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= isset($sesion['titulo']) ? htmlspecialchars($sesion['titulo']) : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo" class="form-label required">Tipo de Sesión</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="ordinaria" <?= (isset($sesion['tipo']) && $sesion['tipo'] === 'ordinaria') ? 'selected' : '' ?>>Ordinaria</option>
                                <option value="extraordinaria" <?= (isset($sesion['tipo']) && $sesion['tipo'] === 'extraordinaria') ? 'selected' : '' ?>>Extraordinaria</option>
                                <option value="especial" <?= (isset($sesion['tipo']) && $sesion['tipo'] === 'especial') ? 'selected' : '' ?>>Especial</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha" class="form-label required">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" value="<?= isset($sesion['fecha']) ? $sesion['fecha'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hora" class="form-label required">Hora</label>
                            <input type="time" class="form-control" id="hora" name="hora" value="<?= isset($sesion['hora']) ? $sesion['hora'] : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lugar" class="form-label required">Lugar</label>
                            <input type="text" class="form-control" id="lugar" name="lugar" value="<?= isset($sesion['lugar']) ? htmlspecialchars($sesion['lugar']) : '' ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado" class="form-label required">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="programada" <?= (isset($sesion['estado']) && $sesion['estado'] === 'programada') ? 'selected' : '' ?>>Programada</option>
                                <option value="realizada" <?= (isset($sesion['estado']) && $sesion['estado'] === 'realizada') ? 'selected' : '' ?>>Realizada</option>
                                <option value="cancelada" <?= (isset($sesion['estado']) && $sesion['estado'] === 'cancelada') ? 'selected' : '' ?>>Cancelada</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="url_video" class="form-label">URL del Video</label>
                            <input type="url" class="form-control" id="url_video" name="url_video" value="<?= isset($sesion['url_video']) ? $sesion['url_video'] : '' ?>" placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control summernote" id="descripcion" name="descripcion" rows="6"><?= isset($sesion['descripcion']) ? $sesion['descripcion'] : '' ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="acta" class="form-label">Acta (PDF)</label>
                            <input type="file" class="form-control" id="acta" name="acta" accept=".pdf">
                            <?php if (isset($sesion['acta']) && !empty($sesion['acta'])): ?>
                                <div class="mt-2">
                                    <span class="badge bg-info">Acta actual: <?= $sesion['acta'] ?></span>
                                    <a href="<?= SITE_URL ?>/app/public/uploads/sesiones/<?= $sesion['acta'] ?>" target="_blank" class="btn btn-sm btn-outline-info ms-2">
                                        <i class="fas fa-eye"></i> Ver documento
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <a href="<?= ADMIN_URL ?>/?section=sesiones" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <?= $action === 'crear' ? 'Crear Sesión' : 'Actualizar Sesión' ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 