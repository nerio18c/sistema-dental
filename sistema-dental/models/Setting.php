<?php
// models/Setting.php

require_once __DIR__ . '/BaseModel.php';

class Setting extends BaseModel
{
    protected static $table = 'odontogram_actions';

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function getAll(string $search = ''): array
    {
        $sql = "SELECT * FROM " . static::$table;
        if ($search !== '') {
            $sql .= " WHERE action_name LIKE :q OR color LIKE :q";
        }
        $sql .= " ORDER BY id ASC";

        $stmt = $this->pdo->prepare($sql);
        if ($search !== '') {
            $like = "%{$search}%";
            $stmt->bindParam(':q', $like, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM " . static::$table . " WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO " . static::$table . " (action_name, color, created_at)
            VALUES (:action_name, :color, NOW())
        ");
        return $stmt->execute([
            ':action_name' => $data['action_name'],
            ':color'       => $data['color'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE " . static::$table . "
               SET action_name = :action_name,
                   color       = :color
             WHERE id = :id
        ");
        return $stmt->execute([
            ':action_name' => $data['action_name'],
            ':color'       => $data['color'],
            ':id'          => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM " . static::$table . " WHERE id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }
}
