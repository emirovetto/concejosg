<?php
/**
 * Controlador para el dashboard del panel de administración
 */
require_once '../app/admin/controllers/base_controller.php';

class DashboardController extends BaseController {
    /**
     * Constructor
     */
    public function __construct() {
        // Verificar que el usuario tenga acceso
        $this->require_admin();
    }
    
    /**
     * Muestra el dashboard
     */
    public function index() {
        // Conectar a la base de datos
        $conn = db_connect();
        
        // Contar noticias
        $sql = "SELECT COUNT(*) as total FROM noticias";
        $result = $conn->query($sql);
        $noticias_count = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $noticias_count = $row['total'];
        }
        
        // Contar ordenanzas
        $sql = "SELECT COUNT(*) as total FROM ordenanzas";
        $result = $conn->query($sql);
        $ordenanzas_count = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $ordenanzas_count = $row['total'];
        }
        
        // Contar sesiones
        $sql = "SELECT COUNT(*) as total FROM sesiones";
        $result = $conn->query($sql);
        $sesiones_count = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $sesiones_count = $row['total'];
        }
        
        // Contar concejales
        $sql = "SELECT COUNT(*) as total FROM concejales";
        $result = $conn->query($sql);
        $concejales_count = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $concejales_count = $row['total'];
        }
        
        // Cerrar la conexión
        $conn->close();
        
        // Pasar los datos a la vista
        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'noticias_count' => $noticias_count,
            'ordenanzas_count' => $ordenanzas_count,
            'sesiones_count' => $sesiones_count,
            'concejales_count' => $concejales_count
        ]);
    }
} 