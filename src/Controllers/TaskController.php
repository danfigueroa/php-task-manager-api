<?php

namespace Src\Controllers;

use Src\Services\Contracts\TaskServiceInterface;
use InvalidArgumentException;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Task Manager API",
 *      description="API REST para gerenciar tarefas",
 *      @OA\Contact(
 *          email="danielfigueroa@example.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url="http://localhost:8000",
 *      description="Servidor local"
 * )
 */
class TaskController
{
    private TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @OA\Get(
     *     path="/tasks",
     *     summary="Listar todas as tarefas",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tarefas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Task"))
     *     )
     * )
     */
    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return $this->jsonResponse($tasks);
    }

    /**
     * @OA\Post(
     *     path="/tasks",
     *     summary="Criar uma nova tarefa",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tarefa criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function store()
    {
        try {
            $input = $this->getInputData();
            $task = $this->taskService->createTask($input);
            return $this->jsonResponse($task, 201);
        } catch (InvalidArgumentException $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/tasks/{id}",
     *     summary="Obter detalhes de uma tarefa específica",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da tarefa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da tarefa",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $id = (int)$id;
        $task = $this->taskService->getTaskById($id);
        if (!$task) {
            return $this->jsonResponse(['error' => 'Task not found'], 404);
        }
        return $this->jsonResponse($task);
    }

    /**
     * @OA\Put(
     *     path="/tasks/{id}",
     *     summary="Atualizar uma tarefa existente",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da tarefa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskUpdateInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa atualizada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function update($id)
    {
        $id = (int)$id;
        $input = $this->getInputData();
        try {
            $task = $this->taskService->updateTask($id, $input);
            if (!$task) {
                return $this->jsonResponse(['error' => 'Task not found'], 404);
            }
            return $this->jsonResponse($task);
        } catch (InvalidArgumentException $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * @OA\Delete(
     *     path="/tasks/{id}",
     *     summary="Deletar uma tarefa",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da tarefa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Tarefa deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $id = (int)$id;
        $success = $this->taskService->deleteTask($id);
        if (!$success) {
            return $this->jsonResponse(['error' => 'Task not found'], 404);
        }
        return $this->jsonResponse(null, 204);
    }

    // Auxiliares

    private function getInputData(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    private function jsonResponse($data, int $status = 200)
    {
        header('Content-Type: application/json', true, $status);
        echo json_encode($data);
        exit;
    }
}
