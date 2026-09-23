<?php

namespace App\Repositories;

use App\Core\Database;

class TaskRepository
{
    private function buildWhere(array $filters): array
    {
        $conditions = ['1=1'];
        $params = [];

        if (!empty($filters['assignee_id'])) {
            $conditions[] = 'TASKS.assignee_id = :assignee_id';
            $params['assignee_id'] = $filters['assignee_id'];
        }
        if (!empty($filters['search'])) {
            $conditions[] = 'TASKS.title LIKE :search';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['project_id'])) {
            $conditions[] = 'TASKS.project_id = :project_id';
            $params['project_id'] = $filters['project_id'];
        }
        if (!empty($filters['status'])) {
            $conditions[] = 'TASKS.status = :status';
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['priority'])) {
            $conditions[] = 'TASKS.priority = :priority';
            $params['priority'] = $filters['priority'];
        }

        return [implode(' AND ', $conditions), $params];
    }

    public function findAll(array $filters = []): array
    {
        [$where, $params] = $this->buildWhere($filters);
        $sortDir = ($filters['sort'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

        $sql = "SELECT TASKS.id, TASKS.project_id, TASKS.title, TASKS.assignee_id,
                       TASKS.status, TASKS.priority, TASKS.due_date,
                       PROJECTS.name AS project_name, USERS.name AS assignee_name
                FROM TASKS
                JOIN PROJECTS ON PROJECTS.id = TASKS.project_id
                LEFT JOIN USERS ON USERS.id = TASKS.assignee_id
                WHERE {$where}
                ORDER BY TASKS.due_date {$sortDir}";

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
            "SELECT COUNT(*) FROM TASKS JOIN PROJECTS ON PROJECTS.id = TASKS.project_id WHERE {$where}"
        );
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

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

    public function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT TASKS.id, TASKS.project_id, TASKS.title, TASKS.description, TASKS.assignee_id,
                    TASKS.status, TASKS.priority, TASKS.due_date,
                    PROJECTS.name AS project_name, USERS.name AS assignee_name
             FROM TASKS
             JOIN PROJECTS ON PROJECTS.id = TASKS.project_id
             LEFT JOIN USERS ON USERS.id = TASKS.assignee_id
             WHERE TASKS.id = :id'
        );
        $stmt->execute(['id' => $id]);
        $task = $stmt->fetch();
        return $task ?: null;
    }

    public function create(array $data, int $updatedBy): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO TASKS (project_id, title, description, assignee_id, status, priority, due_date, updated_by)
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
            'UPDATE TASKS
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
            'UPDATE TASKS SET status = :status, updated_by = :updated_by WHERE id = :id'
        );
        $stmt->execute([
            'status' => $status,
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }
}
