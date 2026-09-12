<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class ProjectRepository
{
    public function findAll(): array
    {
        $stmt = Database::getConnection()->query('SELECT * FROM PROJECTS ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function findAllForMember(int $userId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT DISTINCT PROJECTS.* FROM PROJECTS
             JOIN TASKS ON TASKS.project_id = PROJECTS.id
             WHERE TASKS.assignee_id = :userId
             ORDER BY PROJECTS.created_at DESC'
        );
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM PROJECTS WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $project = $stmt->fetch();
        return $project ?: null;
    }

    public function countTasks(int $projectId): int
    {
        $stmt = Database::getConnection()->prepare('SELECT COUNT(*) FROM TASKS WHERE project_id = :id');
        $stmt->execute(['id' => $projectId]);
        return (int) $stmt->fetchColumn();
    }

    public function countIncompleteTasks(int $projectId): int
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT COUNT(*) FROM TASKS WHERE project_id = :id AND status != 'Done'"
        );
        $stmt->execute(['id' => $projectId]);
        return (int) $stmt->fetchColumn();
    }


    public function create(array $data, int $updatedBy): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO PROJECTS (name, description, status, start_date, target_date, updated_by)
             VALUES (:name, :description, :status, :start_date, :target_date, :updated_by)'
        );
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'Planning',
            'start_date' => $data['start_date'],
            'target_date' => $data['target_date'],
            'updated_by' => $updatedBy,
        ]);

        return (int) Database::getConnection()->lastInsertId();
    }

    public function update(int $id, array $data, int $updatedBy): void
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE PROJECTS
             SET name = :name, description = :description, start_date = :start_date,
                 target_date = :target_date, updated_by = :updated_by
             WHERE id = :id'
        );
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'],
            'target_date' => $data['target_date'],
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }

    public function archive(int $id, int $updatedBy): void
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE PROJECTS SET status = :status, updated_by = :updated_by WHERE id = :id'
        );
        $stmt->execute([
            'status' => 'Archived',
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }
}
