<?php

namespace App\Repositories;

use App\Core\Database;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    private function buildWhere(array $filters): array
    {
        $conditions = ['1=1'];
        $params = [];

        if (!empty($filters['assignee_id'])) {
            $conditions[] = 'tasks.assignee_id = :assignee_id';
            $params['assignee_id'] = $filters['assignee_id'];
        }
        if (!empty($filters['search'])) {
            $conditions[] = 'tasks.title LIKE :search';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['project_id'])) {
            $conditions[] = 'tasks.project_id = :project_id';
            $params['project_id'] = $filters['project_id'];
        }
        if (!empty($filters['status'])) {
            $conditions[] = 'tasks.status = :status';
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['priority'])) {
            $conditions[] = 'tasks.priority = :priority';
            $params['priority'] = $filters['priority'];
        }

        return [implode(' AND ', $conditions), $params];
    }

    public function findAll(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);
        $sortDir = ($filters['sort'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

        $sql = "SELECT tasks.id, tasks.project_id, tasks.title, tasks.description, tasks.assignee_id, tasks.status, tasks.priority, tasks.due_date, tasks.closed_at,
                       projects.name AS project_name, users.name AS assignee_name
                FROM tasks
                JOIN projects ON projects.id = tasks.project_id
                LEFT JOIN users ON users.id = tasks.assignee_id
                WHERE projects.status != 'Archived' AND {$where}
                ORDER BY tasks.due_date {$sortDir}";

        if (!empty($filters['limit'])) {
            $sql .= ' LIMIT ' . (int) $filters['limit'] . ' OFFSET ' . (int) ($filters['offset'] ?? 0);
        }

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countAll(array $filters = []): int
    {
        [$where, $params] = $this->buildWhere($filters);

        $stmt = Database::getConnection()->prepare(
            "SELECT COUNT(*) FROM tasks JOIN projects ON projects.id = tasks.project_id WHERE projects.status != 'Archived' AND {$where}"
        );
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function findByProject(int $projectId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT tasks.id, tasks.title, tasks.priority, tasks.due_date, tasks.closed_at, tasks.status,
                    users.name AS assignee_name
             FROM tasks
             LEFT JOIN users ON users.id = tasks.assignee_id
             WHERE tasks.project_id = :projectId
             ORDER BY tasks.due_date ASC'
        );
        $stmt->execute(['projectId' => $projectId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT tasks.id, tasks.project_id, tasks.title, tasks.description, tasks.assignee_id,
                    tasks.status, tasks.priority, tasks.due_date, tasks.closed_at,
                    projects.name AS project_name, users.name AS assignee_name
             FROM tasks
             JOIN projects ON projects.id = tasks.project_id
             LEFT JOIN users ON users.id = tasks.assignee_id
             WHERE tasks.id = :id'
        );
        $stmt->execute(['id' => $id]);
        $task = $stmt->fetch();
        return $task ?: null;
    }

    public function create(array $data, int $updatedBy): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO tasks (project_id, title, description, assignee_id, status, priority, due_date, updated_by)
             VALUES (:project_id, :title, :description, :assignee_id, :status, :priority, :due_date, :updated_by)'
        );
        $stmt->execute([
            'project_id' => $data['project_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'assignee_id' => $data['assignee_id'] ?: null,
            'status' => $data['status'] ?? 'To Do',
            'priority' => $data['priority'] ?? 'Medium',
            'due_date' => $data['due_date'],
            'updated_by' => $updatedBy,
        ]);

        return (int) Database::getConnection()->lastInsertId();
    }

    public function update(int $id, array $data, int $updatedBy): void
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE tasks
             SET title = :title, description = :description, assignee_id = :assignee_id,
                 priority = :priority, due_date = :due_date, updated_by = :updated_by
             WHERE id = :id'
        );
        $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'assignee_id' => $data['assignee_id'] ?: null,
            'priority' => $data['priority'] ?? 'Medium',
            'due_date' => $data['due_date'],
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }

    public function updateStatus(int $id, string $status, int $updatedBy): void
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE tasks SET status = :status, closed_at = :closed_at, updated_by = :updated_by WHERE id = :id'
        );
        $stmt->execute([
            'status' => $status,
            'closed_at' => $status === 'Done' ? date('Y-m-d H:i:s') : null,
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }
}
