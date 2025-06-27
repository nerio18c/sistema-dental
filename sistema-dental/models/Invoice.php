<?php
// models/Invoice.php
class Invoice extends BaseModel
{
    protected static $table = 'invoices';

    public function create($d)
    {
        // $d: patient_id, date, total
        $sql = "INSERT INTO invoices (patient_id, date, total) VALUES (?, ?, ?)";
        $stmt= $this->pdo->prepare($sql);
        $stmt->execute([$d['patient_id'], $d['date'], $d['total']]);
        return $this->pdo->lastInsertId();
    }
}
