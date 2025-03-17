<?php
/**
 * Script de instalación para el sitio web del Concejo Deliberante de San Genaro
 */

// Verificar si ya está instalado
if (file_exists('app/config/installed.php')) {
    die('El sistema ya está instalado. Por seguridad, elimine este archivo.');
}

// Iniciar sesión
session_start();

// Definir constantes
define('SITE_NAME', 'Concejo Deliberante de San Genaro');
define('INSTALL_PATH', dirname(__FILE__));

// Función para mostrar mensajes
function show_message($message, $type = 'info') {
    return '<div class="alert alert-' . $type . '">' . $message . '</div>';
}

// Función para verificar requisitos
function check_requirements() {
    $requirements = [
        'PHP Version' => [
            'required' => '7.4.0',
            'current' => PHP_VERSION,
            'status' => version_compare(PHP_VERSION, '7.4.0', '>=')
        ],
        'MySQLi Extension' => [
            'required' => 'Enabled',
            'current' => extension_loaded('mysqli') ? 'Enabled' : 'Disabled',
            'status' => extension_loaded('mysqli')
        ],
        'PDO MySQL Extension' => [
            'required' => 'Enabled',
            'current' => extension_loaded('pdo_mysql') ? 'Enabled' : 'Disabled',
            'status' => extension_loaded('pdo_mysql')
        ],
        'GD Extension' => [
            'required' => 'Enabled',
            'current' => extension_loaded('gd') ? 'Enabled' : 'Disabled',
            'status' => extension_loaded('gd')
        ],
        'Fileinfo Extension' => [
            'required' => 'Enabled',
            'current' => extension_loaded('fileinfo') ? 'Enabled' : 'Disabled',
            'status' => extension_loaded('fileinfo')
        ],
        'app/config Directory' => [
            'required' => 'Writable',
            'current' => is_writable(INSTALL_PATH . '/app/config') ? 'Writable' : 'Not Writable',
            'status' => is_writable(INSTALL_PATH . '/app/config')
        ],
        'app/public/uploads Directory' => [
            'required' => 'Writable',
            'current' => is_writable(INSTALL_PATH . '/app/public/uploads') ? 'Writable' : 'Not Writable',
            'status' => is_writable(INSTALL_PATH . '/app/public/uploads')
        ]
    ];
    
    $all_passed = true;
    foreach ($requirements as $requirement) {
        if (!$requirement['status']) {
            $all_passed = false;
            break;
        }
    }
    
    return [
        'requirements' => $requirements,
        'passed' => $all_passed
    ];
}

