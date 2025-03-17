<?php
/**
 * Controlador para la gestión de configuración del sitio
 */
require_once '../app/admin/controllers/base_controller.php';
require_once MODELS_PATH . '/configuracion_model.php';

class ConfiguracionController extends BaseController {
    private $configuracion_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->require_admin();
        $this->configuracion_model = new ConfiguracionModel();
    }
    
    /**
     * Método principal - Formulario de configuración
     */
    public function index() {
        // Obtener todas las configuraciones
        $configuraciones = $this->configuracion_model->get_all_as_array();
        
        // Cargar la vista
        $this->view('configuracion/index', [
            'title' => 'Configuración del Sitio - Panel de Administración',
            'configuraciones' => $configuraciones
        ]);
    }
    
    /**
     * Procesar la actualización de la configuración
     */
    public function actualizar() {
        // Verificar si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(ADMIN_URL . '/?section=configuracion');
        }
        
        // Obtener los datos del formulario
        $configuraciones = $_POST['config'] ?? [];
        
        // Validar los datos
        if (empty($configuraciones)) {
            $this->redirect_with_message(ADMIN_URL . '/?section=configuracion', 'No se recibieron datos de configuración.', 'danger');
        }
        
        // Actualizar cada configuración
        $success = true;
        foreach ($configuraciones as $clave => $valor) {
            $result = $this->configuracion_model->update_by_clave($clave, $valor);
            if (!$result) {
                $success = false;
            }
        }
        
        // Manejar la subida de archivos (logo, favicon, etc.)
        if (!empty($_FILES['logo']['name'])) {
            $logo = $this->upload_file(
                $_FILES['logo'],
                UPLOADS_PATH . '/configuracion',
                ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                2097152 // 2MB
            );
            
            if ($logo) {
                $this->configuracion_model->update_by_clave('site_logo', $logo);
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=configuracion', 'Error al subir el logo. Verifique el formato y tamaño.', 'danger');
            }
        }
        
        if (!empty($_FILES['favicon']['name'])) {
            $favicon = $this->upload_file(
                $_FILES['favicon'],
                UPLOADS_PATH . '/configuracion',
                ['image/x-icon', 'image/png', 'image/jpeg'],
                1048576 // 1MB
            );
            
            if ($favicon) {
                $this->configuracion_model->update_by_clave('site_favicon', $favicon);
            } else {
                $this->redirect_with_message(ADMIN_URL . '/?section=configuracion', 'Error al subir el favicon. Verifique el formato y tamaño.', 'danger');
            }
        }
        
        if ($success) {
            $this->redirect_with_message(ADMIN_URL . '/?section=configuracion', 'Configuración actualizada correctamente.', 'success');
        } else {
            $this->redirect_with_message(ADMIN_URL . '/?section=configuracion', 'Error al actualizar algunas configuraciones. Por favor, inténtelo de nuevo.', 'warning');
        }
    }
} 