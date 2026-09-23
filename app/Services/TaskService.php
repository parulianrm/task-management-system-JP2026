<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;

class TaskService
{
    public function __construct(
        private TaskRepository $repository = new TaskRepository(),
        private ProjectRepository $projectRepository = new ProjectRepository(),
        private UserRepository $userRepository = new UserRepository()
    ) {
    }

    public function validate(array $data, ?array $existingTask = null): array
    {
        $errors = [];

        if (trim($data['title'] ?? '') === '') {
            $errors['title'] = 'Judul task wajib diisi.';
        }

        $project = null;
        if (empty($data['project_id'])) {
            $errors['project_id'] = 'Project wajib dipilih.';
        } else {
            $project = $this->projectRepository->findById((int) $data['project_id']);
            if ($project === null) {
                $errors['project_id'] = 'Project tidak valid.';
            } elseif ($project['status'] === 'Archived') {
                $errors['project_id'] = 'Project ini sudah diarsipkan, task tidak bisa dibuat/diubah.';
            }
        }

        if (!empty($data['assignee_id'])) {
            $assignee = $this->userRepository->findById((int) $data['assignee_id']);
            if ($assignee === null) {
                $errors['assignee_id'] = 'Assignee tidak valid.';
            } elseif (!$assignee['is_active']) {
                $currentAssigneeId = $existingTask['assignee_id'] ?? null;
                if ((int) $data['assignee_id'] !== (int) $currentAssigneeId) {
                    $errors['assignee_id'] = 'User ini sudah nonaktif, tidak bisa di-assign task baru.';
                }
            }
        }

        if (empty($data['due_date'])) {
            $errors['due_date'] = 'Due date wajib diisi.';
        } elseif ($project !== null) {
            if ($data['due_date'] < $project['start_date'] || $data['due_date'] > $project['target_date']) {
                $errors['due_date'] = "Due date harus antara {$project['start_date']} s.d. {$project['target_date']}.";
            }
        }

        return $errors;
    }

    public function create(array $data, int $userId): array
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $id = $this->repository->create($data, $userId);
        return ['success' => true, 'id' => $id];
    }

   public function update(int $id, array $data, int $userId): array
{
    $existing = $this->repository->findById($id);
    if ($existing === null) {
        return ['success' => false, 'message' => 'Task tidak ditemukan.'];
    }

    $errors = $this->validate($data, $existing);
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    $this->repository->update($id, $data, $userId);
    return ['success' => true];
}


    public function updateStatus(int $id, string $status, int $userId, string $role): array
    {
        $existing = $this->repository->findById($id);
        if ($existing === null) {
            return ['success' => false, 'message' => 'Task tidak ditemukan.'];
        }

        if ($role !== 'Admin' && (int) $existing['assignee_id'] !== $userId) {
            return ['success' => false, 'message' => 'Anda tidak berhak mengubah task ini.'];
        }

        if (!in_array($status, ['To Do', 'In Progress', 'Done'], true)) {
            return ['success' => false, 'message' => 'Status tidak valid.'];
        }

        $project = $this->projectRepository->findById((int) $existing['project_id']);
        if ($project !== null && $project['status'] === 'Archived') {
            return ['success' => false, 'message' => 'Project ini sudah diarsipkan, task tidak bisa diubah.'];
        }

        $this->repository->updateStatus($id, $status, $userId);
        return ['success' => true];
    }
}
