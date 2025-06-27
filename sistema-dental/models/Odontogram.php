<?php
// models/Odontogram.php
class Odontogram extends BaseModel
{
    protected static $table = 'odontograms'; // columnas: id, patient_id, data (JSON)

    // Obtener odontograma de un paciente
    public function findByPatient($patient_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . static::$table . " WHERE patient_id = ?");
        $stmt->execute([$patient_id]);
        return $stmt->fetch();
    }

    // Crear nuevo odontograma
    public function create($patient_id, array $states)
    {
        $sql = "INSERT INTO " . static::$table . " (patient_id, data) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$patient_id, json_encode($states)]);
    }

    // Actualizar odontograma existente
    public function updateByPatient($patient_id, array $states)
    {
        $sql = "UPDATE " . static::$table . " SET data = ? WHERE patient_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([json_encode($states), $patient_id]);
    }
}
