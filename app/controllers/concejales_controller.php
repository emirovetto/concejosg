<?php
/**
 * Controlador para la página de concejales
 */
require_once CONTROLLERS_PATH . '/base_controller.php';
require_once MODELS_PATH . '/concejal_model.php';
require_once MODELS_PATH . '/bloque_model.php';

class ConcejalesController extends BaseController {
    private $concejal_model;
    private $bloque_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->concejal_model = new ConcejalModel();
        $this->bloque_model = new BloqueModel();
    }
    
    /**
     * Método principal
     */
    public function index() {
        // Obtener todos los concejales ordenados por apellido
        $concejales = $this->concejal_model->get_all('apellido');
        
        // Obtener todos los bloques para mostrar la información completa
        $bloques = $this->bloque_model->get_all('nombre');
        
        // Organizar los bloques por ID para facilitar el acceso
        $bloques_por_id = [];
        foreach ($bloques as $bloque) {
            $bloques_por_id[$bloque['id']] = $bloque;
        }
        
        // Cargar la vista
        $this->view('concejales/index', [
            'title' => 'Concejales - ' . SITE_NAME,
            'concejales' => $concejales,
            'bloques' => $bloques_por_id,
            'breadcrumbs' => [
                'Concejales' => false
            ]
        ]);
    }
    
    /**
     * Muestra el detalle de un concejal
     */
    public function detalle($id) {
        // Obtener el concejal por ID
        $concejal = $this->concejal_model->get_by_id($id);
        
        if (!$concejal) {
            // Concejal no encontrado
            header("HTTP/1.0 404 Not Found");
            require_once VIEWS_PATH . '/error/404.php';
            return;
        }
        
        // Obtener el bloque al que pertenece
        $bloque = $this->bloque_model->get_by_id($concejal['bloque_id']);
        
        // Cargar la vista
        $this->view('concejales/detalle', [
            'title' => $concejal['nombre'] . ' ' . $concejal['apellido'] . ' - ' . SITE_NAME,
            'concejal' => $concejal,
            'bloque' => $bloque,
            'breadcrumbs' => [
                'Concejales' => SITE_URL . '/?page=concejales',
                $concejal['nombre'] . ' ' . $concejal['apellido'] => false
            ]
        ]);
    }
} 