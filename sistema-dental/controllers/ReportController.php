<?php
// controllers/ReportController.php

require_once __DIR__ . '/../models/Report.php';

class ReportController
{
    private PDO    $pdo;
    private Report $reportModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo         = $pdo;
        $this->reportModel = new Report($pdo);
    }

    // Pantalla principal de reportes
    public function index()
    {
        require __DIR__ . '/../views/reports/index.php';
    }

    // Generar reporte de Pacientes
    public function patients()
    {
        $patients = $this->reportModel->getPatients();
        require __DIR__ . '/../views/reports/patients.php';
    }

    // Generar reporte de Médicos
    public function doctors()
    {
        $doctors = $this->reportModel->getDoctors();
        require __DIR__ . '/../views/reports/doctors.php';
    }
}
