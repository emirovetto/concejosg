<?php
/**
 * Modelo para las noticias
 */
require_once MODELS_PATH . '/base_model.php';

class NoticiaModel extends BaseModel {
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->table = 'noticias';
    }
    
    /**
     * Obtiene las últimas noticias
     * 
     * @param int $limit Número de noticias a obtener
     * @return array Noticias encontradas
     */
    public function get_latest($limit = 5) {
        $limit = (int) $limit;
        $sql = "SELECT * FROM {$this->table} WHERE estado = 'publicado' ORDER BY fecha_publicacion DESC LIMIT {$limit}";
        
        $result = $this->db->query($sql);
        
        $noticias = [];
        while ($row = $result->fetch_assoc()) {
            $noticias[] = $row;
        }
        
        return $noticias;
    }
    
    /**
     * Obtiene noticias por categoría
     * 
     * @param int $categoria_id ID de la categoría
     * @param int $limit Número de noticias a obtener
     * @return array Noticias encontradas
     */
    public function get_by_categoria($categoria_id, $limit = 10) {
        $categoria_id = (int) $categoria_id;
        $limit = (int) $limit;
        
        $sql = "SELECT * FROM {$this->table} WHERE categoria_id = {$categoria_id} AND estado = 'publicado' ORDER BY fecha_publicacion DESC LIMIT {$limit}";
        
        $result = $this->db->query($sql);
        
        $noticias = [];
        while ($row = $result->fetch_assoc()) {
            $noticias[] = $row;
        }
        
        return $noticias;
    }
    
    /**
     * Busca noticias por término
     * 
     * @param string $term Término a buscar
     * @param int $limit Número de noticias a obtener
     * @return array Noticias encontradas
     */
    public function search($term, $limit = 10) {
        $term = $this->db->real_escape_string($term);
        $limit = (int) $limit;
        
        $sql = "SELECT * FROM {$this->table} WHERE (titulo LIKE '%{$term}%' OR contenido LIKE '%{$term}%') AND estado = 'publicado' ORDER BY fecha_publicacion DESC LIMIT {$limit}";
        
        $result = $this->db->query($sql);
        
        $noticias = [];
        while ($row = $result->fetch_assoc()) {
            $noticias[] = $row;
        }
        
        return $noticias;
    }
    
    /**
     * Obtiene noticias relacionadas (misma categoría, excluyendo la actual)
     * 
     * @param int $noticia_id ID de la noticia actual
     * @param int $categoria_id ID de la categoría
     * @param int $limit Número de noticias a obtener
     * @return array Noticias relacionadas
     */
    public function get_related($noticia_id, $categoria_id, $limit = 3) {
        $noticia_id = (int) $noticia_id;
        $categoria_id = (int) $categoria_id;
        $limit = (int) $limit;
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE id != {$noticia_id} 
                AND categoria_id = {$categoria_id} 
                AND estado = 'publicado' 
                ORDER BY fecha_publicacion DESC 
                LIMIT {$limit}";
        
        $result = $this->db->query($sql);
        
        $noticias = [];
        while ($row = $result->fetch_assoc()) {
            $noticias[] = $row;
        }
        
        return $noticias;
    }
} 