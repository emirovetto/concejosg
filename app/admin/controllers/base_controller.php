<?php
/**
 * Controlador base para el panel de administración
 */
require_once '../app/config/config.php';
require_once '../app/admin/config.php';
require_once '../app/includes/functions.php';

class BaseController {
    /**
     * Verifica que el usuario tenga acceso de administrador
     */
    protected function require_admin() {
        if (!is_admin()) {
            // Redirigir al login
            header('Location: ' . ADMIN_URL . '/login.php');
            exit;
        }
    }
    
    /**
     * Carga una vista
     * 
     * @param string $view Nombre de la vista a cargar
     * @param array $data Datos a pasar a la vista
     */
    protected function view($view, $data = []) {
        // Verificar que el usuario tenga acceso de administrador
        $this->require_admin();
        
        // Obtener la sección actual
        $section = isset($_GET['section']) ? $_GET['section'] : 'dashboard';
        
        // Extraer los datos para que estén disponibles en la vista
        extract($data);
        
        // Verificar que existan los archivos de la plantilla
        $header_file = ADMIN_VIEWS_PATH . '/templates/header.php';
        $sidebar_file = ADMIN_VIEWS_PATH . '/templates/sidebar.php';
        $footer_file = ADMIN_VIEWS_PATH . '/templates/footer.php';
        $view_file = ADMIN_VIEWS_PATH . '/' . $view . '.php';
        
        if (!file_exists($header_file)) {
            die('El archivo de plantilla header.php no existe: ' . $header_file);
        }
        
        if (!file_exists($sidebar_file)) {
            die('El archivo de plantilla sidebar.php no existe: ' . $sidebar_file);
        }
        
        if (!file_exists($view_file)) {
            die('El archivo de vista ' . $view . '.php no existe: ' . $view_file);
        }
        
        if (!file_exists($footer_file)) {
            die('El archivo de plantilla footer.php no existe: ' . $footer_file);
        }
        
        // Incluir el header
        require_once $header_file;
        
        // Incluir el sidebar
        require_once $sidebar_file;
        
        // Incluir la vista
        require_once $view_file;
        
        // Incluir el footer
        require_once $footer_file;
    }
    
    /**
     * Redirige a una URL con un mensaje
     * 
     * @param string $url URL a la que redirigir
     * @param string $message Mensaje a mostrar
     * @param string $type Tipo de mensaje (success, danger, warning, info)
     */
    protected function redirect_with_message($url, $message, $type = 'info') {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Sube un archivo al servidor
     * 
     * @param array $file Archivo a subir ($_FILES['nombre'])
     * @param string $destination Directorio de destino
     * @param array $allowed_types Tipos MIME permitidos
     * @param int $max_size Tamaño máximo en bytes (por defecto 2MB)
     * @return string|bool Nombre del archivo subido o false si hay error
     */
    protected function upload_file($file, $destination, $allowed_types = [], $max_size = 2097152) {
        // Verificar que no haya errores
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        // Verificar el tamaño
        if ($file['size'] > $max_size) {
            return false;
        }
        
        // Verificar el tipo MIME
        if (!empty($allowed_types) && !in_array($file['type'], $allowed_types)) {
            return false;
        }
        
        // Crear el directorio si no existe
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }
        
        // Generar un nombre único para el archivo
        $filename = uniqid() . '_' . basename($file['name']);
        $target_path = $destination . '/' . $filename;
        
        // Mover el archivo
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            return $filename;
        }
        
        return false;
    }
} 