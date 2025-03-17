<?php
/**
 * Controlador para la página de noticias
 */
require_once CONTROLLERS_PATH . '/base_controller.php';
require_once MODELS_PATH . '/noticia_model.php';

class NoticiasController extends BaseController {
    private $noticia_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->noticia_model = new NoticiaModel();
    }
    
    /**
     * Método principal
     */
    public function index() {
        // Obtener todas las noticias ordenadas por fecha (más recientes primero)
        $noticias = $this->noticia_model->get_all('fecha', 'DESC');
        
        // Cargar la vista
        $this->view('noticias/index', [
            'title' => 'Noticias - ' . SITE_NAME,
            'noticias' => $noticias,
            'breadcrumbs' => [
                'Noticias' => false
            ]
        ]);
    }
    
    /**
     * Muestra el detalle de una noticia
     */
    public function detalle($id) {
        // Obtener la noticia por ID
        $noticia = $this->noticia_model->get_by_id($id);
        
        if (!$noticia) {
            // Noticia no encontrada
            header("HTTP/1.0 404 Not Found");
            require_once VIEWS_PATH . '/error/404.php';
            return;
        }
        
        // Obtener noticias relacionadas (misma categoría, excluyendo la actual)
        $relacionadas = $this->noticia_model->get_related($noticia['id'], $noticia['categoria_id'], 3);
        
        // Cargar la vista
        $this->view('noticias/detalle', [
            'title' => $noticia['titulo'] . ' - ' . SITE_NAME,
            'noticia' => $noticia,
            'relacionadas' => $relacionadas,
            'breadcrumbs' => [
                'Noticias' => SITE_URL . '/?page=noticias',
                $noticia['titulo'] => false
            ]
        ]);
    }
} 