<?php
// models/Specialty.php

class Specialty extends BaseModel
{
    protected static $table = 'specialties';

    /**
     * Crea una nueva especialidad (sólo name).
     */
    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO " . self::$table . " (name)
            VALUES (?)
        ");
        return $stmt->execute([
            $data['name'],
        ]);
    }

    /**
     * Actualiza una especialidad existente (sólo name).
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE " . self::$table . "
            SET name = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $id,
        ]);
    }
}
