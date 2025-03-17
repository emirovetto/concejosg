<?php
/**
 * Archivo de configuración principal
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'u102838416_concejo_sg');
define('DB_PASS', 'Rovetto5!');
define('DB_NAME', 'u102838416_concejo_sg');

// Configuración del sitio
define('SITE_NAME', 'Concejo Deliberante de San Genaro');
define('SITE_URL', 'https://4kdigitalsg.com/concejosg'); // URL para producción

// Definir BASE_URL para uso en templates
define('BASE_URL', SITE_URL);

// Definir ADMIN_URL
define('ADMIN_URL', BASE_URL . '/admin');

// Rutas del sistema
define('ROOT_PATH', dirname(dirname(__DIR__)));
define('APP_PATH', ROOT_PATH . '/app');
define('CONTROLLERS_PATH', APP_PATH . '/controllers');
define('MODELS_PATH', APP_PATH . '/models');
define('VIEWS_PATH', APP_PATH . '/views');
define('INCLUDES_PATH', APP_PATH . '/includes');
define('UPLOADS_PATH', APP_PATH . '/public/uploads');

// Configuración de correo electrónico
define('MAIL_HOST', 'smtp.example.com');
define('MAIL_USER', 'info@concejosangenaro.gob.ar');
define('MAIL_PASS', 'password');
define('MAIL_PORT', 587);

// Configuración de seguridad
define('HASH_COST', 10); // Costo para bcrypt
define('SESSION_LIFETIME', 3600); // 1 hora

// Zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires'); 