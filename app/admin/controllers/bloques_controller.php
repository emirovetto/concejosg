<?php
/**
 * Controlador para la gestión de bloques políticos
 */
require_once '../app/admin/controllers/base_controller.php';
require_once MODELS_PATH . '/bloque_model.php';
require_once MODELS_PATH . '/concejal_model.php';

class BloquesController extends BaseController {
    private $bloque_model;
    private $concejal_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->require_admin();
        $this->bloque_model = new BloqueModel();
        $this->concejal_model = new ConcejalModel();
    }
    
    /**
     * Método principal - Listado de bloques
     */
    public function index() {
        // Obtener todos los bloques con la cantidad de concejales
        $bloques = $this->bloque_model->get_with_count();
        
        // Cargar la vista
        $this->view('bloques/index', [
            'title' => 'Gestión de Bloques Políticos - Panel de Administración',
            'bloques' => $bloques
        ]);
    }
    
    /**
     * Formulario para crear un nuevo bloque
     */
    public function crear() {
        // Cargar la vista
        $this->view('bloques/form', [
            'title' => 'Nuevo Bloque Político - Panel de Administración',
            'action' => 'guardar',
            'bloque' => [
                'id' => '',
                'nombre' => '',
                'descripcion' => '',
                'color' => '#3498db',
                'logo' => ''
            ]
        ]);
    }
    
    /**
     * Procesar la creación de un nuevo bloque
     */
    public function guardar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=bloques');
        }
        
        // Obtener los datos del formulario
        $bloque = [
            'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '',
            'color' => isset($_POST['color']) ? trim($_POST['color']) : '#3498db'
        ];
        
        // Validar los datos
        if (empty($bloque['nombre'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques&action=crear', 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Procesar el logo si se subió
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $logo_filename = $this->upload_file($_FILES['logo'], UPLOADS_PATH . '/bloques', $allowed_types);
            
            if ($logo_filename) {
                $bloque['logo'] = $logo_filename;
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=bloques&action=crear', 'Error al subir el logo. Asegúrese de que sea una imagen válida.', 'danger');
            }
        }
        
        // Guardar el bloque en la base de datos
        $result = $this->bloque_model->insert($bloque);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'Bloque político creado correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques&action=crear', 'Error al crear el bloque político. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Formulario para editar un bloque existente
     */
    public function editar() {
        // Obtener el ID del bloque
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'Bloque político no encontrado.', 'danger');
        }
        
        // Obtener el bloque por ID
        $bloque = $this->bloque_model->get_by_id($id);
        
        if (!$bloque) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'Bloque político no encontrado.', 'danger');
        }
        
        // Cargar la vista
        $this->view('bloques/form', [
            'title' => 'Editar Bloque Político - Panel de Administración',
            'action' => 'actualizar',
            'bloque' => $bloque
        ]);
    }
    
    /**
     * Procesar la actualización de un bloque existente
     */
    public function actualizar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=bloques');
        }
        
        // Obtener el ID del bloque
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'Bloque político no encontrado.', 'danger');
        }
        
        // Obtener los datos del formulario
        $bloque = [
            'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '',
            'color' => isset($_POST['color']) ? trim($_POST['color']) : '#3498db'
        ];
        
        // Validar los datos
        if (empty($bloque['nombre'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques&action=editar&id=' . $id, 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Obtener el bloque actual para verificar si hay un logo existente
        $bloque_actual = $this->bloque_model->get_by_id($id);
        
        // Procesar el logo si se subió
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $logo_filename = $this->upload_file($_FILES['logo'], UPLOADS_PATH . '/bloques', $allowed_types);
            
            if ($logo_filename) {
                $bloque['logo'] = $logo_filename;
                
                // Eliminar el logo anterior si existe
                if (!empty($bloque_actual['logo'])) {
                    $logo_path = UPLOADS_PATH . '/bloques/' . $bloque_actual['logo'];
                    if (file_exists($logo_path)) {
                        unlink($logo_path);
                    }
                }
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=bloques&action=editar&id=' . $id, 'Error al subir el logo. Asegúrese de que sea una imagen válida.', 'danger');
            }
        } else {
            // Mantener el logo existente
            $bloque['logo'] = $bloque_actual['logo'];
        }
        
        // Actualizar el bloque en la base de datos
        $result = $this->bloque_model->update($id, $bloque);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'Bloque político actualizado correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques&action=editar&id=' . $id, 'Error al actualizar el bloque político. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Eliminar un bloque
     */
    public function eliminar() {
        // Obtener el ID del bloque
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'Bloque político no encontrado.', 'danger');
        }
        
        // Verificar si hay concejales asociados a este bloque
        $concejales = $this->concejal_model->get_by_bloque($id);
        
        if (!empty($concejales)) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'No se puede eliminar el bloque porque tiene concejales asociados.', 'danger');
            return;
        }
        
        // Obtener el bloque para verificar si hay un logo
        $bloque = $this->bloque_model->get_by_id($id);
        
        if (!$bloque) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'Bloque político no encontrado.', 'danger');
        }
        
        // Eliminar el logo si existe
        if (!empty($bloque['logo'])) {
            $logo_path = UPLOADS_PATH . '/bloques/' . $bloque['logo'];
            if (file_exists($logo_path)) {
                unlink($logo_path);
            }
        }
        
        // Eliminar el bloque de la base de datos
        $result = $this->bloque_model->delete($id);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'Bloque político eliminado correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=bloques', 'Error al eliminar el bloque político. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
} 