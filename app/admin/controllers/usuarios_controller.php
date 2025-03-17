<?php
/**
 * Controlador para la gestión de usuarios
 */
require_once '../app/admin/controllers/base_controller.php';
require_once MODELS_PATH . '/usuario_model.php';

class UsuariosController extends BaseController {
    private $usuario_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->require_admin();
        $this->usuario_model = new UsuarioModel();
    }
    
    /**
     * Método principal - Listado de usuarios
     */
    public function index() {
        // Obtener todos los usuarios
        $usuarios = $this->usuario_model->get_all();
        
        // Cargar la vista
        $this->view('usuarios/index', [
            'title' => 'Gestión de Usuarios - Panel de Administración',
            'usuarios' => $usuarios
        ]);
    }
    
    /**
     * Formulario para crear un nuevo usuario
     */
    public function crear() {
        // Cargar la vista
        $this->view('usuarios/form', [
            'title' => 'Nuevo Usuario - Panel de Administración',
            'action' => 'guardar',
            'usuario' => [
                'id' => '',
                'nombre' => '',
                'apellido' => '',
                'email' => '',
                'username' => '',
                'role' => 'editor',
                'estado' => 'activo'
            ]
        ]);
    }
    
    /**
     * Procesar la creación de un nuevo usuario
     */
    public function guardar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=usuarios');
        }
        
        // Obtener los datos del formulario
        $usuario = [
            'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
            'apellido' => isset($_POST['apellido']) ? trim($_POST['apellido']) : '',
            'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
            'username' => isset($_POST['username']) ? trim($_POST['username']) : '',
            'password' => isset($_POST['password']) ? $_POST['password'] : '',
            'role' => isset($_POST['role']) ? trim($_POST['role']) : 'editor',
            'estado' => isset($_POST['estado']) ? trim($_POST['estado']) : 'activo'
        ];
        
        // Validar los datos
        if (empty($usuario['nombre']) || empty($usuario['apellido']) || empty($usuario['email']) || 
            empty($usuario['username']) || empty($usuario['password'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios&action=crear', 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Verificar si el email ya existe
        if ($this->usuario_model->email_exists($usuario['email'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios&action=crear', 'El email ya está registrado. Por favor, utilice otro.', 'danger');
        }
        
        // Verificar si el username ya existe
        if ($this->usuario_model->username_exists($usuario['username'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios&action=crear', 'El nombre de usuario ya está registrado. Por favor, utilice otro.', 'danger');
        }
        
        // Encriptar la contraseña
        $usuario['password'] = password_hash_secure($usuario['password']);
        
        // Guardar el usuario en la base de datos
        $result = $this->usuario_model->insert($usuario);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'Usuario creado correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios&action=crear', 'Error al crear el usuario. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Formulario para editar un usuario existente
     */
    public function editar() {
        // Obtener el ID del usuario
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'Usuario no encontrado.', 'danger');
        }
        
        // Obtener el usuario por ID
        $usuario = $this->usuario_model->get_by_id($id);
        
        if (!$usuario) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'Usuario no encontrado.', 'danger');
        }
        
        // Cargar la vista
        $this->view('usuarios/form', [
            'title' => 'Editar Usuario - Panel de Administración',
            'action' => 'actualizar',
            'usuario' => $usuario
        ]);
    }
    
    /**
     * Procesar la actualización de un usuario existente
     */
    public function actualizar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=usuarios');
        }
        
        // Obtener el ID del usuario
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'Usuario no encontrado.', 'danger');
        }
        
        // Obtener el usuario actual
        $usuario_actual = $this->usuario_model->get_by_id($id);
        
        if (!$usuario_actual) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'Usuario no encontrado.', 'danger');
        }
        
        // Obtener los datos del formulario
        $usuario = [
            'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
            'apellido' => isset($_POST['apellido']) ? trim($_POST['apellido']) : '',
            'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
            'username' => isset($_POST['username']) ? trim($_POST['username']) : '',
            'role' => isset($_POST['role']) ? trim($_POST['role']) : 'editor',
            'estado' => isset($_POST['estado']) ? trim($_POST['estado']) : 'activo'
        ];
        
        // Validar los datos
        if (empty($usuario['nombre']) || empty($usuario['apellido']) || empty($usuario['email']) || 
            empty($usuario['username'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios&action=editar&id=' . $id, 'Por favor, complete todos los campos obligatorios.', 'danger');
        }
        
        // Verificar si el email ya existe (excepto para el usuario actual)
        if ($usuario['email'] !== $usuario_actual['email'] && $this->usuario_model->email_exists($usuario['email'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios&action=editar&id=' . $id, 'El email ya está registrado. Por favor, utilice otro.', 'danger');
        }
        
        // Verificar si el username ya existe (excepto para el usuario actual)
        if ($usuario['username'] !== $usuario_actual['username'] && $this->usuario_model->username_exists($usuario['username'])) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios&action=editar&id=' . $id, 'El nombre de usuario ya está registrado. Por favor, utilice otro.', 'danger');
        }
        
        // Verificar si se proporcionó una nueva contraseña
        if (!empty($_POST['password'])) {
            $usuario['password'] = password_hash_secure($_POST['password']);
        }
        
        // Actualizar el usuario en la base de datos
        $result = $this->usuario_model->update($id, $usuario);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'Usuario actualizado correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios&action=editar&id=' . $id, 'Error al actualizar el usuario. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Eliminar un usuario
     */
    public function eliminar() {
        // Obtener el ID del usuario
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'Usuario no encontrado.', 'danger');
        }
        
        // Verificar que no se esté eliminando a sí mismo
        if ($id == $_SESSION['user_id']) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'No puede eliminar su propio usuario.', 'danger');
        }
        
        // Eliminar el usuario de la base de datos
        $result = $this->usuario_model->delete($id);
        
        if ($result) {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'Usuario eliminado correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=usuarios', 'Error al eliminar el usuario. Por favor, inténtelo de nuevo.', 'danger');
        }
    }
    
    /**
     * Ver y editar el perfil del usuario actual
     */
    public function perfil() {
        // Obtener el usuario actual
        $usuario = $this->usuario_model->get_by_id($_SESSION['user_id']);
        
        if (!$usuario) {
            $this->redirect_with_message(ADMIN_URL, 'Usuario no encontrado.', 'danger');
        }
        
        // Cargar la vista
        $this->view('usuarios/perfil', [
            'title' => 'Mi Perfil - Panel de Administración',
            'usuario' => $usuario
        ]);
    }
} 