<?php
/**
 * Archivo para cerrar sesión en el panel de administración
 */

// Iniciar sesión
session_start();

// Incluir archivos de configuración
require_once '../app/config/config.php';
require_once '../app/includes/functions.php';

// Destruir la sesión
session_destroy();

// Redirigir al login
header('Location: login.php');
exit; 