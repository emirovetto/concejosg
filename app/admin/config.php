<?php
/**
 * Configuración del panel de administración
 */

// Verificar que ya se haya definido la constante BASE_URL
if (!defined('BASE_URL')) {
    die('El archivo de configuración principal no ha sido cargado.');
}

// Definir la URL base del panel de administración
if (!defined('ADMIN_URL')) {
    define('ADMIN_URL', BASE_URL . '/admin');
}

// Definir la ruta de las vistas del panel de administración
if (!defined('ADMIN_VIEWS_PATH')) {
    define('ADMIN_VIEWS_PATH', APP_PATH . '/views/admin');
}

// Definir la ruta de los controladores del panel de administración
if (!defined('ADMIN_CONTROLLERS_PATH')) {
    define('ADMIN_CONTROLLERS_PATH', APP_PATH . '/admin/controllers');
}

// Definir las secciones disponibles en el panel de administración
$admin_sections = [
    'dashboard' => [
        'title' => 'Dashboard',
        'icon' => 'fas fa-tachometer-alt',
        'controller' => 'dashboard_controller.php',
        'class' => 'DashboardController'
    ],
    'noticias' => [
        'title' => 'Noticias',
        'icon' => 'fas fa-newspaper',
        'controller' => 'noticias_controller.php',
        'class' => 'NoticiasController'
    ],
    'categorias' => [
        'title' => 'Categorías',
        'icon' => 'fas fa-tags',
        'controller' => 'categorias_controller.php',
        'class' => 'CategoriasController'
    ],
    'sesiones' => [
        'title' => 'Sesiones',
        'icon' => 'fas fa-calendar-alt',
        'controller' => 'sesiones_controller.php',
        'class' => 'SesionesController'
    ],
    'ordenanzas' => [
        'title' => 'Ordenanzas',
        'icon' => 'fas fa-file-alt',
        'controller' => 'ordenanzas_controller.php',
        'class' => 'OrdenanzasController'
    ],
    'concejales' => [
        'title' => 'Concejales',
        'icon' => 'fas fa-users',
        'controller' => 'concejales_controller.php',
        'class' => 'ConcejalesController'
    ],
    'bloques' => [
        'title' => 'Bloques Políticos',
        'icon' => 'fas fa-building',
        'controller' => 'bloques_controller.php',
        'class' => 'BloquesController'
    ],
    'usuarios' => [
        'title' => 'Usuarios',
        'icon' => 'fas fa-user-shield',
        'controller' => 'usuarios_controller.php',
        'class' => 'UsuariosController'
    ],
    'configuracion' => [
        'title' => 'Configuración',
        'icon' => 'fas fa-cogs',
        'controller' => 'configuracion_controller.php',
        'class' => 'ConfiguracionController'
    ]
];

// Definir las acciones disponibles para cada sección
$admin_actions = [
    'dashboard' => ['index'],
    'noticias' => ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'],
    'categorias' => ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'],
    'sesiones' => ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'],
    'ordenanzas' => ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'],
    'concejales' => ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'],
    'bloques' => ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'],
    'usuarios' => ['index', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar', 'perfil'],
    'configuracion' => ['index', 'actualizar']
]; 