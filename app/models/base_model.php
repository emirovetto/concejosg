<?php
/**
 * Modelo base del que heredan todos los modelos
 */
class BaseModel {
    // Nombre de la tabla en la base de datos
    protected $table;
    
    // Nombre de la clave primaria
    protected $primary_key = 'id';
    
    // Conexión a la base de datos
    protected $db;
    
    /**
     * Constructor
     * 
     * @param string $table Nombre de la tabla
     */
    public function __construct($table) {
        $this->table = $table;
        $this->db = db_connect();
    }
    
    /**
     * Obtiene todos los registros de la tabla
     * 
     * @param string $order_by Campo por el que ordenar
     * @param string $order Dirección de ordenamiento (ASC o DESC)
     * @return array Registros encontrados
     */
    public function get_all($order_by = null, $order = 'ASC') {
        $sql = "SELECT * FROM {$this->table}";
        
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
     * Obtiene un registro por su ID
     * 
     * @param int $id ID del registro
     * @return array|null Registro encontrado o null si no existe
     */
    public function get_by_id($id) {
        $id = (int) $id;
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primary_key} = {$id}";
        
        $result = $this->db->query($sql);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Obtiene registros según un criterio
     * 
     * @param string $field Campo por el que filtrar
     * @param mixed $value Valor a buscar
     * @return array Registros encontrados
     */
    public function get_by($field, $value) {
        $field = $this->db->real_escape_string($field);
        $value = $this->db->real_escape_string($value);
        
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = '{$value}'";
        
        $result = $this->db->query($sql);
        
        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        
        return $records;
    }
    
    /**
     * Inserta un nuevo registro
     * 
     * @param array $data Datos a insertar
     * @return int|bool ID del registro insertado o false si falla
     */
    public function insert($data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $field => $value) {
            $fields[] = $field;
            $values[] = "'" . $this->db->real_escape_string($value) . "'";
        }
        
        $fields_str = implode(', ', $fields);
        $values_str = implode(', ', $values);
        
        $sql = "INSERT INTO {$this->table} ({$fields_str}) VALUES ({$values_str})";
        
        if ($this->db->query($sql)) {
            return $this->db->insert_id;
        }
        
        return false;
    }
    
    /**
     * Actualiza un registro
     * 
     * @param int $id ID del registro a actualizar
     * @param array $data Datos a actualizar
     * @return bool True si se actualiza correctamente, false en caso contrario
     */
    public function update($id, $data) {
        $id = (int) $id;
        $set = [];
        
        foreach ($data as $field => $value) {
            $set[] = "{$field} = '" . $this->db->real_escape_string($value) . "'";
        }
        
        $set_str = implode(', ', $set);
        
        $sql = "UPDATE {$this->table} SET {$set_str} WHERE {$this->primary_key} = {$id}";
        
        return $this->db->query($sql);
    }
    
    /**
     * Elimina un registro
     * 
     * @param int $id ID del registro a eliminar
     * @return bool True si se elimina correctamente, false en caso contrario
     */
    public function delete($id) {
        $id = (int) $id;
        $sql = "DELETE FROM {$this->table} WHERE {$this->primary_key} = {$id}";
        
        return $this->db->query($sql);
    }
    
    /**
     * Cuenta el número de registros
     * 
     * @param string $field Campo por el que filtrar (opcional)
     * @param mixed $value Valor a buscar (opcional)
     * @return int Número de registros
     */
    public function count($field = null, $value = null) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        
        if ($field && $value) {
            $field = $this->db->real_escape_string($field);
            $value = $this->db->real_escape_string($value);
            $sql .= " WHERE {$field} = '{$value}'";
        }
        
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        
        return (int) $row['count'];
    }
    
    /**
     * Ejecuta una consulta personalizada
     * 
     * @param string $sql Consulta SQL a ejecutar
     * @return mysqli_result|bool Resultado de la consulta
     */
    public function query($sql) {
        return $this->db->query($sql);
    }
} 