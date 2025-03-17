<?php
/**
 * Controlador para la gestión de concejales
 */
require_once '../app/admin/controllers/base_controller.php';
require_once MODELS_PATH . '/concejal_model.php';
require_once MODELS_PATH . '/bloque_model.php';

class ConcejalesController extends BaseController {
    private $concejal_model;
    private $bloque_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->require_admin();
        $this->concejal_model = new ConcejalModel();
        $this->bloque_model = new BloqueModel();
    }
    
    /**
     * Método principal - Listado de concejales
     */
    public function index() {
        // Obtener todos los concejales ordenados por apellido
        $concejales = $this->concejal_model->get_all('apellido', 'ASC');
        
        // Obtener los bloques para mostrar el nombre en lugar del ID
        $bloques = [];
        $bloques_data = $this->bloque_model->get_all();
        foreach ($bloques_data as $bloque) {
            $bloques[$bloque['id']] = $bloque['nombre'];
        }
        
        // Cargar la vista
        $this->view('concejales/index', [
            'title' => 'Gestión de Concejales - Panel de Administración',
            'concejales' => $concejales,
            'bloques' => $bloques
        ]);
    }
    
    /**
     * Formulario para crear un nuevo concejal
     */
    public function crear() {
        // Obtener los bloques para el select
        $bloques = $this->bloque_model->get_all();
        
        // Cargar la vista
        $this->view('concejales/form', [
            'title' => 'Nuevo Concejal - Panel de Administración',
            'action' => 'guardar',
            'concejal' => [
                'id' => '',
                'nombre' => '',
                'apellido' => '',
                'cargo' => '',
                'bloque_id' => '',
                'email' => '',
                'telefono' => '',
                'biografia' => '',
                'foto' => '',
                'redes' => '{}',
                'estado' => 'activo'
            ],
            'bloques' => $bloques
        ]);
    }
    
    /**
     * Procesar la creación de un nuevo concejal
     */
    public function guardar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=concejales');
        }
        
        // Obtener los datos del formulario
        $concejal = [
            'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
            'apellido' => isset($_POST['apellido']) ? trim($_POST['apellido']) : '',
            'cargo' => isset($_POST['cargo']) ? trim($_POST['cargo']) : '',
            'bloque_id' => isset($_POST['bloque_id']) ? (int)$_POST['bloque_id'] : 0,
            'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
            'telefono' => isset($_POST['telefono']) ? trim($_POST['telefono']) : '',
            'biografia' => isset($_POST['biografia']) ? trim($_POST['biografia']) : '',
            'redes' => isset($_POST['redes']) ? trim($_POST['redes']) : '{}',
            'estado' => isset($_POST['estado']) ? trim($_POST['estado']) : 'activo'
        ];
        
        // Validar los datos
        if (empty($concejal['nombre']) || empty($concejal['apellido']) || empty($concejal['cargo']) || empty($concejal['bloque_id'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales&action=crear', 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Procesar la foto si se subió
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $foto_filename = $this->upload_file($_FILES['foto'], UPLOADS_PATH . '/concejales', $allowed_types);
            
            if ($foto_filename) {
                $concejal['foto'] = $foto_filename;
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=concejales&action=crear', 'Error al subir la foto. Asegúrese de que sea una imagen válida.', 'danger');
            }
        }
        
        // Guardar el concejal en la base de datos
        $result = $this->concejal_model->insert($concejal);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales', 'Concejal creado correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales&action=crear', 'Error al crear el concejal. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Formulario para editar un concejal existente
     */
    public function editar() {
        // Obtener el ID del concejal
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales', 'Concejal no encontrado.', 'danger');
        }
        
        // Obtener el concejal por ID
        $concejal = $this->concejal_model->get_by_id($id);
        
        if (!$concejal) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales', 'Concejal no encontrado.', 'danger');
        }
        
        // Obtener los bloques para el select
        $bloques = $this->bloque_model->get_all();
        
        // Cargar la vista
        $this->view('concejales/form', [
            'title' => 'Editar Concejal - Panel de Administración',
            'action' => 'actualizar',
            'concejal' => $concejal,
            'bloques' => $bloques
        ]);
    }
    
    /**
     * Procesar la actualización de un concejal existente
     */
    public function actualizar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=concejales');
        }
        
        // Obtener el ID del concejal
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales', 'Concejal no encontrado.', 'danger');
        }
        
        // Obtener los datos del formulario
        $concejal = [
            'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
            'apellido' => isset($_POST['apellido']) ? trim($_POST['apellido']) : '',
            'cargo' => isset($_POST['cargo']) ? trim($_POST['cargo']) : '',
            'bloque_id' => isset($_POST['bloque_id']) ? (int)$_POST['bloque_id'] : 0,
            'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
            'telefono' => isset($_POST['telefono']) ? trim($_POST['telefono']) : '',
            'biografia' => isset($_POST['biografia']) ? trim($_POST['biografia']) : '',
            'redes' => isset($_POST['redes']) ? trim($_POST['redes']) : '{}',
            'estado' => isset($_POST['estado']) ? trim($_POST['estado']) : 'activo'
        ];
        
        // Validar los datos
        if (empty($concejal['nombre']) || empty($concejal['apellido']) || empty($concejal['cargo']) || empty($concejal['bloque_id'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales&action=editar&id=' . $id, 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Obtener el concejal actual para verificar si hay una foto existente
        $concejal_actual = $this->concejal_model->get_by_id($id);
        
        // Procesar la foto si se subió
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $foto_filename = $this->upload_file($_FILES['foto'], UPLOADS_PATH . '/concejales', $allowed_types);
            
            if ($foto_filename) {
                $concejal['foto'] = $foto_filename;
                
                // Eliminar la foto anterior si existe
                if (!empty($concejal_actual['foto'])) {
                    $foto_path = UPLOADS_PATH . '/concejales/' . $concejal_actual['foto'];
                    if (file_exists($foto_path)) {
                        unlink($foto_path);
                    }
                }
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=concejales&action=editar&id=' . $id, 'Error al subir la foto. Asegúrese de que sea una imagen válida.', 'danger');
            }
        } else {
            // Mantener la foto existente
            $concejal['foto'] = $concejal_actual['foto'];
        }
        
        // Actualizar el concejal en la base de datos
        $result = $this->concejal_model->update($id, $concejal);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales', 'Concejal actualizado correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales&action=editar&id=' . $id, 'Error al actualizar el concejal. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Eliminar un concejal
     */
    public function eliminar() {
        // Obtener el ID del concejal
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales', 'Concejal no encontrado.', 'danger');
        }
        
        // Obtener el concejal para verificar si hay una foto
        $concejal = $this->concejal_model->get_by_id($id);
        
        if (!$concejal) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales', 'Concejal no encontrado.', 'danger');
        }
        
        // Eliminar la foto si existe
        if (!empty($concejal['foto'])) {
            $foto_path = UPLOADS_PATH . '/concejales/' . $concejal['foto'];
            if (file_exists($foto_path)) {
                unlink($foto_path);
            }
        }
        
        // Eliminar el concejal de la base de datos
        $result = $this->concejal_model->delete($id);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales', 'Concejal eliminado correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=concejales', 'Error al eliminar el concejal. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
} 