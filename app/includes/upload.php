<?php
/**
 * Funciones para manejar la subida de archivos
 */

/**
 * Sube un archivo al servidor
 * 
 * @param array $file Archivo a subir ($_FILES['nombre'])
 * @param string $destination Directorio de destino
 * @param array $allowed_types Tipos de archivo permitidos
 * @param int $max_size Tamaño máximo en bytes
 * @return string|false Nombre del archivo subido o false si hay error
 */
function upload_file($file, $destination, $allowed_types = [], $max_size = 5242880) {
    // Verificar si hay errores
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    // Verificar el tamaño
    if ($file['size'] > $max_size) {
        return false;
    }
    
    // Verificar el tipo de archivo
    if (!empty($allowed_types)) {
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($file_info, $file['tmp_name']);
        finfo_close($file_info);
        
        if (!in_array($mime_type, $allowed_types)) {
            return false;
        }
    }
    
    // Generar un nombre único
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $filepath = $destination . '/' . $filename;
    
    // Crear el directorio si no existe
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }
    
    // Mover el archivo
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return $filename;
    }
    
    return false;
}

/**
 * Sube una imagen al servidor
 * 
 * @param array $file Archivo a subir ($_FILES['nombre'])
 * @param string $destination Directorio de destino
 * @param int $max_width Ancho máximo de la imagen
 * @param int $max_height Alto máximo de la imagen
 * @param int $max_size Tamaño máximo en bytes
 * @return string|false Nombre del archivo subido o false si hay error
 */
function upload_image($file, $destination, $max_width = 1200, $max_height = 1200, $max_size = 2097152) {
    // Tipos de imagen permitidos
    $allowed_types = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    ];
    
    // Subir el archivo
    $filename = upload_file($file, $destination, $allowed_types, $max_size);
    
    if ($filename === false) {
        return false;
    }
    
    // Ruta completa del archivo
    $filepath = $destination . '/' . $filename;
    
    // Obtener información de la imagen
    list($width, $height, $type) = getimagesize($filepath);
    
    // Verificar si es necesario redimensionar
    if ($width <= $max_width && $height <= $max_height) {
        return $filename;
    }
    
    // Calcular nuevas dimensiones manteniendo la proporción
    if ($width > $height) {
        $new_width = $max_width;
        $new_height = intval($height * $max_width / $width);
    } else {
        $new_height = $max_height;
        $new_width = intval($width * $max_height / $height);
    }
    
    // Crear una nueva imagen
    $new_image = imagecreatetruecolor($new_width, $new_height);
    
    // Cargar la imagen original
    switch ($type) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($filepath);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($filepath);
            // Preservar transparencia
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            break;
        case IMAGETYPE_GIF:
            $source = imagecreatefromgif($filepath);
            break;
        case IMAGETYPE_WEBP:
            $source = imagecreatefromwebp($filepath);
            break;
        default:
            return $filename;
    }
    
    // Redimensionar
    imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Guardar la nueva imagen
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($new_image, $filepath, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($new_image, $filepath, 9);
            break;
        case IMAGETYPE_GIF:
            imagegif($new_image, $filepath);
            break;
        case IMAGETYPE_WEBP:
            imagewebp($new_image, $filepath, 90);
            break;
    }
    
    // Liberar memoria
    imagedestroy($source);
    imagedestroy($new_image);
    
    return $filename;
}

/**
 * Sube un documento PDF al servidor
 * 
 * @param array $file Archivo a subir ($_FILES['nombre'])
 * @param string $destination Directorio de destino
 * @param int $max_size Tamaño máximo en bytes
 * @return string|false Nombre del archivo subido o false si hay error
 */
function upload_pdf($file, $destination, $max_size = 10485760) {
    // Tipos de documento permitidos
    $allowed_types = [
        'application/pdf'
    ];
    
    // Subir el archivo
    return upload_file($file, $destination, $allowed_types, $max_size);
}

/**
 * Elimina un archivo del servidor
 * 
 * @param string $filepath Ruta completa del archivo
 * @return bool True si se eliminó correctamente, false en caso contrario
 */
function delete_file($filepath) {
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    
    return false;
}

/**
 * Sanitiza el nombre de un archivo
 * 
 * @param string $filename Nombre del archivo
 * @return string Nombre sanitizado
 */
function sanitize_filename($filename) {
    // Eliminar caracteres especiales
    $filename = preg_replace('/[^\w\-\.]/', '', $filename);
    
    // Eliminar espacios
    $filename = str_replace(' ', '_', $filename);
    
    // Convertir a minúsculas
    $filename = strtolower($filename);
    
    return $filename;
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
function is_image_file($filename) {
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
function is_pdf_file($filename) {
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