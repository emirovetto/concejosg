<?php
/**
 * Controlador para la página de sesiones
 */
require_once CONTROLLERS_PATH . '/base_controller.php';
require_once MODELS_PATH . '/sesion_model.php';

class SesionesController extends BaseController {
    private $sesion_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->sesion_model = new SesionModel();
    }
    
    /**
     * Método principal
     */
    public function index() {
        // Obtener todas las sesiones ordenadas por fecha (más recientes primero)
        $sesiones = $this->sesion_model->get_all('fecha', 'DESC');
        
        // Cargar la vista
        $this->view('sesiones/index', [
            'title' => 'Sesiones - ' . SITE_NAME,
            'sesiones' => $sesiones,
            'breadcrumbs' => [
                'Sesiones' => false
            ]
        ]);
    }
    
    /**
     * Muestra el detalle de una sesión
     */
    public function detalle($id) {
        // Obtener la sesión por ID
        $sesion = $this->sesion_model->get_by_id($id);
        
        if (!$sesion) {
            // Sesión no encontrada
            header("HTTP/1.0 404 Not Found");
            require_once VIEWS_PATH . '/error/404.php';
            return;
        }
        
        // Cargar la vista
        $this->view('sesiones/detalle', [
            'title' => 'Sesión: ' . $sesion['titulo'] . ' - ' . SITE_NAME,
            'sesion' => $sesion,
            'breadcrumbs' => [
                'Sesiones' => SITE_URL . '/?page=sesiones',
                $sesion['titulo'] => false
            ]
        ]);
    }
} 