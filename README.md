# Task Manager API

A RESTful API built with pure PHP and SQLite, designed to manage tasks efficiently. The API is documented using Swagger/OpenAPI and containerized with Docker for easy deployment and scalability.

## Table of Contents

- [Features](#features)
- [Architecture](#architecture)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Running the API with Docker](#running-the-api-with-docker)
- [API Documentation](#api-documentation)
- [Testing the Endpoints](#testing-the-endpoints)
  - [List All Tasks](#list-all-tasks)
  - [Create a New Task](#create-a-new-task)
  - [Get Task Details](#get-task-details)
  - [Update a Task](#update-a-task)
  - [Delete a Task](#delete-a-task)
- [Project Structure](#project-structure)
  - [Folder Structure](#folder-structure)
  - [Key Components](#key-components)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## Features

- **CRUD Operations**: Create, Read, Update, and Delete tasks.
- **Swagger Documentation**: Interactive API documentation available via Swagger UI.
- **Dockerized**: Easily deployable using Docker and Docker Compose.
- **SQLite Database**: Lightweight and serverless database solution.
- **Modular Architecture**: Organized codebase following best practices for maintainability and scalability.

## Architecture

The project follows a **Modular Architecture**, separating concerns across different layers:

- **Controllers**: Handle incoming HTTP requests and delegate actions to services.
- **Services**: Contain business logic and interact with repositories.
- **Repositories**: Manage data persistence and retrieval from the SQLite database.
- **Router**: Directs incoming requests to the appropriate controller actions.
- **Documentation**: Uses Swagger/OpenAPI annotations to generate interactive API documentation.
- **Configuration**: Centralized configuration for database paths and other settings.

## Prerequisites

- **Docker**: Ensure Docker is installed on your machine. [Download Docker](https://www.docker.com/get-started)
- **Docker Compose**: Typically comes bundled with Docker Desktop. Verify installation with:

  ```bash
  docker-compose --version

## Installation

### Clone the Repository

```bash git clone https://github.com/yourusername/task-manager-api.git```

```bash cd task-manager-api```

### Install Dependencies

Ensure you have Composer installed locally. If not, you can use the Docker container to install dependencies.

```bash docker run --rm -v $(pwd):/app -w /app composer install ```

Alternatively, if Composer is installed locally:

```bash composer install```

## Running the API with Docker

The project uses Docker Compose to manage the application container.

### Build and Start the Containers

```bash docker-compose up -d --build```

-d: Runs containers in detached mode.
--build: Rebuilds the Docker image.

### Verify Containers are Running

```bash docker-compose ps```

Expected Output:

```bash
Name                 Command                  State           Ports
--------------------------------------------------------------------------------
php_sqlite_api       "php -S 0.0.0.0:8000…"   Up      0.0.0.0:8000->8000/tcp
```

### Access the API

The API will be accessible at: http://localhost:8000

## Testing the Endpoints

You can test the API endpoints using cURL. Below are examples for each endpoint.

### List All Tasks
Request:

```bash
curl -X GET http://localhost:8000/tasks
```

Response (200 OK):

```bash
[
  {
    "id": 1,
    "title": "Document API",
    "due_date": "2025-12-31",
    "description": "Add Swagger documentation",
    "status": "pending",
    "assigned_to": "John",
    "created_at": "2024-12-30T16:30:00Z",
    "updated_at": "2024-12-30T16:30:00Z"
  }
]
```

### Create a New Task
Request:

```bash
curl -X POST http://localhost:8000/tasks \
     -H "Content-Type: application/json" \
     -d '{
           "title": "Implement Authentication",
           "due_date": "2025-01-15",
           "description": "Add JWT-based authentication",
           "status": "pending",
           "assigned_to": "Alice"
         }'
```

Response (201 Created):

```bash
{
  "id": 2,
  "title": "Implement Authentication",
  "due_date": "2025-01-15",
  "description": "Add JWT-based authentication",
  "status": "pending",
  "assigned_to": "Alice",
  "created_at": "2024-12-30T17:00:00Z",
  "updated_at": "2024-12-30T17:00:00Z"
}

```

Response for Invalid Data (422 Unprocessable Entity):

```bash
{
  "error": "title and due_date are required"
}
```

### Get Task Details
Request:

```bash
curl -X GET http://localhost:8000/tasks/2
```
Response (200 OK):

```bash
{
  "id": 2,
  "title": "Implement Authentication",
  "due_date": "2025-01-15",
  "description": "Add JWT-based authentication",
  "status": "pending",
  "assigned_to": "Alice",
  "created_at": "2024-12-30T17:00:00Z",
  "updated_at": "2024-12-30T17:00:00Z"
}
```

Response if Task Not Found (404 Not Found):

```bash
{
  "error": "Task not found"
}
```

### Update a Task

Request:

```bash
curl -X PUT http://localhost:8000/tasks/2 \
     -H "Content-Type: application/json" \
     -d '{
           "status": "in_progress",
           "assigned_to": "Bob"
         }'
```

Response (200 OK):

```bash
{
  "id": 2,
  "title": "Implement Authentication",
  "due_date": "2025-01-15",
  "description": "Add JWT-based authentication",
  "status": "in_progress",
  "assigned_to": "Bob",
  "created_at": "2024-12-30T17:00:00Z",
  "updated_at": "2024-12-30T17:15:00Z"
}
```

Response for Invalid Data (422 Unprocessable Entity):

```bash
{
  "error": "title is required"
}
```

Response if Task Not Found (404 Not Found):

```bash
{
  "error": "Task not found"
}
```

### Delete a Task

Request:

```bash
curl -X DELETE http://localhost:8000/tasks/2
```

Response (204 No Content):

```bash
No body.
```

Response if Task Not Found (404 Not Found):

```bash
{
  "error": "Task not found"
}
```

## Project Structure

Here's an overview of the project's folder structure and key files:

```bash
task-manager-api/
├── composer.json
├── composer.lock
├── docker-compose.yml
├── Dockerfile
├── generate-docs.php
├── public/
│   ├── index.php
│   ├── openapi.json
│   └── docs/
│       ├── index.html
│       ├── swagger-ui.css
│       ├── swagger-ui-bundle.js
│       ├── swagger-ui-standalone-preset.js
│       ├── favicon-16x16.png
│       ├── favicon-32x32.png
│       └── ... (other Swagger UI assets)
├── src/
│   ├── Config/
│   │   └── config.php
│   ├── Controllers/
│   │   └── TaskController.php
│   ├── Database/
│   │   └── DB.php
│   ├── Docs/
│   │   ├── api.php
│   │   └── schemas.php
│   ├── Repositories/
│   │   ├── Contracts/
│   │   │   └── TaskRepositoryInterface.php
│   │   └── Sqlite/
│   │       └── SqliteTaskRepository.php
│   ├── Router/
│   │   └── Router.php
│   └── Services/
│       ├── Contracts/
│       │   └── TaskServiceInterface.php
│       └── TaskService.php
├── tests/
│   └── ... (unit and integration tests)
└── vendor/
    └── ... (Composer dependencies)
```

### Key Components

- **`composer.json` & `composer.lock`**: Define project dependencies and autoloading configurations.
- **`Dockerfile`**: Builds the PHP application container, installs dependencies, and generates API documentation.
- **`docker-compose.yml`**: Configures and manages Docker services.
- **`generate-docs.php`**: Script to generate `openapi.json` from OpenAPI annotations in the code.
- **`public/`**:
  - `index.php`: Entry point for all API requests.
  - `openapi.json`: Generated OpenAPI specification file.
  - `docs/`: Contains Swagger UI assets for interactive API documentation.
- **`src/`**:
  - **`Config/`**: Configuration files.
  - **`Controllers/`**: Handle HTTP requests and responses.
  - **`Database/`**: Database connection and management.
  - **`Docs/`**: OpenAPI annotations and schema definitions.
  - **`Repositories/`**: Data persistence logic.
  - **`Router/`**: Routes HTTP requests to appropriate controllers.
  - **`Services/`**: Business logic.
- **`tests/`**: Contains test cases (optional but recommended).
- **`vendor/`**: Composer-managed dependencies.