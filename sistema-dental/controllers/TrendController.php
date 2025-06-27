<?php
// controllers/TrendController.php
class TrendController extends BaseController {
    public function index(): void {
        $r      = new Report($this->pdo);
        $income = $r->incomeByMonth();
        $this->render('trends/index', compact('income'));
    }
}
