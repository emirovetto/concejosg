<?php require_once VIEWS_PATH . '/admin/partials/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Gestión de Ordenanzas</h1>
    
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-<?= $_SESSION['mensaje_tipo'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']); ?>
    <?php endif; ?>
    
    <div class="mb-4">
        <a href="<?= BASE_URL ?>admin/ordenanzas/crear" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Ordenanza
        </a>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Listado de Ordenanzas
        </div>
        <div class="card-body">
            <?php if (empty($ordenanzas)): ?>
                <div class="alert alert-info">
                    No hay ordenanzas registradas.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Año</th>
                                <th>Título</th>
                                <th>Fecha Sanción</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ordenanzas as $ordenanza): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ordenanza['numero']) ?></td>
                                    <td><?= htmlspecialchars($ordenanza['anio']) ?></td>
                                    <td><?= htmlspecialchars($ordenanza['titulo']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($ordenanza['fecha_sancion'])) ?></td>
                                    <td>
                                        <?php 
                                        if (isset($categorias[$ordenanza['categoria_id']])) {
                                            echo htmlspecialchars($categorias[$ordenanza['categoria_id']]);
                                        } else {
                                            echo 'Sin categoría';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?= BASE_URL ?>admin/ordenanzas/editar/<?= $ordenanza['id'] ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <?php if (!empty($ordenanza['archivo'])): ?>
                                                <a href="<?= BASE_URL ?>uploads/ordenanzas/<?= $ordenanza['archivo'] ?>" class="btn btn-sm btn-info" title="Ver documento" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            <?php endif; ?>
                                            
                                            <a href="<?= BASE_URL ?>ordenanzas/detalle/<?= $ordenanza['id'] ?>" class="btn btn-sm btn-primary" title="Ver en sitio" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <button type="button" class="btn btn-sm btn-danger" title="Eliminar" 
                                                    onclick="confirmarEliminacion('<?= BASE_URL ?>admin/ordenanzas/eliminar/<?= $ordenanza['id'] ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
</div>

<script>
function confirmarEliminacion(url) {
    if (confirm('¿Está seguro que desea eliminar esta ordenanza? Esta acción no se puede deshacer.')) {
        window.location.href = url;
    }
}
</script>

<?php require_once VIEWS_PATH . '/admin/partials/footer.php'; ?> 