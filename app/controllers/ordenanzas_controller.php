<?php
/**
 * Controlador para la página de ordenanzas
 */
require_once CONTROLLERS_PATH . '/base_controller.php';
require_once MODELS_PATH . '/ordenanza_model.php';

class OrdenanzasController extends BaseController {
    private $ordenanza_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->ordenanza_model = new OrdenanzaModel();
    }
    
    /**
     * Método principal
     */
    public function index() {
        // Obtener todas las ordenanzas ordenadas por número (más recientes primero)
        $ordenanzas = $this->ordenanza_model->get_all('numero', 'DESC');
        
        // Cargar la vista
        $this->view('ordenanzas/index', [
            'title' => 'Ordenanzas - ' . SITE_NAME,
            'ordenanzas' => $ordenanzas,
            'breadcrumbs' => [
                'Ordenanzas' => false
            ]
        ]);
    }
    
    /**
     * Muestra el detalle de una ordenanza
     */
    public function detalle($id) {
        // Obtener la ordenanza por ID
        $ordenanza = $this->ordenanza_model->get_by_id($id);
        
        if (!$ordenanza) {
            // Ordenanza no encontrada
            header("HTTP/1.0 404 Not Found");
            require_once VIEWS_PATH . '/error/404.php';
            return;
        }
        
        // Cargar la vista
        $this->view('ordenanzas/detalle', [
            'title' => 'Ordenanza N° ' . $ordenanza['numero'] . ' - ' . SITE_NAME,
            'ordenanza' => $ordenanza,
            'breadcrumbs' => [
                'Ordenanzas' => SITE_URL . '/?page=ordenanzas',
                'Ordenanza N° ' . $ordenanza['numero'] => false
            ]
        ]);
    }
} 