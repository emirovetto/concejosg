<?php
/**
 * Punto de entrada principal para el sitio web del Concejo Deliberante de San Genaro
 */

// Iniciar sesión
session_start();

// Cargar configuración
require_once 'app/config/config.php';
require_once 'app/includes/functions.php';

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
        $controller = new $controller_name();
        
        // Verificar si se solicita una acción específica
        if ($action === 'detalle' && $id !== null && method_exists($controller, 'detalle')) {
            $controller->detalle($id);
        } else {
            // Acción por defecto
            $controller->index();
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