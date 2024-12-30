<?php

namespace Src\Router;

use Src\Controllers\TaskController;
use Src\Services\TaskService;
use Src\Repositories\Sqlite\SqliteTaskRepository;

class Router
{
    public static function handleRequest($method, $uri)
    {
        // Remover query string e trailing slash
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/');

        // Dividir a URI
        $parts = explode('/', trim($uri, '/'));

        // Instanciar dependências
        $repository = new SqliteTaskRepository();
        $service = new TaskService($repository);
        $controller = new TaskController($service);

        if (isset($parts[0]) && $parts[0] === 'tasks') {
            // Rota /tasks
            if (count($parts) === 1) {
                if ($method === 'GET')  return $controller->index();
                if ($method === 'POST') return $controller->store();
            }
            // Rota /tasks/{id}
            if (count($parts) === 2 && is_numeric($parts[1])) {
                $id = (int)$parts[1];
                if ($method === 'GET')    return $controller->show($id);
                if ($method === 'PUT')    return $controller->update($id);
                if ($method === 'DELETE') return $controller->destroy($id);
            }
        }

        // Rota não encontrada
        header('Content-Type: application/json', true, 404);
        echo json_encode(['error' => 'Not Found']);
        exit;
    }
}
