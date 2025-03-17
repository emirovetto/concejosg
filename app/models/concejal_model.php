<?php
/**
 * Modelo para los concejales
 */
require_once MODELS_PATH . '/base_model.php';

class ConcejalModel extends BaseModel {
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->table = 'concejales';
    }
    
    /**
     * Obtiene los concejales por bloque
     * 
     * @param int $bloque_id ID del bloque
     * @return array Concejales encontrados
     */
    public function get_by_bloque($bloque_id) {
        return $this->get_by('bloque_id', $bloque_id, 'apellido');
    }
    
    /**
     * Obtiene los concejales por bloque con ordenamiento
     * 
     * @param int $bloque_id ID del bloque
     * @param string $order_by Campo por el que ordenar
     * @param string $order Dirección de ordenamiento (ASC o DESC)
     * @return array Concejales encontrados
     */
    public function get_by($field, $value, $order_by = null, $order = 'ASC') {
        $value = $this->db->real_escape_string($value);
        
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = '{$value}'";
        
        if ($order_by) {
            $sql .= " ORDER BY {$order_by} {$order}";
        }
        
        $result = $this->db->query($sql);
        
        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        
        return $records;
    }
    
    /**
     * Busca concejales por texto
     * 
     * @param string $search Texto a buscar
     * @return array Concejales encontrados
     */
    public function search($search) {
        $search = $this->db->real_escape_string($search);
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE nombre LIKE '%{$search}%' 
                OR apellido LIKE '%{$search}%' 
                OR cargo LIKE '%{$search}%'
                ORDER BY apellido ASC";
                
        $result = $this->db->query($sql);
        
        $concejales = [];
        while ($row = $result->fetch_assoc()) {
            $concejales[] = $row;
        }
        
        return $concejales;
    }
} 