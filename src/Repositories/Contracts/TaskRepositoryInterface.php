<?php

namespace Src\Repositories\Contracts;

interface TaskRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): ?array;
    public function create(array $data): array;
    public function update(int $id, array $data): ?array;
    public function delete(int $id): bool;
}
