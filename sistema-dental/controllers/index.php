<?php
// controllers/index.php
$config = require __DIR__ . '/../config/config.php';

// Conexión PDO
try {
    $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset={$config['db_charset']}";
    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Autoload
require __DIR__ . '/../helpers/autoload.php';

// Routing
$ctrl   = ucfirst($_GET['controller'] ?? 'auth') . 'Controller';
$action = $_GET['action']     ?? 'login';

if (!class_exists($ctrl) || !method_exists($ctrl, $action)) {
    http_response_code(404);
    exit('Página no encontrada');
}

$controller = new $ctrl($pdo);
$controller->{$action}();
