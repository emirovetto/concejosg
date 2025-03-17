<?php
/**
 * Funciones de utilidad para el sitio web del Concejo Deliberante de San Genaro
 */

/**
 * Conecta a la base de datos
 * 
 * @return mysqli Conexión a la base de datos
 */
function db_connect() {
    global $db;
    
    if (!isset($db) || !$db instanceof mysqli) {
        try {
            $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($db->connect_error) {
                error_log('Error de conexión a la base de datos: ' . $db->connect_error);
                // En producción, solo mostrar un mensaje genérico al usuario
                die('Error de conexión a la base de datos. Por favor, inténtelo de nuevo más tarde o contacte al administrador.');
            }
            
            $db->set_charset('utf8');
        } catch (Exception $e) {
            error_log('Excepción en la conexión a la base de datos: ' . $e->getMessage());
            die('Error de conexión a la base de datos. Por favor, inténtelo de nuevo más tarde o contacte al administrador.');
        }
    }
    
    return $db;
}

/**
 * Verifica si el usuario ha iniciado sesión
 * 
 * @return bool True si el usuario ha iniciado sesión, false en caso contrario
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Verifica si el usuario tiene un rol específico
 * 
 * @param string $role Rol a verificar
 * @return bool True si el usuario tiene el rol, false en caso contrario
 */
function has_role($role) {
    return is_logged_in() && $_SESSION['user_role'] === $role;
}

/**
 * Verifica si el usuario es administrador
 * 
 * @return bool True si el usuario es administrador, false en caso contrario
 */
function is_admin() {
    return has_role('admin');
}

/**
 * Redirige a una URL
 * 
 * @param string $url URL a la que redirigir
 * @return void
 */
function redirect($url) {
    header("Location: {$url}");
    exit;
}

/**
 * Establece un mensaje flash para mostrar en la siguiente página
 * 
 * @param string $message Mensaje a mostrar
 * @param string $type Tipo de mensaje (success, danger, warning, info)
 * @return void
 */
