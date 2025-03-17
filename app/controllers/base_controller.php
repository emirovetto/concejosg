<?php
/**
 * Controlador base del que heredan todos los controladores
 */
class BaseController {
    /**
     * Carga una vista
     * 
     * @param string $view Nombre de la vista a cargar
     * @param array $data Datos a pasar a la vista
     * @return void
     */
    protected function view($view, $data = []) {
        // Extraer los datos para que estén disponibles en la vista
        extract($data);
        
        // Obtener el nombre de la página actual desde la URL
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        
        // Incluir el encabezado
        require_once VIEWS_PATH . '/layouts/header.php';
        
        // Incluir la vista
        require_once VIEWS_PATH . '/' . $view . '.php';
        
        // Incluir el pie de página
        require_once VIEWS_PATH . '/layouts/footer.php';
    }
    
    /**
     * Carga una vista sin el layout
     * 
     * @param string $view Nombre de la vista a cargar
     * @param array $data Datos a pasar a la vista
     * @return void
     */
    protected function view_partial($view, $data = []) {
        // Extraer los datos para que estén disponibles en la vista
        extract($data);
        
        // Incluir la vista
        require_once VIEWS_PATH . '/' . $view . '.php';
    }
    
    /**
     * Devuelve una respuesta JSON
     * 
     * @param array $data Datos a devolver
     * @param int $status Código de estado HTTP
     * @return void
     */
    protected function json_response($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
    
    /**
     * Verifica si el usuario ha iniciado sesión, redirige si no
     * 
     * @param string $redirect_url URL a la que redirigir si no ha iniciado sesión
     * @return void
     */
    protected function require_login($redirect_url = SITE_URL . '/login') {
        if (!is_logged_in()) {
            redirect($redirect_url);
        }
    }
    
    /**
     * Verifica si el usuario tiene un rol específico, redirige si no
     * 
     * @param string $role Rol requerido
     * @param string $redirect_url URL a la que redirigir si no tiene el rol
     * @return void
     */
    protected function require_role($role, $redirect_url = SITE_URL) {
        $this->require_login();
        
        if (!has_role($role)) {
            redirect($redirect_url);
        }
    }
} 