// Función para crear la base de datos
function create_database($host, $user, $password, $name) {
    try {
        // Conectar a MySQL
        $conn = new mysqli($host, $user, $password);
        
        if ($conn->connect_error) {
            return [
                'status' => false,
                'message' => 'Error de conexión: ' . $conn->connect_error
            ];
        }
        
        // Crear la base de datos si no existe
        $sql = "CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        if (!$conn->query($sql)) {
            return [
                'status' => false,
                'message' => 'Error al crear la base de datos: ' . $conn->error
            ];
        }
        
        // Seleccionar la base de datos
        $conn->select_db($name);
        
        // Importar el esquema de la base de datos
        $sql_file = file_get_contents(INSTALL_PATH . '/database.sql');
        $sql_file = str_replace('concejo_sg', $name, $sql_file);
        
        // Dividir el archivo SQL en consultas individuales
        $queries = explode(';', $sql_file);
        
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if (!$conn->query($query)) {
                    return [
                        'status' => false,
                        'message' => 'Error al importar la base de datos: ' . $conn->error . ' en la consulta: ' . $query
                    ];
                }
            }
        }
        
        $conn->close();
        
        return [
            'status' => true,
            'message' => 'Base de datos creada e importada correctamente.'
        ];
    } catch (Exception $e) {
        return [
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
}

// Función para crear el archivo de configuración
function create_config_file($host, $user, $password, $name, $site_url) {
    $config_file = INSTALL_PATH . '/app/config/config.php';
    $config_content = file_get_contents($config_file);
    
    // Reemplazar los valores de configuración
    $config_content = str_replace('localhost', $host, $config_content);
    $config_content = str_replace("define('DB_USER', 'root')", "define('DB_USER', '$user')", $config_content);
    $config_content = str_replace("define('DB_PASS', '')", "define('DB_PASS', '$password')", $config_content);
    $config_content = str_replace('concejo_sg', $name, $config_content);
    $config_content = str_replace('http://localhost/concejoSG', $site_url, $config_content);
    
    // Guardar el archivo de configuración
    if (file_put_contents($config_file, $config_content)) {
        return [
            'status' => true,
            'message' => 'Archivo de configuración creado correctamente.'
        ];
    } else {
        return [
            'status' => false,
            'message' => 'Error al crear el archivo de configuración.'
        ];
    }
}

// Función para crear el archivo de instalación completada
function create_installed_file($admin_email, $admin_password) {
    $installed_file = INSTALL_PATH . '/app/config/installed.php';
    $installed_content = "<?php\n// Archivo generado automáticamente por el instalador\n// " . date('Y-m-d H:i:s') . "\ndefine('INSTALLED', true);\n";
    
    // Guardar el archivo de instalación completada
    if (file_put_contents($installed_file, $installed_content)) {
        // Actualizar el usuario administrador
        try {
            // Cargar la configuración
            require_once INSTALL_PATH . '/app/config/config.php';
            
            // Conectar a la base de datos
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($conn->connect_error) {
                return [
                    'status' => false,
                    'message' => 'Error de conexión: ' . $conn->connect_error
                ];
            }
            
            // Actualizar el usuario administrador
            $password_hash = password_hash($admin_password, PASSWORD_BCRYPT, ['cost' => 10]);
            $sql = "UPDATE usuarios SET email = ?, password = ? WHERE rol = 'admin' LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $admin_email, $password_hash);
            $stmt->execute();
            $stmt->close();
            
            $conn->close();
            
            return [
                'status' => true,
                'message' => 'Instalación completada correctamente.'
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Error al actualizar el usuario administrador: ' . $e->getMessage()
            ];
        }
    } else {
        return [
            'status' => false,
            'message' => 'Error al crear el archivo de instalación completada.'
        ];
    }
}

// Procesar el formulario
$step = isset($_GET['step']) ? (int) $_GET['step'] : 1;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($step === 1) {
        // Verificar requisitos
        $check = check_requirements();
        if ($check['passed']) {
            $step = 2;
        } else {
            $error = 'Por favor, corrija los requisitos antes de continuar.';
        }
    } elseif ($step === 2) {
        // Configuración de la base de datos
        $db_host = $_POST['db_host'] ?? '';
        $db_user = $_POST['db_user'] ?? '';
        $db_pass = $_POST['db_pass'] ?? '';
        $db_name = $_POST['db_name'] ?? '';
        $site_url = $_POST['site_url'] ?? '';
        
        if (empty($db_host) || empty($db_user) || empty($db_name) || empty($site_url)) {
            $error = 'Todos los campos son obligatorios.';
        } else {
            // Crear la base de datos
            $result = create_database($db_host, $db_user, $db_pass, $db_name);
            
            if ($result['status']) {
                // Crear el archivo de configuración
                $config_result = create_config_file($db_host, $db_user, $db_pass, $db_name, $site_url);
                
                if ($config_result['status']) {
                    $success = $result['message'] . ' ' . $config_result['message'];
                    $step = 3;
                } else {
                    $error = $config_result['message'];
                }
            } else {
                $error = $result['message'];
            }
        }
    } elseif ($step === 3) {
        // Configuración del administrador
        $admin_email = $_POST['admin_email'] ?? '';
        $admin_password = $_POST['admin_password'] ?? '';
        $admin_password_confirm = $_POST['admin_password_confirm'] ?? '';
        
        if (empty($admin_email) || empty($admin_password) || empty($admin_password_confirm)) {
            $error = 'Todos los campos son obligatorios.';
        } elseif (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
            $error = 'El correo electrónico no es válido.';
        } elseif ($admin_password !== $admin_password_confirm) {
            $error = 'Las contraseñas no coinciden.';
        } elseif (strlen($admin_password) < 8) {
            $error = 'La contraseña debe tener al menos 8 caracteres.';
        } else {
            // Crear el archivo de instalación completada
            $result = create_installed_file($admin_email, $admin_password);
            
            if ($result['status']) {
                $success = $result['message'];
                $step = 4;
            } else {
                $error = $result['message'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación - <?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .install-container {
            max-width: 800px;
            margin: 50px auto;
        }
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .step {
            flex: 1;
            text-align: center;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            margin: 0 5px;
        }
        .step.active {
            background-color: #0d6efd;
            color: white;
        }
        .step.completed {
            background-color: #198754;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container install-container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Instalación - <?php echo SITE_NAME; ?></h2>
            </div>
            <div class="card-body">
                <!-- Indicador de pasos -->
                <div class="step-indicator">
                    <div class="step <?php echo $step >= 1 ? 'active' : ''; ?> <?php echo $step > 1 ? 'completed' : ''; ?>">
                        <i class="fas fa-check-circle"></i> Requisitos
                    </div>
                    <div class="step <?php echo $step >= 2 ? 'active' : ''; ?> <?php echo $step > 2 ? 'completed' : ''; ?>">
                        <i class="fas fa-database"></i> Base de datos
                    </div>
                    <div class="step <?php echo $step >= 3 ? 'active' : ''; ?> <?php echo $step > 3 ? 'completed' : ''; ?>">
                        <i class="fas fa-user-shield"></i> Administrador
                    </div>
                    <div class="step <?php echo $step >= 4 ? 'active' : ''; ?>">
                        <i class="fas fa-flag-checkered"></i> Finalizar
                    </div>
                </div>
                
                <?php if (!empty($error)): ?>
                    <?php echo show_message($error, 'danger'); ?>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <?php echo show_message($success, 'success'); ?>
                <?php endif; ?>
                
                <?php if ($step === 1): ?>
                    <!-- Paso 1: Verificar requisitos -->
                    <h3 class="mb-4">Paso 1: Verificar requisitos</h3>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Requisito</th>
                                    <th>Requerido</th>
                                    <th>Actual</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $check = check_requirements(); ?>
                                <?php foreach ($check['requirements'] as $name => $requirement): ?>
                                    <tr>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $requirement['required']; ?></td>
                                        <td><?php echo $requirement['current']; ?></td>
                                        <td>
                                            <?php if ($requirement['status']): ?>
                                                <span class="badge bg-success"><i class="fas fa-check"></i> OK</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><i class="fas fa-times"></i> Error</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <form method="post" action="?step=1">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary" <?php echo $check['passed'] ? '' : 'disabled'; ?>>
                                Continuar <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                <?php elseif ($step === 2): ?>
                    <!-- Paso 2: Configuración de la base de datos -->
                    <h3 class="mb-4">Paso 2: Configuración de la base de datos</h3>
                    
                    <form method="post" action="?step=2">
                        <div class="mb-3">
                            <label for="db_host" class="form-label">Servidor de la base de datos</label>
                            <input type="text" class="form-control" id="db_host" name="db_host" value="localhost" required>
                            <div class="form-text">Generalmente es "localhost".</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="db_user" class="form-label">Usuario de la base de datos</label>
                            <input type="text" class="form-control" id="db_user" name="db_user" value="root" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="db_pass" class="form-label">Contraseña de la base de datos</label>
                            <input type="password" class="form-control" id="db_pass" name="db_pass">
                            <div class="form-text">Dejar en blanco si no tiene contraseña.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="db_name" class="form-label">Nombre de la base de datos</label>
                            <input type="text" class="form-control" id="db_name" name="db_name" value="concejo_sg" required>
                            <div class="form-text">Se creará si no existe.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="site_url" class="form-label">URL del sitio</label>
                            <input type="text" class="form-control" id="site_url" name="site_url" value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/install.php', '', $_SERVER['REQUEST_URI']); ?>" required>
                            <div class="form-text">URL completa sin barra al final.</div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="?step=1" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i> Atrás
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Continuar <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                <?php elseif ($step === 3): ?>
                    <!-- Paso 3: Configuración del administrador -->
                    <h3 class="mb-4">Paso 3: Configuración del administrador</h3>
                    
                    <form method="post" action="?step=3">
                        <div class="mb-3">
                            <label for="admin_email" class="form-label">Correo electrónico del administrador</label>
                            <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="admin_password" class="form-label">Contraseña del administrador</label>
                            <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                            <div class="form-text">Mínimo 8 caracteres.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="admin_password_confirm" class="form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="admin_password_confirm" name="admin_password_confirm" required>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="?step=2" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i> Atrás
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Continuar <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                <?php elseif ($step === 4): ?>
                    <!-- Paso 4: Finalizar -->
                    <h3 class="mb-4">Paso 4: Instalación completada</h3>
                    
                    <div class="alert alert-success">
                        <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i> ¡Felicidades!</h4>
                        <p>La instalación se ha completado correctamente.</p>
                        <hr>
                        <p class="mb-0">Ahora puedes acceder al sitio web y al panel de administración.</p>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><i class="fas fa-globe me-2"></i> Sitio Web</h5>
                                    <p class="card-text">Accede al sitio web público.</p>
                                    <a href="index.php" class="btn btn-primary">Ir al sitio web</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><i class="fas fa-user-shield me-2"></i> Panel de Administración</h5>
                                    <p class="card-text">Accede al panel de administración.</p>
                                    <a href="admin/index.php" class="btn btn-primary">Ir al panel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mt-4">
                        <h4 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Importante</h4>
                        <p>Por razones de seguridad, debes eliminar el archivo <code>install.php</code> y el archivo <code>database.sql</code> del servidor.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>