<?php
/**
 * Modelo para las ordenanzas
 */
require_once MODELS_PATH . '/base_model.php';

class OrdenanzaModel extends BaseModel {
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->table = 'ordenanzas';
    }
    
    /**
     * Obtiene las ordenanzas más recientes
     * 
     * @param int $limit Cantidad de ordenanzas a obtener
     * @return array Ordenanzas encontradas
     */
    public function get_latest($limit = 5) {
        $sql = "SELECT * FROM {$this->table} ORDER BY numero DESC LIMIT {$limit}";
        $result = $this->db->query($sql);
        
        $ordenanzas = [];
        while ($row = $result->fetch_assoc()) {
            $ordenanzas[] = $row;
        }
        
        return $ordenanzas;
    }
    
    /**
     * Busca ordenanzas por texto
     * 
     * @param string $search Texto a buscar
     * @return array Ordenanzas encontradas
     */
    public function search($search) {
        $search = $this->db->real_escape_string($search);
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE titulo LIKE '%{$search}%' 
                OR descripcion LIKE '%{$search}%' 
                OR numero LIKE '%{$search}%'
                ORDER BY numero DESC";
                
        $result = $this->db->query($sql);
        
        $ordenanzas = [];
        while ($row = $result->fetch_assoc()) {
            $ordenanzas[] = $row;
        }
        
        return $ordenanzas;
    }
    
    /**
     * Obtiene ordenanzas por año
     * 
     * @param int $year Año de las ordenanzas
     * @return array Ordenanzas encontradas
     */
    public function get_by_year($year) {
        $year = (int)$year;
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE YEAR(fecha) = {$year}
                ORDER BY numero DESC";
                
        $result = $this->db->query($sql);
        
        $ordenanzas = [];
        while ($row = $result->fetch_assoc()) {
            $ordenanzas[] = $row;
        }
        
        return $ordenanzas;
    }
    
    /**
     * Obtiene ordenanzas por categoría
     * 
     * @param int $categoria_id ID de la categoría
     * @return array Ordenanzas encontradas
     */
    public function get_by_categoria($categoria_id) {
        $categoria_id = (int)$categoria_id;
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE categoria_id = {$categoria_id}
                ORDER BY numero DESC";
                
        $result = $this->db->query($sql);
        
        $ordenanzas = [];
        while ($row = $result->fetch_assoc()) {
            $ordenanzas[] = $row;
        }
        
        return $ordenanzas;
    }
    
    /**
     * Crea una nueva ordenanza
     * 
     * @param array $data Datos de la ordenanza
     * @return int|bool ID de la ordenanza creada o false si hay error
     */
    public function create($data) {
        return $this->insert($data);
    }
    
    /**
     * Actualiza una ordenanza existente
     * 
     * @param int $id ID de la ordenanza a actualizar
     * @param array $data Datos de la ordenanza
     * @return bool True si se actualizó correctamente, false en caso contrario
     */
    public function update($id, $data) {
        // Sanitizar el ID
        $id = (int)$id;
        
        // Preparar los datos para actualizar
        $update_data = [];
        
        if (isset($data['numero'])) {
            $update_data['numero'] = $data['numero'];
        }
        
        if (isset($data['anio'])) {
            $update_data['anio'] = $data['anio'];
        }
        
        if (isset($data['titulo'])) {
            $update_data['titulo'] = $data['titulo'];
        }
        
        if (isset($data['descripcion'])) {
            $update_data['descripcion'] = $data['descripcion'];
        }
        
        if (isset($data['fecha_sancion'])) {
            $update_data['fecha_sancion'] = $data['fecha_sancion'];
        }
        
        if (isset($data['categoria_id'])) {
            $update_data['categoria_id'] = (int)$data['categoria_id'];
        }
        
        if (isset($data['archivo'])) {
            $update_data['archivo'] = $data['archivo'];
        }
        
        // Llamar al método de la clase padre
        return parent::update($id, $update_data);
    }
    
    /**
     * Elimina una ordenanza
     * 
     * @param int $id ID de la ordenanza a eliminar
     * @return bool True si se eliminó correctamente, false en caso contrario
     */
    public function delete($id) {
        $id = (int)$id;
        
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        
        return $this->db->query($sql);
    }
} 