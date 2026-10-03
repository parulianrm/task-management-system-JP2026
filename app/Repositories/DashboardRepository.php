<?php

namespace App\Repositories;

use App\Core\Database;
use App\Repositories\Contracts\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function countActiveProjects(): int
    {
        $stmt = Database::getConnection()->query("SELECT COUNT(*) FROM PROJECTS WHERE status = 'Active'");
        return (int) $stmt->fetchColumn();
    }

    public function countTasksByStatus(?int $assigneeId = null): array
    {
        $sql = "SELECT TASKS.status, COUNT(*) AS total
                FROM TASKS
                JOIN PROJECTS ON PROJECTS.id = TASKS.project_id
                WHERE PROJECTS.status != 'Archived'";
        $params = [];

        if ($assigneeId !== null) {
            $sql .= ' AND TASKS.assignee_id = :assigneeId';
            $params['assigneeId'] = $assigneeId;
        }

        $sql .= ' GROUP BY TASKS.status';

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);

        $result = ['To Do' => 0, 'In Progress' => 0, 'Done' => 0];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['status']] = (int) $row['total'];
        }

        return $result;
    }

    public function countOverdueTasks(?int $assigneeId = null): int
    {
        $sql = "SELECT COUNT(*)
                FROM TASKS
                JOIN PROJECTS ON PROJECTS.id = TASKS.project_id
                WHERE PROJECTS.status != 'Archived'
                  AND TASKS.due_date < CURDATE()
                  AND TASKS.status != 'Done'";
        $params = [];

        if ($assigneeId !== null) {
            $sql .= ' AND TASKS.assignee_id = :assigneeId';
            $params['assigneeId'] = $assigneeId;
        }

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function findUpcomingTasks(?int $assigneeId = null, int $limit = 5): array
    {
        $sql = "SELECT TASKS.id, TASKS.title, TASKS.due_date, TASKS.status,
                       PROJECTS.name AS project_name
                FROM TASKS
                JOIN PROJECTS ON PROJECTS.id = TASKS.project_id
                WHERE PROJECTS.status != 'Archived'
                  AND TASKS.status != 'Done'";
        $params = [];

        if ($assigneeId !== null) {
            $sql .= ' AND TASKS.assignee_id = :assigneeId';
            $params['assigneeId'] = $assigneeId;
        }

        $sql .= ' ORDER BY TASKS.due_date ASC LIMIT ' . (int) $limit;

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
