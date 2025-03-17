<?php
/**
 * Modelo para las sesiones del concejo
 */
require_once MODELS_PATH . '/base_model.php';

class SesionModel extends BaseModel {
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->table = 'sesiones';
    }
    
    /**
     * Obtiene las próximas sesiones
     * 
     * @param int $limit Número de sesiones a obtener
     * @return array Sesiones encontradas
     */
    public function get_upcoming($limit = 5) {
        $limit = (int) $limit;
        $today = date('Y-m-d');
        
        $sql = "SELECT * FROM {$this->table} WHERE fecha >= '{$today}' ORDER BY fecha ASC LIMIT {$limit}";
        
        $result = $this->db->query($sql);
        
        $sesiones = [];
        while ($row = $result->fetch_assoc()) {
            $sesiones[] = $row;
        }
        
        return $sesiones;
    }
    
    /**
     * Obtiene las sesiones pasadas
     * 
     * @param int $limit Número de sesiones a obtener
     * @param int $offset Desplazamiento para paginación
     * @return array Sesiones encontradas
     */
    public function get_past($limit = 10, $offset = 0) {
        $limit = (int) $limit;
        $offset = (int) $offset;
        $today = date('Y-m-d');
        
        $sql = "SELECT * FROM {$this->table} WHERE fecha < '{$today}' ORDER BY fecha DESC LIMIT {$offset}, {$limit}";
        
        $result = $this->db->query($sql);
        
        $sesiones = [];
        while ($row = $result->fetch_assoc()) {
            $sesiones[] = $row;
        }
        
        return $sesiones;
    }
    
    /**
     * Obtiene sesiones por año
     * 
     * @param int $year Año a buscar
     * @return array Sesiones encontradas
     */
    public function get_by_year($year) {
        $year = (int) $year;
        
        $sql = "SELECT * FROM {$this->table} WHERE YEAR(fecha) = {$year} ORDER BY fecha DESC";
        
        $result = $this->db->query($sql);
        
        $sesiones = [];
        while ($row = $result->fetch_assoc()) {
            $sesiones[] = $row;
        }
        
        return $sesiones;
    }
    
    /**
     * Obtiene sesiones con video
     * 
     * @param int $limit Número de sesiones a obtener
     * @return array Sesiones encontradas
     */
    public function get_with_video($limit = 10) {
        $limit = (int) $limit;
        
        $sql = "SELECT * FROM {$this->table} WHERE video_url IS NOT NULL AND video_url != '' ORDER BY fecha DESC LIMIT {$limit}";
        
        $result = $this->db->query($sql);
        
        $sesiones = [];
        while ($row = $result->fetch_assoc()) {
            $sesiones[] = $row;
        }
        
        return $sesiones;
    }
    
    /**
     * Crea una nueva sesión
     * 
     * @param array $data Datos de la sesión
     * @return int|bool ID de la sesión creada o false si hay error
     */
    public function create($data) {
        return $this->insert($data);
    }
    
    /**
     * Actualiza una sesión existente
     * 
     * @param int $id ID de la sesión a actualizar
     * @param array $data Datos de la sesión
     * @return bool True si se actualizó correctamente, false en caso contrario
     */
    public function update($id, $data) {
        // Sanitizar el ID
        $id = (int) $id;
        
        // Preparar los datos para actualizar
        $update_data = [];
        
        if (isset($data['titulo'])) {
            $update_data['titulo'] = $data['titulo'];
        }
        
        if (isset($data['descripcion'])) {
            $update_data['descripcion'] = $data['descripcion'];
        }
        
        if (isset($data['fecha'])) {
            $update_data['fecha'] = $data['fecha'];
        }
        
        if (isset($data['hora'])) {
            $update_data['hora'] = $data['hora'];
        }
        
        if (isset($data['lugar'])) {
            $update_data['lugar'] = $data['lugar'];
        }
        
        if (isset($data['tipo'])) {
            $update_data['tipo'] = $data['tipo'];
        }
        
        if (isset($data['estado'])) {
            $update_data['estado'] = $data['estado'];
        }
        
        if (isset($data['video_url'])) {
            $update_data['video_url'] = $data['video_url'];
        }
        
        if (isset($data['acta'])) {
            $update_data['acta'] = $data['acta'];
        }
        
        // Llamar al método de la clase padre
        return parent::update($id, $update_data);
    }
    
    /**
     * Elimina una sesión
     * 
     * @param int $id ID de la sesión a eliminar
     * @return bool True si se eliminó correctamente, false en caso contrario
     */
    public function delete($id) {
        $id = (int) $id;
        
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        
        return $this->db->query($sql);
    }
} 