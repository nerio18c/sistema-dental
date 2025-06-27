<?php
// controllers/DashboardController.php
class DashboardController extends BaseController {
    public function index(): void {
        $totPatients = $this->pdo->query("SELECT COUNT(*) FROM patients")->fetchColumn();
        $totDoctors  = $this->pdo->query("SELECT COUNT(*) FROM doctors")->fetchColumn();
        $totCitas    = $this->pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
        $this->render('dashboard/index', compact('totPatients','totDoctors','totCitas'));
    }
}
