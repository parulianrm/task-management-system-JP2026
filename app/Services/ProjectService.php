<?php

namespace App\Services;

use App\Repositories\ProjectRepository;

class ProjectService
{
    public function __construct(private ProjectRepository $repository = new ProjectRepository())
    {
    }

    /** @return array<string,string> field => pesan error, kosong berarti valid */
    public function validate(array $data, ?int $excludeId = null): array
    {
        $errors = [];

        if (trim($data['name'] ?? '') === '') {
            $errors['name'] = 'Nama project wajib diisi.';
        }

        if (empty($data['start_date']) || empty($data['target_date'])) {
            $errors['target_date'] = 'Tanggal mulai dan target wajib diisi.';
        } elseif ($data['target_date'] < $data['start_date']) {
            $errors['target_date'] = 'Tanggal target tidak boleh lebih awal dari tanggal mulai.';
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
        $errors = $this->validate($data, $id);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $this->repository->update($id, $data, $userId);
        return ['success' => true];
    }

    public function archive(int $id, int $userId): array
    {
        $incomplete = $this->repository->countIncompleteTasks($id);

        if ($incomplete > 0) {
            return [
                'success' => false,
                'message' => "Masih ada {$incomplete} task yang belum selesai. Selesaikan dulu sebelum mengarsipkan project ini.",
            ];
        }

        $this->repository->archive($id, $userId);
        return ['success' => true];
    }

    public function unarchive(int $id, int $userId): array
    {
        $this->repository->setStatus($id, 'Active', $userId);
        return ['success' => true];
    }


    public function canBeDeleted(int $id): bool
    {
        return $this->repository->countTasks($id) === 0;
    }
}
