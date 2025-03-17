<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="page-title"><?php echo $action == 'guardar' ? 'Nuevo Bloque Político' : 'Editar Bloque Político'; ?></h1>
            <p class="text-muted"><?php echo $action == 'guardar' ? 'Complete el formulario para crear un nuevo bloque político' : 'Modifique los datos del bloque político'; ?></p>
        </div>
        <div class="col-auto">
            <a href="<?php echo ADMIN_URL; ?>/?section=bloques" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?php echo ADMIN_URL; ?>/?section=bloques&action=<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <?php if ($action == 'actualizar'): ?>
                <input type="hidden" name="id" value="<?php echo $bloque['id']; ?>">
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $bloque['nombre']; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="color" name="color" value="<?php echo $bloque['color']; ?>" title="Elija un color para el bloque">
                            <input type="text" class="form-control" id="color_hex" value="<?php echo $bloque['color']; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control summernote" id="descripcion" name="descripcion" rows="5"><?php echo $bloque['descripcion']; ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB.</small>
                
                <?php if (!empty($bloque['logo'])): ?>
                    <div class="mt-2">
                        <img src="<?php echo SITE_URL; ?>/app/public/uploads/bloques/<?php echo $bloque['logo']; ?>" alt="Logo actual" class="img-thumbnail" width="100">
                        <p class="form-text">Logo actual. Suba una nueva imagen para reemplazarlo.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                <a href="<?php echo ADMIN_URL; ?>/?section=bloques" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary"><?php echo $action == 'guardar' ? 'Crear Bloque' : 'Actualizar Bloque'; ?></button>
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
        
        // Actualizar el campo de texto con el valor del color
        document.getElementById('color').addEventListener('input', function() {
            document.getElementById('color_hex').value = this.value;
        });
    });
</script> 