<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="page-title"><?php echo $action == 'guardar' ? 'Nuevo Concejal' : 'Editar Concejal'; ?></h1>
            <p class="text-muted"><?php echo $action == 'guardar' ? 'Complete el formulario para crear un nuevo concejal' : 'Modifique los datos del concejal'; ?></p>
        </div>
        <div class="col-auto">
            <a href="<?php echo ADMIN_URL; ?>/?section=concejales" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?php echo ADMIN_URL; ?>/?section=concejales&action=<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <?php if ($action == 'actualizar'): ?>
                <input type="hidden" name="id" value="<?php echo $concejal['id']; ?>">
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $concejal['nombre']; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $concejal['apellido']; ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="cargo" class="form-label">Cargo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cargo" name="cargo" value="<?php echo $concejal['cargo']; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="bloque_id" class="form-label">Bloque <span class="text-danger">*</span></label>
                        <select class="form-select" id="bloque_id" name="bloque_id" required>
                            <option value="">Seleccione un bloque</option>
                            <?php foreach ($bloques as $bloque): ?>
                                <option value="<?php echo $bloque['id']; ?>" <?php echo $concejal['bloque_id'] == $bloque['id'] ? 'selected' : ''; ?>>
                                    <?php echo $bloque['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $concejal['email']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $concejal['telefono']; ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="biografia" class="form-label">Biografía</label>
                <textarea class="form-control summernote" id="biografia" name="biografia" rows="5"><?php echo $concejal['biografia']; ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB.</small>
                        
                        <?php if (!empty($concejal['foto'])): ?>
                            <div class="mt-2">
                                <img src="<?php echo SITE_URL; ?>/app/public/uploads/concejales/<?php echo $concejal['foto']; ?>" alt="Foto actual" class="img-thumbnail" width="100">
                                <p class="form-text">Foto actual. Suba una nueva imagen para reemplazarla.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="activo" <?php echo $concejal['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                            <option value="inactivo" <?php echo $concejal['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="redes" class="form-label">Redes Sociales (formato JSON)</label>
                <textarea class="form-control" id="redes" name="redes" rows="3"><?php echo $concejal['redes']; ?></textarea>
                <small class="form-text text-muted">Ejemplo: {"facebook": "https://facebook.com/usuario", "twitter": "https://twitter.com/usuario"}</small>
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                <a href="<?php echo ADMIN_URL; ?>/?section=concejales" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary"><?php echo $action == 'guardar' ? 'Crear Concejal' : 'Actualizar Concejal'; ?></button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar Summernote
        if (document.querySelector('.summernote')) {
            $('.summernote').summernote({
                height: 200,
                lang: 'es-ES',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }
    });
</script> 