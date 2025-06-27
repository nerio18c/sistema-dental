<?php
// models/Summary.php

class Summary
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Retorna un array [mesNumero => cantidadDeCitas] para el año dado.
     */
    public function getMonthlyAppointmentsCount(int $year): array
    {
        $sql = "
            SELECT
              MONTH(date) AS month,
              COUNT(*)    AS cnt
            FROM appointments
            WHERE YEAR(date) = ?
            GROUP BY MONTH(date)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$year]);

        $out = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $out[(int)$row['month']] = (int)$row['cnt'];
        }
        return $out;
    }
}
