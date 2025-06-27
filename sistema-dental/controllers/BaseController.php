<?php
// controllers/BaseController.php
class BaseController {
    protected PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function render(string $view, array $data = []): void {
        extract($data);
        require __DIR__ . "/../views/templates/header.php";
        require __DIR__ . "/../views/{$view}.php";
        require __DIR__ . "/../views/templates/footer.php";
    }

    protected function redirect(string $url): void {
        header("Location: {$url}");
        exit;
    }

    protected function checkAuth(): void {
        if (empty($_SESSION['user'])) {
            $this->redirect('?controller=auth&action=login');
        }
    }

    protected function checkRole(array $roles): void {
        $this->checkAuth();
        if (!in_array($_SESSION['user']['role'], $roles, true)) {
            http_response_code(403);
            exit('Acceso denegado');
        }
    }
}
