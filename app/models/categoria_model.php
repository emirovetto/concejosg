<?php
/**
 * Modelo para gestionar las categorías
 */
require_once MODELS_PATH . '/base_model.php';

class CategoriaModel extends BaseModel {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct('categorias');
    }
    
    /**
     * Obtiene todas las categorías ordenadas por nombre
     * 
     * @return array Lista de categorías
     */
    public function get_all_ordered() {
        return $this->get_all('nombre', 'ASC');
    }
    
    /**
     * Obtiene las categorías con conteo de noticias
     * 
     * @return array Lista de categorías con conteo
     */
    public function get_with_count() {
        global $db;
        
        $sql = "SELECT c.*, COUNT(n.id) as total_noticias 
                FROM categorias c 
                LEFT JOIN noticias n ON c.id = n.categoria_id 
                GROUP BY c.id 
                ORDER BY c.nombre ASC";
        
        $result = $db->query($sql);
        $categorias = [];
        
        if ($result) {
            while ($categoria = $result->fetch_assoc()) {
                $categorias[] = $categoria;
            }
        }
        
        return $categorias;
    }
    
    /**
     * Verifica si una categoría tiene noticias asociadas
     * 
     * @param int $id ID de la categoría
     * @return bool True si tiene noticias, False si no
     */
    public function has_noticias($id) {
        global $db;
        
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM noticias WHERE categoria_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        return $data['total'] > 0;
    }
} 