function set_mensaje($message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

/**
 * Verifica una contraseña de forma segura
 * 
 * @param string $password Contraseña a verificar
 * @param string $hash Hash almacenado
 * @return bool True si la contraseña es correcta, false en caso contrario
 */
function password_verify_secure($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Genera un hash seguro para una contraseña
 * 
 * @param string $password Contraseña a hashear
 * @return string Hash de la contraseña
 */
function password_hash_secure($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Formatea una fecha en formato legible
 * 
 * @param string $date Fecha en formato Y-m-d
 * @param bool $include_day Incluir el día de la semana
 * @return string Fecha formateada
 */
function format_date($date, $include_day = false) {
    if (empty($date)) {
        return '';
    }
    
    $timestamp = strtotime($date);
    
    if ($include_day) {
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $dia_semana = $dias[date('w', $timestamp)];
        return $dia_semana . ', ' . date('d/m/Y', $timestamp);
    }
    
    return date('d/m/Y', $timestamp);
}

/**
 * Formatea un número como dinero
 * 
 * @param float $amount Cantidad a formatear
 * @param string $symbol Símbolo de la moneda
 * @return string Cantidad formateada
 */
function format_money($amount, $symbol = '$') {
    return $symbol . ' ' . number_format($amount, 2, ',', '.');
}

/**
 * Limpia y sanitiza un string para evitar inyección de código
 * 
 * @param string $str String a limpiar
 * @return string String limpio
 */
function clean_string($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

/**
 * Genera un slug a partir de un string
 * 
 * @param string $str String a convertir
 * @return string Slug generado
 */
function generate_slug($str) {
    // Convertir a minúsculas
    $str = mb_strtolower($str, 'UTF-8');
    
    // Reemplazar caracteres especiales
    $str = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ', ' '],
        ['a', 'e', 'i', 'o', 'u', 'u', 'n', '-'],
        $str
    );
    
    // Eliminar caracteres que no sean alfanuméricos o guiones
    $str = preg_replace('/[^a-z0-9\-]/', '', $str);
    
    // Eliminar guiones múltiples
    $str = preg_replace('/-+/', '-', $str);
    
    // Eliminar guiones al principio y al final
    return trim($str, '-');
}

/**
 * Trunca un texto a una longitud específica
 * 
 * @param string $text Texto a truncar
 * @param int $length Longitud máxima
 * @param string $append Texto a añadir al final
 * @return string Texto truncado
 */
function truncate_text($text, $length = 100, $append = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . $append;
}

/**
 * Obtiene la extensión de un archivo
 * 
 * @param string $filename Nombre del archivo
 * @return string Extensión del archivo
 */
function get_file_extension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Verifica si un archivo es una imagen
 * 
 * @param string $filename Nombre del archivo
 * @return bool True si es una imagen, false en caso contrario
 */
function is_image($filename) {
    $ext = get_file_extension($filename);
    $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    return in_array($ext, $image_extensions);
}

/**
 * Verifica si un archivo es un documento PDF
 * 
 * @param string $filename Nombre del archivo
 * @return bool True si es un PDF, false en caso contrario
 */
function is_pdf($filename) {
    return get_file_extension($filename) === 'pdf';
}

/**
 * Genera un nombre de archivo único
 * 
 * @param string $filename Nombre original del archivo
 * @return string Nombre único
 */
function generate_unique_filename($filename) {
    $ext = get_file_extension($filename);
    return uniqid() . '.' . $ext;
}

/**
 * Obtiene la URL actual
 * 
 * @return string URL actual
 */
function current_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Obtiene el año actual
 * 
 * @return int Año actual
 */
function current_year() {
    return date('Y');
}

/**
 * Verifica si una cadena está vacía
 * 
 * @param string $str Cadena a verificar
 * @return bool True si está vacía, false en caso contrario
 */
function is_empty($str) {
    return empty(trim($str));
}

/**
 * Verifica si un email es válido
 * 
 * @param string $email Email a verificar
 * @return bool True si es válido, false en caso contrario
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Verifica si una URL es válida
 * 
 * @param string $url URL a verificar
 * @return bool True si es válida, false en caso contrario
 */
function is_valid_url($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

/**
 * Obtiene la IP del cliente
 * 
 * @return string IP del cliente
 */
function get_client_ip() {
    $ip = '';
    
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    return $ip;
}

/**
 * Registra un acceso en el log
 * 
 * @param string $action Acción realizada
 * @param string $details Detalles adicionales
 * @return bool True si se registró correctamente, false en caso contrario
 */
function log_access($action, $details = '') {
    $conn = db_connect();
    
    $user_id = is_logged_in() ? $_SESSION['user_id'] : 0;
    $ip = get_client_ip();
    $action = $conn->real_escape_string($action);
    $details = $conn->real_escape_string($details);
    $date = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO accesos_log (user_id, ip, accion, detalles, fecha) 
            VALUES ({$user_id}, '{$ip}', '{$action}', '{$details}', '{$date}')";
    
    $result = $conn->query($sql);
    $conn->close();
    
    return $result;
}

/**
 * Verifica si una sesión ha expirado
 * 
 * @param int $max_lifetime Tiempo máximo de vida en segundos
 * @return bool True si ha expirado, false en caso contrario
 */
function session_expired($max_lifetime = 3600) {
    if (!isset($_SESSION['last_activity'])) {
        $_SESSION['last_activity'] = time();
        return false;
    }
    
    if (time() - $_SESSION['last_activity'] > $max_lifetime) {
        return true;
    }
    
    $_SESSION['last_activity'] = time();
    return false;
}

/**
 * Obtiene el nombre del mes
 * 
 * @param int $month Número del mes (1-12)
 * @return string Nombre del mes
 */
function get_month_name($month) {
    $months = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];
    
    return isset($months[$month]) ? $months[$month] : '';
}

/**
 * Obtiene una lista de años para seleccionar
 * 
 * @param int $start_year Año de inicio
 * @param int $end_year Año de fin (por defecto, el año actual)
 * @return array Lista de años
 */
function get_years_list($start_year = 2000, $end_year = null) {
    if ($end_year === null) {
        $end_year = (int)date('Y');
    }
    
    $years = [];
    for ($year = $end_year; $year >= $start_year; $year--) {
        $years[] = $year;
    }
    
    return $years;
}

/**
 * Obtiene el nombre de una categoría por su ID
 * 
 * @param int $categoria_id ID de la categoría
 * @return string Nombre de la categoría o 'Sin categoría' si no existe
 */
function get_categoria_nombre($categoria_id) {
    global $db;
    
    if (empty($categoria_id)) {
        return 'Sin categoría';
    }
    
    $stmt = $db->prepare("SELECT nombre FROM categorias WHERE id = ?");
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $categoria = $result->fetch_assoc();
        return $categoria['nombre'];
    }
    
    return 'Sin categoría';
}

/**
 * Obtiene todas las categorías
 * 
 * @return array Lista de categorías
 */
function get_all_categorias() {
    global $db;
    
    $stmt = $db->prepare("SELECT id, nombre FROM categorias ORDER BY nombre ASC");
    $stmt->execute();
    $result = $stmt->get_result();
    
    $categorias = [];
    while ($categoria = $result->fetch_assoc()) {
        $categorias[] = $categoria;
    }
    
    return $categorias;
}

/**
 * Determina si el entorno actual es de producción
 * 
 * @return bool True si es producción, false si es desarrollo
 */
function is_production() {
    // Verificar si la URL contiene 4kdigitalsg.com
    return strpos(SITE_URL, '4kdigitalsg.com') !== false;
}
