<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;
use App\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function findAll(array $filters = []): array
    {
        $conditions = ['1=1'];
        $params = [];

        if (!empty($filters['search'])) {
            $conditions[] = 'name LIKE :search';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['status'])) {
            $conditions[] = 'status = :status';
            $params['status'] = $filters['status'];
        }

        $where = implode(' AND ', $conditions);

        $stmt = Database::getConnection()->prepare("SELECT * FROM PROJECTS WHERE {$where} ORDER BY created_at DESC");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findAllForMember(int $userId, array $filters = []): array
    {
        $conditions = ['1=1'];
        $params = ['userId' => $userId];

        if (!empty($filters['search'])) {
            $conditions[] = 'PROJECTS.name LIKE :search';
            $params['search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['status'])) {
            $conditions[] = 'PROJECTS.status = :status';
            $params['status'] = $filters['status'];
        }

        $where = implode(' AND ', $conditions);

        $stmt = Database::getConnection()->prepare(
            "SELECT DISTINCT PROJECTS.* FROM PROJECTS
             JOIN TASKS ON TASKS.project_id = PROJECTS.id
             WHERE TASKS.assignee_id = :userId AND {$where}
             ORDER BY PROJECTS.created_at DESC"
        );
        $stmt->execute($params);
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

    public function setStatus(int $id, string $status, int $updatedBy): void
    {
        $stmt = Database::getConnection()->prepare(
            'UPDATE PROJECTS SET status = :status, updated_by = :updated_by WHERE id = :id'
        );
        $stmt->execute([
            'status' => $status,
            'updated_by' => $updatedBy,
            'id' => $id,
        ]);
    }

    public function archive(int $id, int $updatedBy): void
    {
        $this->setStatus($id, 'Archived', $updatedBy);
    }

    public function isAssignedToMember(int $projectId, int $userId): bool
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT COUNT(*) FROM TASKS WHERE project_id = :projectId AND assignee_id = :userId'
        );
        $stmt->execute(['projectId' => $projectId, 'userId' => $userId]);
        return $stmt->fetchColumn() > 0;
    }
}
