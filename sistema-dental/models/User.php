<?php
// models/User.php
class User extends BaseModel
{
    protected static $table = 'users';

    public function findByUsername(string $username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("
            INSERT INTO users
              (username,password,role,document_type,document_number,email,phone)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['username'],
            $passwordHash,
            $data['role'],
            $data['document_type']   ?? null,
            $data['document_number'] ?? null,
            $data['email']           ?? null,
            $data['phone']           ?? null,
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $fields = 'username=?, role=?, document_type=?, document_number=?, email=?, phone=?';
        $params = [
            $data['username'],
            $data['role'],
            $data['document_type']   ?? null,
            $data['document_number'] ?? null,
            $data['email']           ?? null,
            $data['phone']           ?? null,
        ];

        if (!empty($data['password'])) {
            $fields .= ', password=?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $params[] = $id;

        $stmt = $this->pdo->prepare("UPDATE users SET {$fields} WHERE id = ?");
        return $stmt->execute($params);
    }
}
