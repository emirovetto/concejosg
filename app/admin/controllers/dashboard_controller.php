<?php
/**
 * Controlador para el dashboard del panel de administración
 */
require_once '../app/admin/controllers/base_controller.php';
require_once MODELS_PATH . '/noticia_model.php';
require_once MODELS_PATH . '/sesion_model.php';
require_once MODELS_PATH . '/ordenanza_model.php';
require_once MODELS_PATH . '/concejal_model.php';

class DashboardController extends BaseController {
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->require_admin();
    }
    
    /**
     * Método principal - Dashboard
     */
    public function index() {
        // Cargar modelos necesarios
        $noticia_model = new NoticiaModel();
        $sesion_model = new SesionModel();
        $ordenanza_model = new OrdenanzaModel();
        $concejal_model = new ConcejalModel();
        
        // Obtener estadísticas
        $total_noticias = count($noticia_model->get_all());
        $total_sesiones = count($sesion_model->get_all());
        $total_ordenanzas = count($ordenanza_model->get_all());
        $total_concejales = count($concejal_model->get_all());
        
        // Obtener últimas noticias
        $ultimas_noticias = $noticia_model->get_latest(5);
        
        // Obtener próximas sesiones
        $proximas_sesiones = $sesion_model->get_upcoming(3);
        
        // Cargar la vista
        $this->view('dashboard/index', [
            'title' => 'Dashboard - Panel de Administración',
            'total_noticias' => $total_noticias,
            'total_sesiones' => $total_sesiones,
            'total_ordenanzas' => $total_ordenanzas,
            'total_concejales' => $total_concejales,
            'ultimas_noticias' => $ultimas_noticias,
            'proximas_sesiones' => $proximas_sesiones
        ]);
    }
} 