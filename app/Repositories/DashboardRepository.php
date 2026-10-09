<?php

namespace App\Repositories;

use App\Core\Database;
use App\Repositories\Contracts\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function countActiveProjects(): int
    {
        $stmt = Database::getConnection()->query("SELECT COUNT(*) FROM projects WHERE status = 'Active'");
        return (int) $stmt->fetchColumn();
    }

    public function counttasksByStatus(?int $assigneeId = null): array
    {
        $sql = "SELECT tasks.status, COUNT(*) AS total
                FROM tasks
                JOIN projects ON projects.id = tasks.project_id
                WHERE projects.status != 'Archived'";
        $params = [];

        if ($assigneeId !== null) {
            $sql .= ' AND tasks.assignee_id = :assigneeId';
            $params['assigneeId'] = $assigneeId;
        }

        $sql .= ' GROUP BY tasks.status';

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);

        $result = ['To Do' => 0, 'In Progress' => 0, 'Done' => 0];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['status']] = (int) $row['total'];
        }

        return $result;
    }

    public function countOverduetasks(?int $assigneeId = null): int
    {
        $sql = "SELECT COUNT(*)
                FROM tasks
                JOIN projects ON projects.id = tasks.project_id
                WHERE projects.status != 'Archived'
                  AND tasks.due_date < CURDATE()
                  AND tasks.status != 'Done'";
        $params = [];

        if ($assigneeId !== null) {
            $sql .= ' AND tasks.assignee_id = :assigneeId';
            $params['assigneeId'] = $assigneeId;
        }

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function findUpcomingtasks(?int $assigneeId = null, int $limit = 5): array
    {
        $sql = "SELECT tasks.id, tasks.title, tasks.due_date, tasks.status,
                       projects.name AS project_name
                FROM tasks
                JOIN projects ON projects.id = tasks.project_id
                WHERE projects.status != 'Archived'
                  AND tasks.status != 'Done'";
        $params = [];

        if ($assigneeId !== null) {
            $sql .= ' AND tasks.assignee_id = :assigneeId';
            $params['assigneeId'] = $assigneeId;
        }

        $sql .= ' ORDER BY tasks.due_date ASC LIMIT ' . (int) $limit;

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
