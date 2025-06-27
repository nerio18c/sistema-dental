<?php
// models/Doctor.php

class Doctor extends BaseModel
{
    protected static $table = 'doctors';

    public function all()
    {
        $stmt = $this->pdo->query("
            SELECT d.*, s.name AS specialty_name
            FROM " . self::$table . " d
            LEFT JOIN specialties s ON d.specialty_id = s.id
            ORDER BY d.name
        ");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . self::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO " . self::$table . "
              (name, dni, specialty_id, address, email, phone)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['name'],
            $data['dni']          ?: null,
            $data['specialty_id'],
            $data['address']      ?: null,
            $data['email']        ?: null,
            $data['phone']        ?: null,
        ]);
    }

    public function update($id, array $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE " . self::$table . "
            SET name         = ?,
                dni          = ?,
                specialty_id = ?,
                address      = ?,
                email        = ?,
                phone        = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['dni']          ?: null,
            $data['specialty_id'],
            $data['address']      ?: null,
            $data['email']        ?: null,
            $data['phone']        ?: null,
            $id,
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM " . self::$table . " WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
