<div class="container-fluid px-4">
    <h1 class="mt-4">Gestión de Usuarios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuarios</li>
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
            <div class="d-flex justify-content-between align-items-center">
                <div><i class="fas fa-users me-1"></i> Usuarios Registrados</div>
                <a href="<?= ADMIN_URL ?>/?section=usuarios&action=crear" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($usuarios)): ?>
                <div class="alert alert-info">No hay usuarios registrados.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Último Acceso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= $usuario['id'] ?></td>
                                    <td><?= $usuario['nombre'] . ' ' . $usuario['apellido'] ?></td>
                                    <td><?= $usuario['email'] ?></td>
                                    <td>
                                        <?php if ($usuario['rol'] === 'admin'): ?>
                                            <span class="badge bg-primary">Administrador</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Editor</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($usuario['estado'] === 'activo'): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $usuario['ultimo_acceso'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_acceso'])) : 'Nunca' ?></td>
                                    <td>
                                        <a href="<?= ADMIN_URL ?>/?section=usuarios&action=editar&id=<?= $usuario['id'] ?>" class="btn btn-sm btn-primary btn-action" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($_SESSION['user_id'] != $usuario['id']): ?>
                                            <a href="<?= ADMIN_URL ?>/?section=usuarios&action=eliminar&id=<?= $usuario['id'] ?>" class="btn btn-sm btn-danger btn-action btn-delete" data-bs-toggle="tooltip" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 