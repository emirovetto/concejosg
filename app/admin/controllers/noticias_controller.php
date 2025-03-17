<?php
/**
 * Controlador para la gestión de noticias
 */
require_once '../app/admin/controllers/base_controller.php';
require_once MODELS_PATH . '/noticia_model.php';

class NoticiasController extends BaseController {
    private $noticia_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->require_admin();
        $this->noticia_model = new NoticiaModel();
    }
    
    /**
     * Método principal - Listado de noticias
     */
    public function index() {
        // Obtener todas las noticias ordenadas por fecha (más recientes primero)
        $noticias = $this->noticia_model->get_all('fecha_publicacion', 'DESC');
        
        // Cargar la vista
        $this->view('noticias/index', [
            'title' => 'Gestión de Noticias - Panel de Administración',
            'noticias' => $noticias
        ]);
    }
    
    /**
     * Formulario para crear una nueva noticia
     */
    public function crear() {
        // Cargar la vista
        $this->view('noticias/form', [
            'title' => 'Nueva Noticia - Panel de Administración',
            'action' => 'guardar',
            'noticia' => [
                'id' => '',
                'titulo' => '',
                'contenido' => '',
                'imagen' => '',
                'fecha_publicacion' => date('Y-m-d'),
                'estado' => 'borrador',
                'destacada' => 0,
                'categoria_id' => '',
                'tags' => ''
            ]
        ]);
    }
    
    /**
     * Procesar la creación de una nueva noticia
     */
    public function guardar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=noticias');
        }
        
        // Obtener los datos del formulario
        $noticia = [
            'titulo' => isset($_POST['titulo']) ? trim($_POST['titulo']) : '',
            'contenido' => isset($_POST['contenido']) ? trim($_POST['contenido']) : '',
            'fecha_publicacion' => isset($_POST['fecha_publicacion']) ? trim($_POST['fecha_publicacion']) : date('Y-m-d'),
            'estado' => isset($_POST['estado']) ? trim($_POST['estado']) : 'borrador',
            'destacada' => isset($_POST['destacada']) ? 1 : 0,
            'categoria_id' => isset($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : 0,
            'tags' => isset($_POST['tags']) ? trim($_POST['tags']) : ''
        ];
        
        // Validar los datos
        if (empty($noticia['titulo']) || empty($noticia['contenido'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias&action=crear', 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Procesar la imagen si se subió
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $imagen_filename = $this->upload_file($_FILES['imagen'], UPLOADS_PATH . '/noticias', $allowed_types);
            
            if ($imagen_filename) {
                $noticia['imagen'] = $imagen_filename;
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=noticias&action=crear', 'Error al subir la imagen. Asegúrese de que sea una imagen válida.', 'danger');
            }
        }
        
        // Guardar la noticia en la base de datos
        $result = $this->noticia_model->insert($noticia);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias', 'Noticia creada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias&action=crear', 'Error al crear la noticia. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Formulario para editar una noticia existente
     */
    public function editar() {
        // Obtener el ID de la noticia
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias', 'Noticia no encontrada.', 'danger');
        }
        
        // Obtener la noticia por ID
        $noticia = $this->noticia_model->get_by_id($id);
        
        if (!$noticia) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias', 'Noticia no encontrada.', 'danger');
        }
        
        // Cargar la vista
        $this->view('noticias/form', [
            'title' => 'Editar Noticia - Panel de Administración',
            'action' => 'actualizar',
            'noticia' => $noticia
        ]);
    }
    
    /**
     * Procesar la actualización de una noticia existente
     */
    public function actualizar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=noticias');
        }
        
        // Obtener el ID de la noticia
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias', 'Noticia no encontrada.', 'danger');
        }
        
        // Obtener los datos del formulario
        $noticia = [
            'titulo' => isset($_POST['titulo']) ? trim($_POST['titulo']) : '',
            'contenido' => isset($_POST['contenido']) ? trim($_POST['contenido']) : '',
            'fecha_publicacion' => isset($_POST['fecha_publicacion']) ? trim($_POST['fecha_publicacion']) : date('Y-m-d'),
            'estado' => isset($_POST['estado']) ? trim($_POST['estado']) : 'borrador',
            'destacada' => isset($_POST['destacada']) ? 1 : 0,
            'categoria_id' => isset($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : 0,
            'tags' => isset($_POST['tags']) ? trim($_POST['tags']) : ''
        ];
        
        // Validar los datos
        if (empty($noticia['titulo']) || empty($noticia['contenido'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias&action=editar&id=' . $id, 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Obtener la noticia actual para verificar si hay una imagen existente
        $noticia_actual = $this->noticia_model->get_by_id($id);
        
        // Procesar la imagen si se subió
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $imagen_filename = $this->upload_file($_FILES['imagen'], UPLOADS_PATH . '/noticias', $allowed_types);
            
            if ($imagen_filename) {
                $noticia['imagen'] = $imagen_filename;
                
                // Eliminar la imagen anterior si existe
                if (!empty($noticia_actual['imagen'])) {
                    $imagen_path = UPLOADS_PATH . '/noticias/' . $noticia_actual['imagen'];
                    if (file_exists($imagen_path)) {
                        unlink($imagen_path);
                    }
                }
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=noticias&action=editar&id=' . $id, 'Error al subir la imagen. Asegúrese de que sea una imagen válida.', 'danger');
            }
        } else {
            // Mantener la imagen existente
            $noticia['imagen'] = $noticia_actual['imagen'];
        }
        
        // Actualizar la noticia en la base de datos
        $result = $this->noticia_model->update($id, $noticia);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias', 'Noticia actualizada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias&action=editar&id=' . $id, 'Error al actualizar la noticia. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Eliminar una noticia
     */
    public function eliminar() {
        // Obtener el ID de la noticia
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias', 'Noticia no encontrada.', 'danger');
        }
        
        // Obtener la noticia para verificar si hay una imagen
        $noticia = $this->noticia_model->get_by_id($id);
        
        if (!$noticia) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias', 'Noticia no encontrada.', 'danger');
        }
        
        // Eliminar la imagen si existe
        if (!empty($noticia['imagen'])) {
            $imagen_path = UPLOADS_PATH . '/noticias/' . $noticia['imagen'];
            if (file_exists($imagen_path)) {
                unlink($imagen_path);
            }
        }
        
        // Eliminar la noticia de la base de datos
        $result = $this->noticia_model->delete($id);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias', 'Noticia eliminada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=noticias', 'Error al eliminar la noticia. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
}