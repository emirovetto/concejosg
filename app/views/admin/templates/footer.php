        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Concejo Deliberante de San Genaro <?= date('Y') ?></div>
                    <div>
                        <a href="<?= BASE_URL ?>" target="_blank">Ir al sitio web</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<!-- Custom scripts -->
<script>
// Scripts para el panel de administración
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTables
    const dataTablesElements = document.querySelectorAll('.datatable');
    if (dataTablesElements.length > 0) {
        dataTablesElements.forEach(function(table) {
            try {
                new DataTable(table, {
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                    },
                    responsive: true,
                    autoWidth: false,
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 2, targets: -1 }
                    ]
                });
            } catch (e) {
                console.error('Error al inicializar DataTable:', e);
            }
        });
    }
    
    // Inicializar Summernote
    const summernoteElements = document.querySelectorAll('.summernote');
    if (summernoteElements.length > 0 && typeof $.fn.summernote !== 'undefined') {
        summernoteElements.forEach(function(editor) {
            try {
                $(editor).summernote({
                    lang: 'es-ES',
                    height: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    callbacks: {
                        onImageUpload: function(files) {
                            // Aquí se podría implementar la subida de imágenes
                            alert('La subida de imágenes directamente no está implementada. Por favor, suba la imagen primero y luego inserte la URL.');
                        }
                    }
                });
            } catch (e) {
                console.error('Error al inicializar Summernote:', e);
            }
        });
    }
    
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Confirmación para eliminar elementos
    const deleteButtons = document.querySelectorAll('.btn-delete, .delete-btn');
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                if (!confirm('¿Está seguro de que desea eliminar este elemento? Esta acción no se puede deshacer.')) {
                    e.preventDefault();
                }
            });
        });
    }
    
    // Previsualización de imágenes
    const imageInputs = document.querySelectorAll('.image-input');
    if (imageInputs.length > 0) {
        imageInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                const preview = document.getElementById(this.dataset.preview);
                if (preview && this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    }
    
    // Inicializar el toggle del sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        // Recuperar el estado del sidebar del localStorage
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            document.body.classList.add('sb-sidenav-toggled');
        }
        
        sidebarToggle.addEventListener('click', function() {
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
    
    // Auto-cerrar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    if (alerts.length > 0) {
        alerts.forEach(function(alert) {
            setTimeout(function() {
                try {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                } catch (e) {
                    console.error('Error al cerrar alerta:', e);
                    alert.style.display = 'none';
                }
            }, 5000);
        });
    }
    
    // Ajustar layout en dispositivos móviles
    function adjustLayout() {
        if (window.innerWidth < 992) {
            document.body.classList.remove('sb-sidenav-toggled');
        }
    }
    
    // Ejecutar al cargar y al cambiar el tamaño de la ventana
    adjustLayout();
    window.addEventListener('resize', adjustLayout);
});
</script>
</body>
</html> 