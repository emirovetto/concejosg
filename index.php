<?php
/**
 * Punto de entrada principal para el sitio web del Concejo Deliberante de San Genaro
 */

// Iniciar sesión
session_start();

// Cargar configuración
require_once 'app/config/config.php';
require_once 'app/includes/functions.php';

// Mostrar información de depuración solo cuando se solicite explícitamente
if (isset($_GET['debug']) && $_GET['debug'] === '1' && isset($_GET['admin_debug']) && $_GET['admin_debug'] === 'rovetto5') {
    echo '<pre>';
    echo 'SITE_URL: ' . SITE_URL . '<br>';
    echo 'BASE_URL: ' . BASE_URL . '<br>';
    echo 'ADMIN_URL: ' . ADMIN_URL . '<br>';
    echo 'ROOT_PATH: ' . ROOT_PATH . '<br>';
    echo 'APP_PATH: ' . APP_PATH . '<br>';
    echo 'CONTROLLERS_PATH: ' . CONTROLLERS_PATH . '<br>';
    echo 'VIEWS_PATH: ' . VIEWS_PATH . '<br>';
    echo 'REQUEST_URI: ' . $_SERVER['REQUEST_URI'] . '<br>';
    echo '</pre>';
}

// Enrutamiento básico
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Validar y sanitizar la página solicitada
$page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);

// Verificar si se solicita un detalle
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Cargar el controlador correspondiente
$controller_file = 'app/controllers/' . $page . '_controller.php';

if (file_exists($controller_file)) {
    require_once $controller_file;
    
    // Convención: NombreController para cada página
    $controller_name = ucfirst($page) . 'Controller';
    
    if (class_exists($controller_name)) {
        try {
            $controller = new $controller_name();
            
            // Verificar si se solicita una acción específica
            if ($action === 'detalle' && $id !== null && method_exists($controller, 'detalle')) {
                $controller->detalle($id);
            } else {
                // Acción por defecto
                $controller->index();
            }
        } catch (Exception $e) {
            // Registrar el error
            error_log('Error en el controlador ' . $controller_name . ': ' . $e->getMessage());
            
            // Mostrar página de error 500
            header("HTTP/1.0 500 Internal Server Error");
            require_once 'app/views/error/500.php';
        }
    } else {
        // Error: controlador no encontrado
        header("HTTP/1.0 500 Internal Server Error");
        require_once 'app/views/error/500.php';
    }
} else {
    // Página no encontrada
    header("HTTP/1.0 404 Not Found");
    require_once 'app/views/error/404.php';
} 