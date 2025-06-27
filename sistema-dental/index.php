<?php
// index.php
$config = require __DIR__ . '/config/config.php';

// Conexión a la BD
try {
    $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset={$config['db_charset']}";
    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Carga automática
require __DIR__ . '/helpers/autoload.php';

// Ruteo básico por GET: ?controller=patient&action=index
$controller  = ucfirst($_GET['controller'] ?? 'patient') . 'Controller';
$action      = $_GET['action'] ?? 'index';
$ctrlFile    = __DIR__ . "/controllers/{$controller}.php";

if (file_exists($ctrlFile)) {
    $app = new $controller($pdo);
    if (method_exists($app, $action)) {
        $app->{$action}();
    } else {
        http_response_code(404);
        echo "Acción no encontrada.";
    }
} else {
    http_response_code(404);
    echo "Controlador no encontrado.";
}
