<?php
/**
 * Controlador base para el panel de administración
 */

// Verificar que los archivos de configuración estén disponibles
$config_file = realpath('../app/config/config.php');
$admin_config_file = realpath('../app/admin/config.php');
$functions_file = realpath('../app/includes/functions.php');

// Verificar si existen los archivos requeridos
if (!$config_file || !file_exists($config_file)) {
    die('Error crítico: No se encuentra el archivo de configuración principal. Ruta buscada: ' . realpath('../app/config/config.php'));
}

if (!$admin_config_file || !file_exists($admin_config_file)) {
    die('Error crítico: No se encuentra el archivo de configuración del admin. Ruta buscada: ' . realpath('../app/admin/config.php'));
}

if (!$functions_file || !file_exists($functions_file)) {
    die('Error crítico: No se encuentra el archivo de funciones. Ruta buscada: ' . realpath('../app/includes/functions.php'));
}

// Cargar los archivos
require_once $config_file;
require_once $admin_config_file;
require_once $functions_file;

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
     * Carga una vista dentro de la plantilla maestra
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
        
        // Verificar que exista el archivo de la vista
        $view_file = ADMIN_VIEWS_PATH . '/' . $view . '.php';
        $master_template = ROOT_PATH . '/admin/master-template.php';
        
        if (!file_exists($view_file)) {
            error_log('El archivo de vista ' . $view . '.php no existe: ' . $view_file);
            die('Error crítico: No se encuentra el archivo de vista solicitado.');
        }
        
        if (!file_exists($master_template)) {
            error_log('El archivo de plantilla maestra no existe: ' . $master_template);
            die('Error crítico: No se encuentra el archivo de plantilla maestra.');
        }
        
        // Capturar la salida de la vista
        ob_start();
        include $view_file;
        $content = ob_get_clean();
        
        // Indicar que este acceso es válido para la plantilla maestra
        define('ADMIN_ACCESS', true);
        
        // Incluir la plantilla maestra con el contenido de la vista
        include $master_template;
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