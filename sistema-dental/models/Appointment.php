<?php
// models/Appointment.php

require_once __DIR__ . '/BaseModel.php';

class Appointment extends BaseModel
{
    protected static $table = 'appointments';

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function getAllWithDetails(string $search = ''): array
    {
        $tbl = static::$table;
        $sql = "
            SELECT
              a.id,
              a.treatment_id,
              a.doctor_id,
              a.patient_id,
              t.name  AS treatment_name,
              d.name  AS doctor_name,
              p.name  AS patient_name,
              a.date,
              a.time,
              a.illness,
              a.status,
              a.cost,
              a.paid
            FROM {$tbl} a
            JOIN treatments t ON a.treatment_id = t.id
            JOIN doctors    d ON a.doctor_id    = d.id
            JOIN patients   p ON a.patient_id   = p.id
        ";

        if ($search !== '') {
            $sql .= "
              WHERE
                t.name    LIKE :q OR
                d.name    LIKE :q OR
                p.name    LIKE :q OR
                a.illness LIKE :q
            ";
        }

        $sql .= " ORDER BY a.date DESC, a.time DESC";

        $stmt = $this->pdo->prepare($sql);
        if ($search !== '') {
            $like = "%{$search}%";
            $stmt->bindParam(':q', $like, PDO::PARAM_STR);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $tbl = static::$table;
        $sql = "
            INSERT INTO {$tbl}
              (treatment_id, doctor_id, patient_id, date, time, illness, status, cost, paid, created_at)
            VALUES
              (:treatment_id, :doctor_id, :patient_id, :date, :time, :illness, :status, :cost, :paid, NOW())
        ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':treatment_id' => $data['treatment_id'],
            ':doctor_id'    => $data['doctor_id'],
            ':patient_id'   => $data['patient_id'],
            ':date'         => $data['date'],
            ':time'         => $data['time'],
            ':illness'      => $data['illness'],
            ':status'       => $data['status'],
            ':cost'         => $data['cost'],
            ':paid'         => $data['paid'],
        ]);
    }

    public function update($id, array $data): bool
    {
        $tbl = static::$table;
        $sql = "
            UPDATE {$tbl} SET
              treatment_id = :treatment_id,
              doctor_id    = :doctor_id,
              patient_id   = :patient_id,
              date         = :date,
              time         = :time,
              illness      = :illness,
              status       = :status,
              cost         = :cost,
              paid         = :paid
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':treatment_id' => $data['treatment_id'],
            ':doctor_id'    => $data['doctor_id'],
            ':patient_id'   => $data['patient_id'],
            ':date'         => $data['date'],
            ':time'         => $data['time'],
            ':illness'      => $data['illness'],
            ':status'       => $data['status'],
            ':cost'         => $data['cost'],
            ':paid'         => $data['paid'],
            ':id'           => $id,
        ]);
    }

    public function delete($id): bool
    {
        $tbl  = static::$table;
        $stmt = $this->pdo->prepare("DELETE FROM {$tbl} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
