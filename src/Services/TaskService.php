<?php

namespace Src\Services;

use Src\Services\Contracts\TaskServiceInterface;
use Src\Repositories\Contracts\TaskRepositoryInterface;
use InvalidArgumentException;

class TaskService implements TaskServiceInterface
{
    private TaskRepositoryInterface $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTasks(): array
    {
        return $this->repository->findAll();
    }

    public function createTask(array $data): array
    {
        // Validações
        if (empty($data['title']) || empty($data['due_date'])) {
            throw new InvalidArgumentException("title and due_date are required");
        }
        return $this->repository->create($data);
    }

    public function getTaskById(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function updateTask(int $id, array $data): ?array
    {
        // Carrega dados atuais para partial update
        $current = $this->repository->findById($id);
        if (!$current) {
            return null; // ou lançar exceção
        }

        // Mescla
        $merged = [
            'title'       => $current['title'],
            'description' => $current['description'],
            'due_date'    => $current['due_date'],
            'status'      => $current['status'],
            'assigned_to' => $current['assigned_to'],
        ];
        foreach ($data as $key => $val) {
            if (array_key_exists($key, $merged)) {
                $merged[$key] = $val;
            }
        }

        // Validações
        if (empty($merged['title'])) {
            throw new InvalidArgumentException("title is required");
        }
        if (empty($merged['due_date'])) {
            throw new InvalidArgumentException("due_date is required");
        }

        return $this->repository->update($id, $merged);
    }

    public function deleteTask(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
