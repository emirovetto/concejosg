<?php
/**
 * Controlador para la gestión de ordenanzas
 */
require_once '../app/admin/controllers/base_controller.php';
require_once MODELS_PATH . '/ordenanza_model.php';
require_once MODELS_PATH . '/categoria_model.php';

class OrdenanzasController extends BaseController {
    private $ordenanza_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->require_admin();
        $this->ordenanza_model = new OrdenanzaModel();
    }
    
    /**
     * Método principal - Listado de ordenanzas
     */
    public function index() {
        // Obtener todas las ordenanzas ordenadas por número (más recientes primero)
        $ordenanzas = $this->ordenanza_model->get_all('numero', 'DESC');
        
        // Cargar la vista
        $this->view('ordenanzas/index', [
            'title' => 'Gestión de Ordenanzas - Panel de Administración',
            'ordenanzas' => $ordenanzas
        ]);
    }
    
    /**
     * Formulario para crear una nueva ordenanza
     */
    public function crear() {
        // Cargar la vista
        $this->view('ordenanzas/form', [
            'title' => 'Nueva Ordenanza - Panel de Administración',
            'action' => 'crear',
            'ordenanza' => [
                'id' => '',
                'numero' => '',
                'anio' => date('Y'),
                'titulo' => '',
                'descripcion' => '',
                'fecha_sancion' => date('Y-m-d'),
                'categoria_id' => '',
                'archivo' => ''
            ]
        ]);
    }
    
    /**
     * Procesar la creación de una nueva ordenanza
     */
    public function guardar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=ordenanzas');
        }
        
        // Obtener los datos del formulario
        $ordenanza = [
            'numero' => isset($_POST['numero']) ? trim($_POST['numero']) : '',
            'anio' => isset($_POST['anio']) ? trim($_POST['anio']) : '',
            'titulo' => isset($_POST['titulo']) ? trim($_POST['titulo']) : '',
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '',
            'fecha_sancion' => isset($_POST['fecha_sancion']) ? trim($_POST['fecha_sancion']) : '',
            'categoria_id' => isset($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : 0
        ];
        
        // Validar los datos
        if (empty($ordenanza['numero']) || empty($ordenanza['anio']) || empty($ordenanza['titulo']) || empty($ordenanza['fecha_sancion']) || $ordenanza['categoria_id'] <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas&action=crear', 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Procesar el archivo si se subió
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['application/pdf'];
            $archivo_filename = $this->upload_file($_FILES['archivo'], UPLOADS_PATH . '/ordenanzas', $allowed_types);
            
            if ($archivo_filename) {
                $ordenanza['archivo'] = $archivo_filename;
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas&action=crear', 'Error al subir el archivo. Asegúrese de que sea un PDF válido.', 'danger');
            }
        }
        
        // Guardar la ordenanza en la base de datos
        $result = $this->ordenanza_model->insert($ordenanza);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas', 'Ordenanza creada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas&action=crear', 'Error al crear la ordenanza. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Formulario para editar una ordenanza existente
     */
    public function editar() {
        // Obtener el ID de la ordenanza
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas', 'Ordenanza no encontrada.', 'danger');
        }
        
        // Obtener la ordenanza por ID
        $ordenanza = $this->ordenanza_model->get_by_id($id);
        
        if (!$ordenanza) {
            $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas', 'Ordenanza no encontrada.', 'danger');
        }
        
        // Cargar la vista
        $this->view('ordenanzas/form', [
            'title' => 'Editar Ordenanza - Panel de Administración',
            'action' => 'actualizar',
            'ordenanza' => $ordenanza
        ]);
    }
    
    /**
     * Procesa el formulario para actualizar una ordenanza existente
     */
    public function actualizar() {
        // Verificar que sea una petición POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/ordenanzas');
        }
        
        // Obtener el ID de la ordenanza
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        
        // Verificar que se proporcionó un ID válido
        if (!$id) {
            set_mensaje('ID de ordenanza no válido', 'danger');
            redirect('admin/ordenanzas');
        }
        
        // Obtener la ordenanza actual para verificar si hay un archivo
        $ordenanza_actual = $this->ordenanza_model->get_by_id($id);
        
        if (!$ordenanza_actual) {
            set_mensaje('La ordenanza no existe', 'danger');
            redirect('admin/ordenanzas');
        }
        
        // Validar los datos del formulario
        $numero = isset($_POST['numero']) ? trim($_POST['numero']) : '';
        $anio = isset($_POST['anio']) ? trim($_POST['anio']) : '';
        $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
        $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
        $fecha_sancion = isset($_POST['fecha_sancion']) ? trim($_POST['fecha_sancion']) : '';
        $categoria_id = isset($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : 0;
        
        // Validar que los campos requeridos no estén vacíos
        if (empty($numero) || empty($anio) || empty($titulo) || empty($descripcion) || empty($fecha_sancion) || empty($categoria_id)) {
            set_mensaje('Todos los campos marcados con * son obligatorios', 'danger');
            redirect('admin/ordenanzas/editar/' . $id);
        }
        
        // Preparar los datos para actualizar
        $data = [
            'numero' => $numero,
            'anio' => $anio,
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha_sancion' => $fecha_sancion,
            'categoria_id' => $categoria_id
        ];
        
        // Manejar la subida del archivo si se proporciona uno nuevo
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $archivo = $_FILES['archivo'];
            $nombre_archivo = time() . '_' . sanitize_filename($archivo['name']);
            $ruta_destino = UPLOADS_PATH . '/ordenanzas/' . $nombre_archivo;
            
            // Verificar que sea un archivo PDF
            $tipo_archivo = mime_content_type($archivo['tmp_name']);
            if ($tipo_archivo !== 'application/pdf') {
                set_mensaje('El archivo debe ser un PDF', 'danger');
                redirect('admin/ordenanzas/editar/' . $id);
            }
            
            // Mover el archivo a la carpeta de destino
            if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
                $data['archivo'] = $nombre_archivo;
                
                // Eliminar el archivo anterior si existe
                if (!empty($ordenanza_actual['archivo'])) {
                    $ruta_archivo_anterior = UPLOADS_PATH . '/ordenanzas/' . $ordenanza_actual['archivo'];
                    if (file_exists($ruta_archivo_anterior)) {
                        unlink($ruta_archivo_anterior);
                    }
                }
            } else {
                set_mensaje('Error al subir el archivo', 'danger');
                redirect('admin/ordenanzas/editar/' . $id);
            }
        }
        
        // Actualizar la ordenanza
        $resultado = $this->ordenanza_model->update($id, $data);
        
        if ($resultado) {
            set_mensaje('Ordenanza actualizada correctamente', 'success');
        } else {
            set_mensaje('Error al actualizar la ordenanza', 'danger');
        }
        
        redirect('admin/ordenanzas');
    }
    
    /**
     * Eliminar una ordenanza
     */
    public function eliminar() {
        // Obtener el ID de la ordenanza
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas', 'Ordenanza no encontrada.', 'danger');
        }
        
        // Obtener la ordenanza para verificar si hay un archivo
        $ordenanza = $this->ordenanza_model->get_by_id($id);
        
        if (!$ordenanza) {
            $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas', 'Ordenanza no encontrada.', 'danger');
        }
        
        // Eliminar el archivo si existe
        if (!empty($ordenanza['archivo'])) {
            $archivo_path = UPLOADS_PATH . '/ordenanzas/' . $ordenanza['archivo'];
            if (file_exists($archivo_path)) {
                unlink($archivo_path);
            }
        }
        
        // Eliminar la ordenanza de la base de datos
        $result = $this->ordenanza_model->delete($id);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas', 'Ordenanza eliminada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=ordenanzas', 'Error al eliminar la ordenanza. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
} 