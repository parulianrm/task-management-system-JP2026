<?php

namespace App\Repositories;

use App\Core\Database;

class TaskRepository
{
    public function findByProject(int $projectId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT TASKS.id, TASKS.title, TASKS.priority, TASKS.due_date, TASKS.status,
                    USERS.name AS assignee_name
             FROM TASKS
             LEFT JOIN USERS ON USERS.id = TASKS.assignee_id
             WHERE TASKS.project_id = :projectId
             ORDER BY TASKS.due_date ASC'
        );
        $stmt->execute(['projectId' => $projectId]);
        return $stmt->fetchAll();
    }
}
