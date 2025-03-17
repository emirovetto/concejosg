<?php
/**
 * Controlador para la página de contacto
 */
require_once CONTROLLERS_PATH . '/base_controller.php';

class ContactoController extends BaseController {
    /**
     * Método principal
     */
    public function index() {
        $mensaje = '';
        $error = '';
        
        // Procesar el formulario si se envió
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar los campos
            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $asunto = isset($_POST['asunto']) ? trim($_POST['asunto']) : '';
            $mensaje_texto = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
            
            if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje_texto)) {
                $error = 'Por favor, complete todos los campos.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Por favor, ingrese un correo electrónico válido.';
            } else {
                // Enviar el correo electrónico
                $to = 'info@concejosangenaro.gob.ar';
                $subject = 'Contacto desde el sitio web: ' . $asunto;
                $body = "Nombre: $nombre\n";
                $body .= "Email: $email\n\n";
                $body .= "Mensaje:\n$mensaje_texto";
                $headers = "From: $email";
                
                if (mail($to, $subject, $body, $headers)) {
                    $mensaje = 'Su mensaje ha sido enviado correctamente. Nos pondremos en contacto a la brevedad.';
                    // Limpiar los campos
                    $nombre = $email = $asunto = $mensaje_texto = '';
                } else {
                    $error = 'Hubo un problema al enviar el mensaje. Por favor, inténtelo nuevamente.';
                }
            }
        }
        
        // Cargar la vista
        $this->view('contacto/index', [
            'title' => 'Contacto - ' . SITE_NAME,
            'mensaje' => $mensaje,
            'error' => $error,
            'breadcrumbs' => [
                'Contacto' => false
            ]
        ]);
    }
} 