<div class="container-fluid px-4">
    <h1 class="mt-4">Gestión de Noticias</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= ADMIN_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item active">Noticias</li>
        </ol>
        <a href="<?= ADMIN_URL ?>/?section=noticias&action=crear" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nueva Noticia
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
            <i class="fas fa-newspaper me-1"></i>
            Listado de Noticias
        </div>
        <div class="card-body">
            <?php if (empty($noticias)): ?>
                <div class="alert alert-info" role="alert">
                    No hay noticias registradas. <a href="<?= ADMIN_URL ?>/?section=noticias&action=crear" class="alert-link">Crear una nueva noticia</a>.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Título</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Destacada</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($noticias as $noticia): ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if (!empty($noticia['imagen'])): ?>
                                            <img src="<?= BASE_URL ?>/uploads/noticias/<?= $noticia['imagen'] ?>" alt="<?= $noticia['titulo'] ?>" class="img-thumbnail" style="max-width: 80px; max-height: 60px;">
                                        <?php else: ?>
                                            <span class="text-muted"><i class="fas fa-image fa-2x"></i></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($noticia['titulo']) ?></td>
                                    <td>
                                        <?php 
                                        // Obtener el nombre de la categoría
                                        $categoria = isset($noticia['categoria_id']) ? get_categoria_nombre($noticia['categoria_id']) : 'Sin categoría';
                                        echo htmlspecialchars($categoria);
                                        ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($noticia['fecha_publicacion'])) ?></td>
                                    <td>
                                        <?php if ($noticia['estado'] == 'publicado'): ?>
                                            <span class="badge bg-success">Publicado</span>
                                        <?php elseif ($noticia['estado'] == 'borrador'): ?>
                                            <span class="badge bg-warning text-dark">Borrador</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= ucfirst($noticia['estado']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($noticia['destacada']): ?>
                                            <span class="badge bg-primary"><i class="fas fa-star"></i> Sí</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?= ADMIN_URL ?>/?section=noticias&action=editar&id=<?= $noticia['id'] ?>" class="btn btn-sm btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>/noticias/<?= $noticia['id'] ?>" target="_blank" class="btn btn-sm btn-info" title="Ver en sitio">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Eliminar" 
                                                    onclick="confirmarEliminacion('<?= ADMIN_URL ?>/?section=noticias&action=eliminar&id=<?= $noticia['id'] ?>', '<?= htmlspecialchars($noticia['titulo']) ?>')">
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
    // Inicializar DataTable
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
            },
            order: [[3, 'desc']] // Ordenar por fecha (columna 3) descendente por defecto
        });
    });
    
    // Función para confirmar eliminación
    function confirmarEliminacion(url, titulo) {
        if (confirm('¿Está seguro de que desea eliminar la noticia "' + titulo + '"? Esta acción no se puede deshacer.')) {
            window.location.href = url;
        }
    }
</script> 