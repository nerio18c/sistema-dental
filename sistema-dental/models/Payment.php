<?php
// models/Payment.php

require_once __DIR__ . '/BaseModel.php';

class Payment extends BaseModel
{
    protected static $table = 'payments';

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Listado de citas con su estado de pago calculado
     */
    public function getAllAppointmentStatuses(string $search = ''): array
    {
        $sql = "
            SELECT
              a.id,
              p.document_number,
              p.name            AS patient_name,
              t.name            AS treatment_name,
              a.illness,
              a.date,
              a.time,
              a.cost,
              a.paid            AS paid_amount
            FROM appointments a
            JOIN patients   p ON a.patient_id   = p.id
            JOIN treatments t ON a.treatment_id = t.id
        ";

        if ($search !== '') {
            $sql .= "
              WHERE
                p.document_number LIKE :q OR
                p.name            LIKE :q OR
                t.name            LIKE :q OR
                a.illness         LIKE :q
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

    /**
     * Detalle de una sola cita (para la vista “Ver pagos”)
     */
    public function getByIdWithDetails(int $id): array
    {
        $sql = "
            SELECT
              a.*,
              p.document_number,
              p.name            AS patient_name,
              t.name            AS treatment_name,
              d.name            AS doctor_name
            FROM appointments a
            JOIN patients   p ON a.patient_id   = p.id
            JOIN treatments t ON a.treatment_id = t.id
            JOIN doctors    d ON a.doctor_id    = d.id
            WHERE a.id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Inserta un nuevo movimiento de pago
     */
    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO payments
              (appointment_id, user_id, amount, created_at)
            VALUES
              (:appointment_id, :user_id, :amount, NOW())
        ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':appointment_id' => $data['appointment_id'],
            ':user_id'        => $data['user_id'],
            ':amount'         => $data['amount'],
        ]);
    }
}
