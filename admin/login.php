<?php
/**
 * Página de inicio de sesión para el panel de administración
 */

// Iniciar sesión
session_start();

// Cargar configuración
require_once '../app/config/config.php';
require_once '../app/includes/functions.php';

// Limpiar cualquier redirección a login.php para evitar bucles
if (isset($_SESSION['redirect_after_login']) && strpos($_SESSION['redirect_after_login'], 'login.php') !== false) {
    unset($_SESSION['redirect_after_login']);
}

// Verificar si el usuario ya ha iniciado sesión
if (is_logged_in() && has_role('admin')) {
    // Redirigir al panel de administración
    header("Location: index.php");
    exit;
}

// Variables para mensajes
$error = '';
$success = '';

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Validar los datos
    if (empty($email) || empty($password)) {
        $error = 'Por favor, complete todos los campos.';
    } else {
        try {
            // Conectar a la base de datos
            $conn = db_connect();
            
            // Consultar el usuario
            $email = $conn->real_escape_string($email);
            $sql = "SELECT * FROM usuarios WHERE email = '{$email}' AND estado = 'activo'";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // Verificar la contraseña
                if (password_verify($password, $user['password'])) {
                    // Iniciar sesión
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['nombre'] . ' ' . $user['apellido'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['rol'];
                    
                    // Actualizar el último acceso
                    $update_sql = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = {$user['id']}";
                    $conn->query($update_sql);
                    
                    // Redirigir al panel de administración
                    header("Location: index.php");
                    exit;
                } else {
                    $error = 'Credenciales incorrectas. Por favor, inténtelo de nuevo.';
                    error_log('Intento de inicio de sesión fallido. Email: ' . $email . ' - Contraseña incorrecta');
                }
            } else {
                $error = 'Credenciales incorrectas. Por favor, inténtelo de nuevo.';
                error_log('Intento de inicio de sesión fallido. Email: ' . $email . ' - Usuario no encontrado o inactivo');
            }
            
            // Cerrar la conexión
            $conn->close();
        } catch (Exception $e) {
            error_log('Error en el inicio de sesión: ' . $e->getMessage());
            $error = 'Ha ocurrido un error al intentar iniciar sesión. Por favor, inténtelo de nuevo más tarde.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Panel de Administración</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 450px;
            margin: 100px auto;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header img {
            max-height: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <img src="<?php echo SITE_URL; ?>/app/public/img/logo.png" alt="<?php echo SITE_NAME; ?>" class="img-fluid">
                <h2>Panel de Administración</h2>
                <p class="text-muted">Ingrese sus credenciales para acceder</p>
            </div>
            
            <div class="card shadow">
                <div class="card-body p-4">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <form method="post" action="login.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="<?php echo SITE_URL; ?>" class="text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Volver al sitio
                </a>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 