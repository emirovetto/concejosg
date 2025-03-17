<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="page-title">Gestión de Concejales</h1>
            <p class="text-muted">Administre los concejales del Concejo Deliberante</p>
        </div>
        <div class="col-auto">
            <a href="<?php echo ADMIN_URL; ?>/?section=concejales&action=crear" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Concejal
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($concejales)): ?>
            <div class="alert alert-info">
                No hay concejales registrados. Haga clic en "Nuevo Concejal" para agregar uno.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Bloque</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($concejales as $concejal): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($concejal['foto'])): ?>
                                        <img src="<?php echo SITE_URL; ?>/app/public/uploads/concejales/<?php echo $concejal['foto']; ?>" alt="<?php echo $concejal['nombre'] . ' ' . $concejal['apellido']; ?>" class="img-thumbnail" width="50">
                                    <?php else: ?>
                                        <img src="<?php echo SITE_URL; ?>/app/public/img/avatar-placeholder.png" alt="Sin foto" class="img-thumbnail" width="50">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $concejal['apellido'] . ', ' . $concejal['nombre']; ?></td>
                                <td><?php echo $concejal['cargo']; ?></td>
                                <td><?php echo isset($bloques[$concejal['bloque_id']]) ? $bloques[$concejal['bloque_id']] : 'Sin bloque'; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $concejal['estado'] == 'activo' ? 'success' : 'danger'; ?>">
                                        <?php echo ucfirst($concejal['estado']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo ADMIN_URL; ?>/?section=concejales&action=editar&id=<?php echo $concejal['id']; ?>" class="btn btn-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo SITE_URL; ?>/?page=concejales&id=<?php echo $concejal['id']; ?>" class="btn btn-info" title="Ver en sitio" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo ADMIN_URL; ?>/?section=concejales&action=eliminar&id=<?php echo $concejal['id']; ?>" class="btn btn-danger btn-delete" title="Eliminar" data-confirm="¿Está seguro de que desea eliminar este concejal?">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
        if (document.querySelector('.datatable')) {
            $('.datatable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                order: [[1, 'asc']]
            });
        }
        
        // Confirmar eliminación
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function(e) {
                if (!confirm(this.dataset.confirm)) {
                    e.preventDefault();
                }
            });
        });
    });
</script> 