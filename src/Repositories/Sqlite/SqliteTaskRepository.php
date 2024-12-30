<?php

namespace Src\Repositories\Sqlite;

use Src\Repositories\Contracts\TaskRepositoryInterface;
use Src\Database\DB;
use PDO;

class SqliteTaskRepository implements TaskRepositoryInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM tasks ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
        return $task ?: null;
    }

    public function create(array $data): array
    {
        $sql = "
            INSERT INTO tasks (title, description, due_date, status, assigned_to)
            VALUES (:title, :description, :due_date, :status, :assigned_to)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'due_date'    => $data['due_date'],
            'status'      => $data['status'] ?? 'pending',
            'assigned_to' => $data['assigned_to'] ?? null,
        ]);
        $id = $this->pdo->lastInsertId();
        return $this->findById((int)$id);
    }

    public function update(int $id, array $data): ?array
    {
        $sql = "
            UPDATE tasks
               SET title = :title,
                   description = :description,
                   due_date = :due_date,
                   status = :status,
                   assigned_to = :assigned_to,
                   updated_at = CURRENT_TIMESTAMP
             WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'title'       => $data['title'],
            'description' => $data['description'],
            'due_date'    => $data['due_date'],
            'status'      => $data['status'],
            'assigned_to' => $data['assigned_to'],
            'id'          => $id,
        ]);
        return $this->findById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
