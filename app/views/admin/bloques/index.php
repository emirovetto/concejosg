<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="page-title">Gestión de Bloques Políticos</h1>
            <p class="text-muted">Administre los bloques políticos del Concejo Deliberante</p>
        </div>
        <div class="col-auto">
            <a href="<?php echo ADMIN_URL; ?>/?section=bloques&action=crear" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Bloque
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($bloques)): ?>
            <div class="alert alert-info">
                No hay bloques políticos registrados. Haga clic en "Nuevo Bloque" para agregar uno.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Color</th>
                            <th>Concejales</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bloques as $bloque): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($bloque['logo'])): ?>
                                        <img src="<?php echo SITE_URL; ?>/app/public/uploads/bloques/<?php echo $bloque['logo']; ?>" alt="<?php echo $bloque['nombre']; ?>" class="img-thumbnail" width="50">
                                    <?php else: ?>
                                        <div style="width: 50px; height: 50px; background-color: <?php echo $bloque['color']; ?>; border-radius: 5px;"></div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $bloque['nombre']; ?></td>
                                <td><?php echo substr($bloque['descripcion'], 0, 100) . (strlen($bloque['descripcion']) > 100 ? '...' : ''); ?></td>
                                <td>
                                    <div style="width: 30px; height: 30px; background-color: <?php echo $bloque['color']; ?>; border-radius: 5px;"></div>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?php echo $bloque['cantidad_concejales']; ?></span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo ADMIN_URL; ?>/?section=bloques&action=editar&id=<?php echo $bloque['id']; ?>" class="btn btn-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo SITE_URL; ?>/?page=bloques&id=<?php echo $bloque['id']; ?>" class="btn btn-info" title="Ver en sitio" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo ADMIN_URL; ?>/?section=bloques&action=eliminar&id=<?php echo $bloque['id']; ?>" class="btn btn-danger btn-delete" title="Eliminar" data-confirm="¿Está seguro de que desea eliminar este bloque político? Esta acción no se puede deshacer.">
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