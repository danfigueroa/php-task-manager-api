<?php

/**
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     required={"id", "title", "due_date", "status"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Minha Tarefa"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Descrição da tarefa"),
 *     @OA\Property(property="due_date", type="string", format="date", example="2025-12-31"),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="assigned_to", type="string", nullable=true, example="Daniel"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-12-30T16:30:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-12-30T16:35:00Z")
 * )
 *
 * @OA\Schema(
 *     schema="TaskInput",
 *     type="object",
 *     required={"title", "due_date"},
 *     @OA\Property(property="title", type="string", example="Minha Tarefa"),
 *     @OA\Property(property="due_date", type="string", format="date", example="2025-12-31"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Descrição da tarefa"),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="assigned_to", type="string", nullable=true, example="Daniel")
 * )
 *
 * @OA\Schema(
 *     schema="TaskUpdateInput",
 *     type="object",
 *     @OA\Property(property="title", type="string", example="Minha Tarefa Atualizada"),
 *     @OA\Property(property="due_date", type="string", format="date", example="2026-01-01"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Descrição atualizada"),
 *     @OA\Property(property="status", type="string", example="in_progress"),
 *     @OA\Property(property="assigned_to", type="string", nullable=true, example="Maria")
 * )
 */
