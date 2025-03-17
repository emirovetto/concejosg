<?php
// Incluir archivos de configuración y funciones
require_once 'app/config/config.php';
require_once 'app/includes/functions.php';

// Contraseña a hashear
$password = 'admin';

// Generar hash usando la función del sistema
$hash = password_hash_secure($password);

// Mostrar el hash generado
echo "Contraseña original: $password<br>";
echo "Hash generado: $hash<br>";
echo "<hr>";
echo "Consulta SQL para actualizar el usuario:<br>";
echo "UPDATE usuarios SET password = '$hash' WHERE email = 'admin@concejosg.com';";
?> 