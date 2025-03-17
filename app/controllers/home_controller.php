<?php
/**
 * Controlador para la página de inicio
 */
require_once CONTROLLERS_PATH . '/base_controller.php';
require_once MODELS_PATH . '/noticia_model.php';
require_once MODELS_PATH . '/sesion_model.php';

class HomeController extends BaseController {
    private $noticia_model;
    private $sesion_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        try {
            $this->noticia_model = new NoticiaModel();
            $this->sesion_model = new SesionModel();
        } catch (Exception $e) {
            error_log('Error inicializando HomeController: ' . $e->getMessage());
        }
    }
    
    /**
     * Método principal
     */
    public function index() {
        try {
            // Obtener las últimas noticias
            $noticias = $this->noticia_model->get_latest(3);
            
            // Obtener las próximas sesiones
            $sesiones = $this->sesion_model->get_upcoming(2);
            
            // Cargar la vista
            $this->view('home/index', [
                'title' => 'Inicio - ' . SITE_NAME,
                'noticias' => $noticias,
                'sesiones' => $sesiones
            ]);
        } catch (Exception $e) {
            error_log('Error en HomeController::index: ' . $e->getMessage());
            
            // En caso de error, mostrar la página de inicio sin datos dinámicos
            $this->view('home/index', [
                'title' => 'Inicio - ' . SITE_NAME,
                'noticias' => [],
                'sesiones' => []
            ]);
        }
    }
} 