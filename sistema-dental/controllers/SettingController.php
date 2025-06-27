<?php
// controllers/SettingController.php

require_once __DIR__ . '/../models/Setting.php';

class SettingController
{
    private PDO $pdo;
    private Setting $model;

    public function __construct(PDO $pdo)
    {
        $this->pdo   = $pdo;
        $this->model = new Setting($pdo);
    }

    // Listado de acciones
    public function index()
    {
        $search  = $_GET['search'] ?? '';
        $entries = $this->model->getAll($search);
        require __DIR__ . '/../views/settings/index.php';
    }

    // Formulario para crear
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create([
                'action_name' => $_POST['action_name'],
                'color'       => $_POST['color'],
            ]);
            header('Location: ?controller=setting&action=index');
            exit;
        }
        require __DIR__ . '/../views/settings/form.php';
    }

    // Formulario para editar
    public function edit()
    {
        $id = intval($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: ?controller=setting&action=index');
            exit;
        }
        $entry = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, [
                'action_name' => $_POST['action_name'],
                'color'       => $_POST['color'],
            ]);
            header('Location: ?controller=setting&action=index');
            exit;
        }

        require __DIR__ . '/../views/settings/form.php';
    }

    // Eliminar
    public function delete()
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ?controller=setting&action=index');
        exit;
    }
}
