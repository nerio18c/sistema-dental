<?php
// controllers/HistoryController.php

require_once __DIR__ . '/../models/History.php';

class HistoryController
{
    private PDO $pdo;
    private History $model;

    public function __construct(PDO $pdo)
    {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo   = $pdo;
        $this->model = new History($pdo);
    }

    /**
     * Muestra el historial de citas
     */
    public function index(): void
    {
        $search  = trim($_GET['search'] ?? '');
        $records = $this->model->completed($search);

        require __DIR__ . '/../views/templates/header.php';
        require __DIR__ . '/../views/history/list.php';
        require __DIR__ . '/../views/templates/footer.php';
    }
}
