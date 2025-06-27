<?php
// models/Patient.php

class Patient extends BaseModel {
    protected static $table = 'patients';

    /**
     * Inserta un nuevo paciente.
     */
    public function create(array $d): bool {
        $sql = "INSERT INTO patients
          (document_type, document_number, name, dob, address,
           email, phone,
           under_treatment, bleeding, allergic,
           hypertensive, diabetic, pregnant,
           motive, diagnosis, observations, referred_by)
        VALUES
          (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $d['document_type'],
            $d['document_number'],
            $d['name'],
            $d['dob'],
            $d['address'],
            $d['email'],
            $d['phone'],
            $d['under_treatment'],
            $d['bleeding'],
            $d['allergic'],
            $d['hypertensive'],
            $d['diabetic'],
            $d['pregnant'],
            $d['motive'],
            $d['diagnosis'],
            $d['observations'],
            $d['referred_by'],
        ]);
    }

    /**
     * Actualiza un paciente existente.
     */
    public function update(int $id, array $d): bool {
        $sql = "UPDATE patients SET
          document_type=?, document_number=?, name=?, dob=?, address=?,
          email=?, phone=?,
          under_treatment=?, bleeding=?, allergic=?,
          hypertensive=?, diabetic=?, pregnant=?,
          motive=?, diagnosis=?, observations=?, referred_by=?
         WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $d['document_type'],
            $d['document_number'],
            $d['name'],
            $d['dob'],
            $d['address'],
            $d['email'],
            $d['phone'],
            $d['under_treatment'],
            $d['bleeding'],
            $d['allergic'],
            $d['hypertensive'],
            $d['diabetic'],
            $d['pregnant'],
            $d['motive'],
            $d['diagnosis'],
            $d['observations'],
            $d['referred_by'],
            $id,
        ]);
    }

    /**
     * Busca pacientes por número de documento (dni).
     * Devuelve un array con ['id','name','document_number'].
     */
    public function findByDni(string $dni): array {
        $sql = "SELECT id, name, document_number
                  FROM " . static::$table . "
                 WHERE document_number = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$dni]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
