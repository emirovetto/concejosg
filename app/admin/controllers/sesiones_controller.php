<?php
/**
 * Controlador para la gestión de sesiones
 */
require_once '../app/admin/controllers/base_controller.php';
require_once MODELS_PATH . '/sesion_model.php';

class SesionesController extends BaseController {
    private $sesion_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->require_admin();
        $this->sesion_model = new SesionModel();
    }
    
    /**
     * Método principal - Listado de sesiones
     */
    public function index() {
        // Obtener todas las sesiones ordenadas por fecha (más recientes primero)
        $sesiones = $this->sesion_model->get_all('fecha', 'DESC');
        
        // Cargar la vista
        $this->view('sesiones/index', [
            'title' => 'Gestión de Sesiones - Panel de Administración',
            'sesiones' => $sesiones
        ]);
    }
    
    /**
     * Formulario para crear una nueva sesión
     */
    public function crear() {
        // Cargar la vista
        $this->view('sesiones/form', [
            'title' => 'Nueva Sesión - Panel de Administración',
            'action' => 'crear',
            'sesion' => [
                'id' => '',
                'titulo' => '',
                'descripcion' => '',
                'fecha' => date('Y-m-d'),
                'hora' => '19:00',
                'lugar' => 'Sala de Sesiones del Concejo Deliberante',
                'tipo' => 'ordinaria',
                'estado' => 'programada',
                'video_url' => '',
                'acta' => ''
            ]
        ]);
    }
    
    /**
     * Procesar la creación de una nueva sesión
     */
    public function guardar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=sesiones');
        }
        
        // Obtener los datos del formulario
        $sesion = [
            'titulo' => isset($_POST['titulo']) ? trim($_POST['titulo']) : '',
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '',
            'fecha' => isset($_POST['fecha']) ? trim($_POST['fecha']) : '',
            'hora' => isset($_POST['hora']) ? trim($_POST['hora']) : '',
            'lugar' => isset($_POST['lugar']) ? trim($_POST['lugar']) : '',
            'tipo' => isset($_POST['tipo']) ? trim($_POST['tipo']) : '',
            'estado' => isset($_POST['estado']) ? trim($_POST['estado']) : '',
            'video_url' => isset($_POST['video_url']) ? trim($_POST['video_url']) : ''
        ];
        
        // Validar los datos
        if (empty($sesion['titulo']) || empty($sesion['fecha']) || empty($sesion['hora']) || empty($sesion['lugar']) || empty($sesion['tipo']) || empty($sesion['estado'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones&action=crear', 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Procesar el archivo de acta si se subió
        if (isset($_FILES['acta']) && $_FILES['acta']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['application/pdf'];
            $acta_filename = $this->upload_file($_FILES['acta'], UPLOADS_PATH . '/sesiones', $allowed_types);
            
            if ($acta_filename) {
                $sesion['acta'] = $acta_filename;
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=sesiones&action=crear', 'Error al subir el archivo. Asegúrese de que sea un PDF válido.', 'danger');
            }
        }
        
        // Guardar la sesión en la base de datos
        $result = $this->sesion_model->insert($sesion);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones', 'Sesión creada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones&action=crear', 'Error al crear la sesión. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Formulario para editar una sesión existente
     */
    public function editar() {
        // Obtener el ID de la sesión
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones', 'Sesión no encontrada.', 'danger');
        }
        
        // Obtener la sesión por ID
        $sesion = $this->sesion_model->get_by_id($id);
        
        if (!$sesion) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones', 'Sesión no encontrada.', 'danger');
        }
        
        // Cargar la vista
        $this->view('sesiones/form', [
            'title' => 'Editar Sesión - Panel de Administración',
            'action' => 'actualizar',
            'sesion' => $sesion
        ]);
    }
    
    /**
     * Procesar la actualización de una sesión existente
     */
    public function actualizar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=sesiones');
        }
        
        // Obtener el ID de la sesión
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones', 'Sesión no encontrada.', 'danger');
        }
        
        // Obtener los datos del formulario
        $sesion = [
            'id' => $id,
            'titulo' => isset($_POST['titulo']) ? trim($_POST['titulo']) : '',
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '',
            'fecha' => isset($_POST['fecha']) ? trim($_POST['fecha']) : '',
            'hora' => isset($_POST['hora']) ? trim($_POST['hora']) : '',
            'lugar' => isset($_POST['lugar']) ? trim($_POST['lugar']) : '',
            'tipo' => isset($_POST['tipo']) ? trim($_POST['tipo']) : '',
            'estado' => isset($_POST['estado']) ? trim($_POST['estado']) : '',
            'video_url' => isset($_POST['video_url']) ? trim($_POST['video_url']) : ''
        ];
        
        // Validar los datos
        if (empty($sesion['titulo']) || empty($sesion['fecha']) || empty($sesion['hora']) || empty($sesion['lugar']) || empty($sesion['tipo']) || empty($sesion['estado'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones&action=editar&id=' . $id, 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Obtener la sesión actual para verificar si hay un acta existente
        $sesion_actual = $this->sesion_model->get_by_id($id);
        
        // Procesar el archivo de acta si se subió
        if (isset($_FILES['acta']) && $_FILES['acta']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['application/pdf'];
            $acta_filename = $this->upload_file($_FILES['acta'], UPLOADS_PATH . '/sesiones', $allowed_types);
            
            if ($acta_filename) {
                $sesion['acta'] = $acta_filename;
                
                // Eliminar el archivo anterior si existe
                if (!empty($sesion_actual['acta'])) {
                    $acta_path = UPLOADS_PATH . '/sesiones/' . $sesion_actual['acta'];
                    if (file_exists($acta_path)) {
                        unlink($acta_path);
                    }
                }
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=sesiones&action=editar&id=' . $id, 'Error al subir el archivo. Asegúrese de que sea un PDF válido.', 'danger');
            }
        } else {
            // Mantener el acta existente
            $sesion['acta'] = $sesion_actual['acta'];
        }
        
        // Actualizar la sesión en la base de datos
        $result = $this->sesion_model->update($id, $sesion);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones', 'Sesión actualizada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones&action=editar&id=' . $id, 'Error al actualizar la sesión. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Eliminar una sesión
     */
    public function eliminar() {
        // Obtener el ID de la sesión
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones', 'Sesión no encontrada.', 'danger');
        }
        
        // Obtener la sesión para verificar si hay un acta
        $sesion = $this->sesion_model->get_by_id($id);
        
        if (!$sesion) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones', 'Sesión no encontrada.', 'danger');
        }
        
        // Eliminar el archivo de acta si existe
        if (!empty($sesion['acta'])) {
            $acta_path = UPLOADS_PATH . '/sesiones/' . $sesion['acta'];
            if (file_exists($acta_path)) {
                unlink($acta_path);
            }
        }
        
        // Eliminar la sesión de la base de datos
        $result = $this->sesion_model->delete($id);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones', 'Sesión eliminada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=sesiones', 'Error al eliminar la sesión. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
} 