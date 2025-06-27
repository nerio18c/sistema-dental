<?php
// models/BaseModel.php
abstract class BaseModel
{
    protected static $table;
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
