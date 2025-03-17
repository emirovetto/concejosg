<div class="container-fluid px-4">
    <h1 class="mt-4">Configuración del Sitio</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Configuración</li>
    </ol>
    
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-cogs me-1"></i> Configuración General
        </div>
        <div class="card-body">
            <form action="<?= ADMIN_URL ?>/?section=configuracion&action=actualizar" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="site_name" class="form-label required">Nombre del Sitio</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" value="<?= $config['site_name'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="site_description" class="form-label required">Descripción del Sitio</label>
                            <input type="text" class="form-control" id="site_description" name="site_description" value="<?= $config['site_description'] ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_email" class="form-label required">Email de Contacto</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= $config['contact_email'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_phone" class="form-label">Teléfono de Contacto</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?= $config['contact_phone'] ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= $config['address'] ?>">
                        </div>
                    </div>
                </div>
                
                <h4 class="mt-4 mb-3">Redes Sociales</h4>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="facebook_url" class="form-label">URL de Facebook</label>
                            <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="<?= $config['facebook_url'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twitter_url" class="form-label">URL de Twitter</label>
                            <input type="url" class="form-control" id="twitter_url" name="twitter_url" value="<?= $config['twitter_url'] ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="instagram_url" class="form-label">URL de Instagram</label>
                            <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="<?= $config['instagram_url'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="youtube_url" class="form-label">URL de YouTube</label>
                            <input type="url" class="form-control" id="youtube_url" name="youtube_url" value="<?= $config['youtube_url'] ?>">
                        </div>
                    </div>
                </div>
                
                <h4 class="mt-4 mb-3">Configuración Avanzada</h4>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="items_per_page" class="form-label required">Elementos por Página</label>
                            <input type="number" class="form-control" id="items_per_page" name="items_per_page" value="<?= $config['items_per_page'] ?>" min="5" max="50" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="maintenance_mode" class="form-label">Modo Mantenimiento</label>
                            <select class="form-select" id="maintenance_mode" name="maintenance_mode">
                                <option value="0" <?= $config['maintenance_mode'] == 0 ? 'selected' : '' ?>>Desactivado</option>
                                <option value="1" <?= $config['maintenance_mode'] == 1 ? 'selected' : '' ?>>Activado</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 mb-0">
                    <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                </div>
            </form>
        </div>
    </div>
</div> 