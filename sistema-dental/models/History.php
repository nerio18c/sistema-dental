<?php
// models/History.php

require_once __DIR__ . '/BaseModel.php';

class History extends BaseModel
{
    // Volcamos la tabla de citas
    protected static $table = 'appointments';

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Trae todas las citas (como historial) con sus datos,
     * y opcionalmente filtra por tratamiento, médico, paciente o enfermedad.
     */
    public function completed(string $search = ''): array
    {
        $sql = "
            SELECT
              a.id,
              t.name   AS treatment_name,
              d.name   AS doctor_name,
              p.name   AS patient_name,
              a.date,
              a.time,
              a.illness,
              a.status,
              a.paid,
              a.cost
            FROM appointments a
            JOIN treatments t ON a.treatment_id = t.id
            JOIN doctors    d ON a.doctor_id    = d.id
            JOIN patients   p ON a.patient_id   = p.id
            WHERE 1
        ";
        if ($search !== '') {
            $sql .= " AND (
              t.name    LIKE :q OR
              d.name    LIKE :q OR
              p.name    LIKE :q OR
              a.illness LIKE :q
            )";
        }
        $sql .= " ORDER BY a.date DESC, a.time DESC";

        $stmt = $this->pdo->prepare($sql);
        if ($search !== '') {
            $stmt->bindValue(':q', '%'.$search.'%');
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
