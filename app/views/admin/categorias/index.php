<?php require_once VIEWS_PATH . '/admin/partials/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Gestión de Categorías</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item active">Categorías</li>
        </ol>
        <a href="<?= ADMIN_URL ?>/?section=categorias&action=crear" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nueva Categoría
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
            <i class="fas fa-tags me-1"></i>
            Listado de Categorías
        </div>
        <div class="card-body">
            <?php if (empty($categorias)): ?>
                <div class="alert alert-info" role="alert">
                    No hay categorías registradas. <a href="<?= ADMIN_URL ?>/?section=categorias&action=crear" class="alert-link">Crear una nueva categoría</a>.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Noticias</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr>
                                    <td><?= $categoria['id'] ?></td>
                                    <td><?= htmlspecialchars($categoria['nombre']) ?></td>
                                    <td>
                                        <?php if (!empty($categoria['descripcion'])): ?>
                                            <?= htmlspecialchars($categoria['descripcion']) ?>
                                        <?php else: ?>
                                            <span class="text-muted">Sin descripción</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (isset($categoria['total_noticias']) && $categoria['total_noticias'] > 0): ?>
                                            <span class="badge bg-primary"><?= $categoria['total_noticias'] ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?= ADMIN_URL ?>/?section=categorias&action=editar&id=<?= $categoria['id'] ?>" class="btn btn-sm btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if (!isset($categoria['total_noticias']) || $categoria['total_noticias'] == 0): ?>
                                                <button type="button" class="btn btn-sm btn-danger" title="Eliminar" 
                                                        onclick="confirmarEliminacion('<?= ADMIN_URL ?>/?section=categorias&action=eliminar&id=<?= $categoria['id'] ?>', '<?= htmlspecialchars($categoria['nombre']) ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-danger" title="No se puede eliminar" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
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
    // Inicializar DataTable
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
            },
            order: [[0, 'asc']] // Ordenar por ID ascendente por defecto
        });
    });
    
    // Función para confirmar eliminación
    function confirmarEliminacion(url, nombre) {
        if (confirm('¿Está seguro de que desea eliminar la categoría "' + nombre + '"? Esta acción no se puede deshacer.')) {
            window.location.href = url;
        }
    }
</script>

<?php require_once VIEWS_PATH . '/admin/partials/footer.php'; ?> 