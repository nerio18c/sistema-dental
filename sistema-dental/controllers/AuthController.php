<?php
// controllers/AuthController.php
class AuthController extends BaseController {
    public function login(): void {
        // 1) Inicializa $error para que siempre exista
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $um   = new User($this->pdo);
            $user = $um->findByUsername($_POST['username']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user'] = $user;
                $this->redirect('?controller=dashboard&action=index');
            } else {
                $error = 'Credenciales inválidas';
            }
        }

        // 2) Pasa siempre la clave 'error' (nula o con mensaje) al render
        $this->render('auth/login', ['error' => $error]);
    }

    public function logout(): void {
        session_destroy();
        $this->redirect('?controller=auth&action=login');
    }
}
