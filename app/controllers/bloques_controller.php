<?php
/**
 * Controlador para la página de bloques políticos
 */
require_once CONTROLLERS_PATH . '/base_controller.php';
require_once MODELS_PATH . '/bloque_model.php';
require_once MODELS_PATH . '/concejal_model.php';

class BloquesController extends BaseController {
    private $bloque_model;
    private $concejal_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->bloque_model = new BloqueModel();
        $this->concejal_model = new ConcejalModel();
    }
    
    /**
     * Método principal
     */
    public function index() {
        // Obtener todos los bloques con la cantidad de concejales
        $bloques = $this->bloque_model->get_with_count();
        
        // Cargar la vista
        $this->view('bloques/index', [
            'title' => 'Bloques Políticos - ' . SITE_NAME,
            'bloques' => $bloques,
            'breadcrumbs' => [
                'Bloques' => false
            ]
        ]);
    }
    
    /**
     * Muestra el detalle de un bloque
     */
    public function detalle($id) {
        // Obtener el bloque por ID
        $bloque = $this->bloque_model->get_by_id($id);
        
        if (!$bloque) {
            // Bloque no encontrado
            header("HTTP/1.0 404 Not Found");
            require_once VIEWS_PATH . '/error/404.php';
            return;
        }
        
        // Obtener los concejales del bloque
        $concejales = $this->concejal_model->get_by_bloque($id);
        
        // Cargar la vista
        $this->view('bloques/detalle', [
            'title' => $bloque['nombre'] . ' - ' . SITE_NAME,
            'bloque' => $bloque,
            'concejales' => $concejales,
            'breadcrumbs' => [
                'Bloques' => SITE_URL . '/?page=bloques',
                $bloque['nombre'] => false
            ]
        ]);
    }
} 