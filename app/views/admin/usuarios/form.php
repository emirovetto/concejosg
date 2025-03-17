<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $action === 'crear' ? 'Nuevo Usuario' : 'Editar Usuario' ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>/?section=usuarios">Usuarios</a></li>
        <li class="breadcrumb-item active"><?= $action === 'crear' ? 'Nuevo Usuario' : 'Editar Usuario' ?></li>
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
            <i class="fas fa-user-edit me-1"></i> <?= $action === 'crear' ? 'Nuevo Usuario' : 'Editar Usuario' ?>
        </div>
        <div class="card-body">
            <form action="<?= ADMIN_URL ?>/?section=usuarios&action=<?= $action === 'crear' ? 'guardar' : 'actualizar' ?>" method="post">
                <?php if ($action === 'editar'): ?>
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                <?php endif; ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre" class="form-label required">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuario['nombre'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellido" class="form-label required">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $usuario['apellido'] ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label required">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $usuario['email'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="form-label required">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $usuario['username'] ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label <?= $action === 'crear' ? 'required' : '' ?>">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" <?= $action === 'crear' ? 'required' : '' ?>>
                            <?php if ($action === 'editar'): ?>
                                <small class="text-muted">Dejar en blanco para mantener la contraseña actual.</small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirm" class="form-label <?= $action === 'crear' ? 'required' : '' ?>">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" <?= $action === 'crear' ? 'required' : '' ?>>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rol" class="form-label required">Rol</label>
                            <select class="form-select" id="rol" name="rol" required>
                                <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                                <option value="editor" <?= $usuario['rol'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado" class="form-label required">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="activo" <?= $usuario['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                                <option value="inactivo" <?= $usuario['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 mb-0">
                    <div class="d-flex justify-content-between">
                        <a href="<?= ADMIN_URL ?>/?section=usuarios" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><?= $action === 'crear' ? 'Crear Usuario' : 'Actualizar Usuario' ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 