<?php
/**
 * Archivo principal del panel de administración
 */

// Iniciar sesión
session_start();

// Incluir archivos de configuración
require_once '../app/config/config.php';
require_once '../app/includes/functions.php';
require_once '../app/admin/config.php';

// Verificar si el usuario está autenticado
if (!is_admin()) {
    // Redirigir al login
    header('Location: ' . ADMIN_URL . '/login.php');
    exit;
}

// Obtener la sección y acción de la URL
$section = isset($_GET['section']) ? $_GET['section'] : 'dashboard';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Verificar que la sección exista
if (!isset($admin_sections[$section])) {
    // Redirigir a la página de error 404
    header('Location: ' . ADMIN_URL . '/error/404.php');
    exit;
}

// Verificar que la acción exista para la sección
if (!in_array($action, $admin_actions[$section])) {
    // Redirigir a la página de error 404
    header('Location: ' . ADMIN_URL . '/error/404.php');
    exit;
}

// Cargar el controlador correspondiente
$controller_file = $admin_sections[$section]['controller'];
$controller_class = $admin_sections[$section]['class'];

// Ruta completa del controlador
$controller_path = '../app/admin/controllers/' . $controller_file;

// Verificar que el archivo del controlador exista
if (!file_exists($controller_path)) {
    // Redirigir a la página de error 500
    header('Location: ' . ADMIN_URL . '/error/500.php');
    exit;
}

// Incluir el controlador
require_once $controller_path;

// Verificar que la clase del controlador exista
if (!class_exists($controller_class)) {
    // Redirigir a la página de error 500
    header('Location: ' . ADMIN_URL . '/error/500.php');
    exit;
}

// Crear una instancia del controlador
$controller = new $controller_class();

// Verificar que el método de la acción exista
if (!method_exists($controller, $action)) {
    // Redirigir a la página de error 404
    header('Location: ' . ADMIN_URL . '/error/404.php');
    exit;
}

// Ejecutar la acción
$controller->$action(); 