<?php

namespace Src\Services\Contracts;

interface TaskServiceInterface
{
    public function getAllTasks(): array;
    public function createTask(array $data): array;
    public function getTaskById(int $id): ?array;
    public function updateTask(int $id, array $data): ?array;
    public function deleteTask(int $id): bool;
}