<?php
/**
 * Modelo para gestionar los usuarios
 */
require_once MODELS_PATH . '/base_model.php';

class UsuarioModel extends BaseModel {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct('usuarios');
    }
    
    /**
     * Verifica si un email ya existe en la base de datos
     * 
     * @param string $email Email a verificar
     * @return bool True si existe, False si no
     */
    public function email_exists($email) {
        global $db;
        
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        return $data['total'] > 0;
    }
    
    /**
     * Verifica si un nombre de usuario ya existe en la base de datos
     * 
     * @param string $username Nombre de usuario a verificar
     * @return bool True si existe, False si no
     */
    public function username_exists($username) {
        global $db;
        
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        return $data['total'] > 0;
    }
    
    /**
     * Obtiene un usuario por su nombre de usuario
     * 
     * @param string $username Nombre de usuario
     * @return array|bool Datos del usuario o False si no existe
     */
    public function get_by_username($username) {
        global $db;
        
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return false;
        }
        
        return $result->fetch_assoc();
    }
    
    /**
     * Obtiene un usuario por su email
     * 
     * @param string $email Email del usuario
     * @return array|bool Datos del usuario o False si no existe
     */
    public function get_by_email($email) {
        global $db;
        
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return false;
        }
        
        return $result->fetch_assoc();
    }
    
    /**
     * Actualiza la última fecha de acceso de un usuario
     * 
     * @param int $id ID del usuario
     * @return bool True si se actualizó correctamente, False si no
     */
    public function update_last_login($id) {
        global $db;
        
        $now = date('Y-m-d H:i:s');
        $stmt = $db->prepare("UPDATE usuarios SET ultimo_acceso = ? WHERE id = ?");
        $stmt->bind_param("si", $now, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Actualiza el token de recuperación de contraseña de un usuario
     * 
     * @param int $id ID del usuario
     * @param string $token Token de recuperación
     * @param string $expiry Fecha de expiración del token
     * @return bool True si se actualizó correctamente, False si no
     */
    public function update_reset_token($id, $token, $expiry) {
        global $db;
        
        $stmt = $db->prepare("UPDATE usuarios SET reset_token = ?, reset_expiry = ? WHERE id = ?");
        $stmt->bind_param("ssi", $token, $expiry, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Obtiene un usuario por su token de recuperación
     * 
     * @param string $token Token de recuperación
     * @return array|bool Datos del usuario o False si no existe
     */
    public function get_by_reset_token($token) {
        global $db;
        
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE reset_token = ? AND reset_expiry > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return false;
        }
        
        return $result->fetch_assoc();
    }
    
    /**
     * Actualiza la contraseña de un usuario
     * 
     * @param int $id ID del usuario
     * @param string $password Nueva contraseña (ya encriptada)
     * @return bool True si se actualizó correctamente, False si no
     */
    public function update_password($id, $password) {
        global $db;
        
        $stmt = $db->prepare("UPDATE usuarios SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE id = ?");
        $stmt->bind_param("si", $password, $id);
        
        return $stmt->execute();
    }
} 