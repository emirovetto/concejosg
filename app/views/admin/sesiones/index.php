<div class="container-fluid px-4 pt-4">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Gestión de Sesiones</h1>
            </div>
            <div class="col-auto">
                <a href="<?php echo ADMIN_URL; ?>/?section=sesiones&action=crear" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Sesión
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
            <i class="fas fa-table me-1"></i>
            Listado de Sesiones
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Lugar</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sesiones)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No hay sesiones registradas.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($sesiones as $sesion): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($sesion['titulo']); ?></td>
                                    <td><?php echo format_date($sesion['fecha']); ?></td>
                                    <td><?php echo substr($sesion['hora'], 0, 5); ?> hs</td>
                                    <td><?php echo htmlspecialchars($sesion['lugar']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $sesion['tipo'] == 'ordinaria' ? 'primary' : ($sesion['tipo'] == 'extraordinaria' ? 'danger' : 'warning'); ?>">
                                            <?php echo ucfirst($sesion['tipo']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $sesion['estado'] == 'programada' ? 'primary' : ($sesion['estado'] == 'realizada' ? 'success' : 'danger'); ?>">
                                            <?php echo ucfirst($sesion['estado']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo ADMIN_URL; ?>/?section=sesiones&action=editar&id=<?php echo $sesion['id']; ?>" class="btn btn-sm btn-primary" title="Editar" data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if (!empty($sesion['acta'])): ?>
                                                <a href="<?php echo SITE_URL; ?>/app/public/uploads/sesiones/<?php echo $sesion['acta']; ?>" class="btn btn-sm btn-info" title="Ver acta" target="_blank" data-bs-toggle="tooltip">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?php echo SITE_URL; ?>/?page=sesiones&action=detalle&id=<?php echo $sesion['id']; ?>" class="btn btn-sm btn-success" title="Ver en sitio" target="_blank" data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo ADMIN_URL; ?>/?section=sesiones&action=eliminar&id=<?php echo $sesion['id']; ?>" class="btn btn-sm btn-danger delete-btn" title="Eliminar" data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 