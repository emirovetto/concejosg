/**
 * Scripts personalizados para el sitio del Concejo Deliberante de San Genaro
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Inicializar popovers de Bootstrap
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Animación para los números en la sección de estadísticas
    if (document.querySelector('.display-4')) {
        animateNumbers();
    }
    
    // Validación de formularios
    if (document.querySelector('form')) {
        validateForms();
    }
    
    // Filtros para la página de ordenanzas
    if (document.getElementById('ordenanzasFilter')) {
        setupOrdenanzasFilter();
    }
});

/**
 * Anima los números en la sección de estadísticas
 */
function animateNumbers() {
    const numberElements = document.querySelectorAll('.display-4');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                const finalValue = parseInt(element.textContent.replace(/\D/g, ''));
                
                animateValue(element, 0, finalValue, 1500);
                observer.unobserve(element);
            }
        });
    }, { threshold: 0.5 });
    
    numberElements.forEach(element => {
        observer.observe(element);
    });
}

/**
 * Anima un valor desde start hasta end en la duración especificada
 */
function animateValue(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        let value = Math.floor(progress * (end - start) + start);
        
        // Agregar el "+" si el texto original lo tenía
        if (element.textContent.includes('+')) {
            element.textContent = value + '+';
        } else {
            element.textContent = value;
        }
        
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

/**
 * Configura la validación de formularios
 */
function validateForms() {
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
}

/**
 * Configura los filtros para la página de ordenanzas
 */
function setupOrdenanzasFilter() {
    const filterForm = document.getElementById('ordenanzasFilter');
    const yearSelect = document.getElementById('year');
    const categorySelect = document.getElementById('category');
    const searchInput = document.getElementById('search');
    const ordenanzasList = document.getElementById('ordenanzasList');
    
    // Función para aplicar los filtros
    function applyFilters() {
        const year = yearSelect.value;
        const category = categorySelect.value;
        const search = searchInput.value.toLowerCase();
        
        // Enviar solicitud AJAX para obtener resultados filtrados
        fetch(`${siteUrl}/app/controllers/ordenanzas_controller.php?action=filter&year=${year}&category=${category}&search=${search}`)
            .then(response => response.json())
            .then(data => {
                // Actualizar la lista de ordenanzas
                ordenanzasList.innerHTML = '';
                
                if (data.length === 0) {
                    ordenanzasList.innerHTML = '<div class="alert alert-info">No se encontraron ordenanzas con los criterios seleccionados.</div>';
                    return;
                }
                
                data.forEach(ordenanza => {
                    const item = document.createElement('div');
                    item.className = 'card mb-3 shadow-sm';
                    item.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">Ordenanza N° ${ordenanza.numero}/${ordenanza.anio}</h5>
                            <p class="text-muted mb-2">
                                <i class="far fa-calendar-alt me-1"></i> ${ordenanza.fecha_sancion}
                                <span class="badge bg-primary ms-2">${ordenanza.categoria}</span>
                            </p>
                            <p class="card-text">${ordenanza.descripcion}</p>
                            <a href="${siteUrl}/?page=ordenanzas&id=${ordenanza.id}" class="btn btn-sm btn-primary">Ver detalles</a>
                            <a href="${siteUrl}/app/public/uploads/ordenanzas/${ordenanza.archivo}" class="btn btn-sm btn-outline-primary ms-2" target="_blank">
                                <i class="fas fa-file-pdf me-1"></i> Descargar PDF
                            </a>
                        </div>
                    `;
                    ordenanzasList.appendChild(item);
                });
            })
            .catch(error => {
                console.error('Error al filtrar ordenanzas:', error);
                ordenanzasList.innerHTML = '<div class="alert alert-danger">Error al cargar las ordenanzas. Por favor, inténtalo de nuevo.</div>';
            });
    }
    
    // Eventos para aplicar filtros
    yearSelect.addEventListener('change', applyFilters);
    categorySelect.addEventListener('change', applyFilters);
    
    // Debounce para la búsqueda
    let searchTimeout;
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 500);
    });
} 