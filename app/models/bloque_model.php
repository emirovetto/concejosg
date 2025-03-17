<?php
/**
 * Modelo para los bloques políticos
 */
require_once MODELS_PATH . '/base_model.php';

class BloqueModel extends BaseModel {
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->table = 'bloques';
    }
    
    /**
     * Obtiene los bloques con la cantidad de concejales
     * 
     * @return array Bloques con cantidad de concejales
     */
    public function get_with_count() {
        $sql = "SELECT b.*, COUNT(c.id) as cantidad_concejales 
                FROM {$this->table} b
                LEFT JOIN concejales c ON b.id = c.bloque_id
                GROUP BY b.id
                ORDER BY b.nombre ASC";
                
        $result = $this->db->query($sql);
        
        $bloques = [];
        while ($row = $result->fetch_assoc()) {
            $bloques[] = $row;
        }
        
        return $bloques;
    }
    
    /**
     * Busca bloques por texto
     * 
     * @param string $search Texto a buscar
     * @return array Bloques encontrados
     */
    public function search($search) {
        $search = $this->db->real_escape_string($search);
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE nombre LIKE '%{$search}%' 
                OR descripcion LIKE '%{$search}%'
                ORDER BY nombre ASC";
                
        $result = $this->db->query($sql);
        
        $bloques = [];
        while ($row = $result->fetch_assoc()) {
            $bloques[] = $row;
        }
        
        return $bloques;
    }
} 