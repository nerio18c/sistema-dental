<?php
// controllers/SummaryController.php

require_once __DIR__ . '/../models/Summary.php';

class SummaryController
{
    private PDO $pdo;
    private Summary $model;

    public function __construct(PDO $pdo)
    {
        $this->pdo   = $pdo;
        $this->model = new Summary($pdo);
    }

    /**
     * Muestra el resumen general de citas por mes.
     */
    public function index()
    {
        $year = date('Y');
        $monthlyCounts = $this->model->getMonthlyAppointmentsCount($year);

        // Nombres de meses en español
        $monthNames = [
            'Enero','Febrero','Marzo','Abril',
            'Mayo','Junio','Julio','Agosto',
            'Septiembre','Octubre','Noviembre','Diciembre'
        ];

        // Construye labels y data completos (1–12)
        $labels = [];
        $counts = [];
        for ($m = 1; $m <= 12; $m++) {
            $labels[] = $monthNames[$m - 1];
            $counts[] = $monthlyCounts[$m] ?? 0;
        }

        require __DIR__ . '/../views/summary/index.php';
    }
}
