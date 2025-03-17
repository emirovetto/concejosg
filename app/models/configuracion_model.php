<?php
/**
 * Modelo para gestionar la configuración del sitio
 */
require_once MODELS_PATH . '/base_model.php';

class ConfiguracionModel extends BaseModel {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct('configuracion');
    }
    
    /**
     * Obtiene el valor de una configuración por su clave
     * 
     * @param string $clave Clave de la configuración
     * @param mixed $default Valor por defecto si no existe
     * @return mixed Valor de la configuración
     */
    public function get_by_clave($clave, $default = null) {
        global $db;
        
        $stmt = $db->prepare("SELECT valor FROM configuracion WHERE clave = ?");
        $stmt->bind_param("s", $clave);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return $default;
        }
        
        $data = $result->fetch_assoc();
        return $data['valor'];
    }
    
    /**
     * Actualiza el valor de una configuración por su clave
     * 
     * @param string $clave Clave de la configuración
     * @param mixed $valor Nuevo valor
     * @return bool True si se actualizó correctamente, False si no
     */
    public function update_by_clave($clave, $valor) {
        global $db;
        
        // Verificar si la configuración existe
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM configuracion WHERE clave = ?");
        $stmt->bind_param("s", $clave);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        if ($data['total'] > 0) {
            // Actualizar
            $stmt = $db->prepare("UPDATE configuracion SET valor = ? WHERE clave = ?");
            $stmt->bind_param("ss", $valor, $clave);
            return $stmt->execute();
        } else {
            // Insertar
            $stmt = $db->prepare("INSERT INTO configuracion (clave, valor) VALUES (?, ?)");
            $stmt->bind_param("ss", $clave, $valor);
            return $stmt->execute();
        }
    }
    
    /**
     * Obtiene todas las configuraciones como un array asociativo
     * 
     * @return array Configuraciones como array asociativo
     */
    public function get_all_as_array() {
        global $db;
        
        $result = $db->query("SELECT clave, valor FROM configuracion");
        $configuraciones = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $configuraciones[$row['clave']] = $row['valor'];
            }
        }
        
        return $configuraciones;
    }
    
    /**
     * Elimina una configuración por su clave
     * 
     * @param string $clave Clave de la configuración
     * @return bool True si se eliminó correctamente, False si no
     */
    public function delete_by_clave($clave) {
        global $db;
        
        $stmt = $db->prepare("DELETE FROM configuracion WHERE clave = ?");
        $stmt->bind_param("s", $clave);
        
        return $stmt->execute();
    }
} 