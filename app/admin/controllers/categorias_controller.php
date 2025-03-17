<?php
/**
 * Controlador para la gestión de categorías
 */
require_once '../app/admin/controllers/base_controller.php';
require_once MODELS_PATH . '/categoria_model.php';

class CategoriasController extends BaseController {
    private $categoria_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->require_admin();
        $this->categoria_model = new CategoriaModel();
    }
    
    /**
     * Método principal - Listado de categorías
     */
    public function index() {
        // Obtener todas las categorías con conteo de noticias
        $categorias = $this->categoria_model->get_with_count();
        
        // Cargar la vista
        $this->view('categorias/index', [
            'title' => 'Gestión de Categorías - Panel de Administración',
            'categorias' => $categorias
        ]);
    }
    
    /**
     * Formulario para crear una nueva categoría
     */
    public function crear() {
        // Cargar la vista
        $this->view('categorias/form', [
            'title' => 'Nueva Categoría - Panel de Administración',
            'action' => 'guardar',
            'categoria' => [
                'id' => '',
                'nombre' => '',
                'descripcion' => ''
            ]
        ]);
    }
    
    /**
     * Procesar la creación de una nueva categoría
     */
    public function guardar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=categorias');
        }
        
        // Obtener los datos del formulario
        $categoria = [
            'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : ''
        ];
        
        // Validar los datos
        if (empty($categoria['nombre'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias&action=crear', 'Por favor, ingrese el nombre de la categoría.', 'danger');
        }
        
        // Guardar la categoría en la base de datos
        $result = $this->categoria_model->insert($categoria);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias', 'Categoría creada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias&action=crear', 'Error al crear la categoría. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Formulario para editar una categoría existente
     */
    public function editar() {
        // Obtener el ID de la categoría
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias', 'Categoría no encontrada.', 'danger');
        }
        
        // Obtener la categoría por ID
        $categoria = $this->categoria_model->get_by_id($id);
        
        if (!$categoria) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias', 'Categoría no encontrada.', 'danger');
        }
        
        // Cargar la vista
        $this->view('categorias/form', [
            'title' => 'Editar Categoría - Panel de Administración',
            'action' => 'actualizar',
            'categoria' => $categoria
        ]);
    }
    
    /**
     * Procesar la actualización de una categoría existente
     */
    public function actualizar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=categorias');
        }
        
        // Obtener el ID de la categoría
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias', 'Categoría no encontrada.', 'danger');
        }
        
        // Obtener los datos del formulario
        $categoria = [
            'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
            'descripcion' => isset($_POST['descripcion']) ? trim($_POST['descripcion']) : ''
        ];
        
        // Validar los datos
        if (empty($categoria['nombre'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias&action=editar&id=' . $id, 'Por favor, ingrese el nombre de la categoría.', 'danger');
        }
        
        // Actualizar la categoría en la base de datos
        $result = $this->categoria_model->update($id, $categoria);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias', 'Categoría actualizada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias&action=editar&id=' . $id, 'Error al actualizar la categoría. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Eliminar una categoría
     */
    public function eliminar() {
        // Obtener el ID de la categoría
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias', 'Categoría no encontrada.', 'danger');
        }
        
        // Verificar si la categoría tiene noticias asociadas
        if ($this->categoria_model->has_noticias($id)) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias', 'No se puede eliminar la categoría porque tiene noticias asociadas.', 'danger');
        }
        
        // Eliminar la categoría de la base de datos
        $result = $this->categoria_model->delete($id);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias', 'Categoría eliminada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=categorias', 'Error al eliminar la categoría. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
} 