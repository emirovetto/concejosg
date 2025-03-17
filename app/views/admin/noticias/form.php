<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $action === 'guardar' ? 'Nueva Noticia' : 'Editar Noticia' ?></h1>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>/?section=noticias">Noticias</a></li>
            <li class="breadcrumb-item active"><?= $action === 'guardar' ? 'Nueva' : 'Editar' ?></li>
        </ol>
        <a href="<?= ADMIN_URL ?>/?section=noticias" class="btn btn-outline-secondary">
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
            <?= $action === 'guardar' ? 'Crear nueva noticia' : 'Modificar noticia existente' ?>
        </div>
        <div class="card-body">
            <form action="<?= ADMIN_URL ?>/?section=noticias&action=<?= $action ?>" method="post" enctype="multipart/form-data">
                <?php if ($action === 'actualizar'): ?>
                    <input type="hidden" name="id" value="<?= $noticia['id'] ?>">
                <?php endif; ?>
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($noticia['titulo']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contenido" class="form-label">Contenido <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="contenido" name="contenido" rows="10" required><?= htmlspecialchars($noticia['contenido']) ?></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria_id" name="categoria_id">
                                <option value="">Seleccionar categoría</option>
                                <?php 
                                // Obtener todas las categorías
                                $categorias = get_all_categorias();
                                foreach ($categorias as $categoria): 
                                ?>
                                    <option value="<?= $categoria['id'] ?>" <?= $noticia['categoria_id'] == $categoria['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($categoria['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fecha_publicacion" class="form-label">Fecha de publicación</label>
                            <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion" value="<?= $noticia['fecha_publicacion'] ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="borrador" <?= $noticia['estado'] === 'borrador' ? 'selected' : '' ?>>Borrador</option>
                                <option value="publicado" <?= $noticia['estado'] === 'publicado' ? 'selected' : '' ?>>Publicado</option>
                                <option value="archivado" <?= $noticia['estado'] === 'archivado' ? 'selected' : '' ?>>Archivado</option>
                            </select>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="destacada" name="destacada" value="1" <?= $noticia['destacada'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="destacada">Destacar en página principal</label>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tags" class="form-label">Etiquetas</label>
                            <input type="text" class="form-control" id="tags" name="tags" value="<?= htmlspecialchars($noticia['tags']) ?>" placeholder="Separadas por comas">
                            <div class="form-text">Ejemplo: concejo, ordenanza, ciudad</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen destacada</label>
                            <?php if (!empty($noticia['imagen'])): ?>
                                <div class="mb-2">
                                    <img src="<?= ADMIN_URL ?>/uploads/noticias/<?= $noticia['imagen'] ?>" alt="Imagen actual" class="img-thumbnail" style="max-width: 100%; max-height: 200px;">
                                    <p class="form-text">Imagen actual: <?= $noticia['imagen'] ?></p>
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            <div class="form-text">Formatos permitidos: JPG, PNG, GIF, WEBP. Tamaño máximo: 2MB.</div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="<?= ADMIN_URL ?>/?section=noticias" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> <?= $action === 'guardar' ? 'Crear Noticia' : 'Actualizar Noticia' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Inicializar el editor WYSIWYG para el contenido
    $(document).ready(function() {
        $('#contenido').summernote({
            height: 300,
            lang: 'es-ES',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    // Aquí se podría implementar la subida de imágenes al servidor
                    alert('La subida de imágenes directamente desde el editor no está habilitada. Por favor, suba las imágenes por separado y luego inserte la URL.');
                }
            }
        });
    });
</script> 