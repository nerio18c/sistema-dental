<?php
// models/Treatment.php

class Treatment extends BaseModel
{
    // Nombre de la tabla
    protected static $table = 'treatments';

    // Devuelve todos, ordenados por name
    public function all()
    {
        $stmt = $this->pdo->query("
            SELECT *
            FROM " . self::$table . "
            ORDER BY name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- FIRMA CORREGIDA: sin tipado, sin retorno declarado ---
    public function find($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM " . self::$table . "
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO " . self::$table . " (name, price)
            VALUES (?, ?)
        ");
        return $stmt->execute([
            $data['name'],
            $data['price'],
        ]);
    }

    public function update($id, array $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE " . self::$table . "
            SET name  = ?, price = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['price'],
            $id,
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM " . self::$table . "
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }
}
