<?php
// models/Report.php

class Report
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Recupera todos los pacientes
     */
    public function getPatients(): array
    {
        $sql = "
            SELECT
              document_number AS doc_id,
              name            AS name,
              email,
              phone
            FROM patients
            ORDER BY name
        ";
        return $this->pdo
                    ->query($sql)
                    ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recupera todos los médicos (aquí uso 'dni' como campo de documento)
     */
    public function getDoctors(): array
    {
        $sql = "
            SELECT
              d.dni     AS doc_id,
              d.name    AS name,
              s.name    AS specialty,
              d.email,
              d.phone
            FROM doctors d
            JOIN specialties s ON d.specialty_id = s.id
            ORDER BY d.name
        ";
        return $this->pdo
                    ->query($sql)
                    ->fetchAll(PDO::FETCH_ASSOC);
    }
}
