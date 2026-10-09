-- 1. Buat Tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Member') NOT NULL DEFAULT 'Member',
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    updated_by INT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- Self-reference: user A bisa jadi "updated_by" untuk user B (misal Admin edit data user lain)
    -- ON DELETE SET NULL : kalau user yang tercatat sebagai pengubah dihapus, kolom ini jadi NULL
    --                       (bukan user-nya yang ikut terhapus). Tidak ada fitur hapus user di aplikasi,
    --                       jadi ini murni jaga-jaga kalau suatu saat ada penghapusan manual lewat SQL.
    -- ON UPDATE CASCADE  : kalau id user berubah, updated_by ikut menyesuaikan otomatis
    CONSTRAINT fk_users_updated_by FOREIGN KEY (updated_by) REFERENCES users (id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 2. Buat Tabel PROJECTS
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    status ENUM(
        'Planning',
        'Active',
        'Completed',
        'Archived'
    ) NOT NULL DEFAULT 'Planning',
    start_date DATE NULL,
    target_date DATE NULL,
    updated_by INT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- updated_by = audit trail "siapa terakhir ubah project ini"
    -- ON DELETE SET NULL : kalau user-nya dihapus, jejak "siapa" hilang (jadi NULL), project tetap utuh
    -- ON UPDATE CASCADE  : id user berubah → updated_by ikut menyesuaikan otomatis
    CONSTRAINT fk_projects_updated_by FOREIGN KEY (updated_by) REFERENCES users (id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 3. Buat Tabel TASKS
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    assignee_id INT NULL,
    status ENUM('To Do', 'In Progress', 'Done') NOT NULL DEFAULT 'To Do',
    priority ENUM('Low', 'Medium', 'High') NOT NULL DEFAULT 'Medium',
    due_date DATE NULL,
    closed_at DATETIME NULL,
    updated_by INT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

-- Foreign Key Constraints

    -- Task harus selalu ikut 1 project yang valid.
    -- ON DELETE RESTRICT : TOLAK penghapusan project selama masih ada task di dalamnya
    --                      (konsisten dengan PRJ-01: project cuma boleh diarsipkan, bukan dihapus)
    -- ON UPDATE CASCADE  : id project berubah → project_id di task ikut menyesuaikan otomatis
    CONSTRAINT fk_tasks_project
        FOREIGN KEY (project_id) REFERENCES projects(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    -- Assignee boleh kosong ("belum ditugaskan"), jadi beda perlakuan dari fk_tasks_project.
    -- ON DELETE SET NULL : user yang di-assign dihapus → task jadi "belum ditugaskan" lagi (bukan ikut terhapus)
    -- ON UPDATE CASCADE  : id user berubah → assignee_id ikut menyesuaikan otomatis
    CONSTRAINT fk_tasks_assignee
        FOREIGN KEY (assignee_id) REFERENCES users(id)
        ON DELETE SET NULL ON UPDATE CASCADE,

    -- updated_by = audit trail "siapa terakhir ubah task ini" (sama konsepnya dengan projects.updated_by)
    -- ON DELETE SET NULL : user-nya dihapus → jejak "siapa" hilang (NULL), task tetap utuh
    -- ON UPDATE CASCADE  : id user berubah → updated_by ikut menyesuaikan otomatis
    CONSTRAINT fk_tasks_updated_by
        FOREIGN KEY (updated_by) REFERENCES users(id)
        ON DELETE SET NULL ON UPDATE CASCADE,

    -- Index: mempercepat pencarian/filter, TIDAK ada hubungannya dengan relasi FK di atas.
    -- Tanpa index, MySQL harus scan seluruh baris tabel tasks tiap kali query pakai kolom ini (lambat
    -- kalau datanya banyak). Dengan index, MySQL punya semacam "daftar isi" jadi langsung lompat ke baris yang cocok.
    INDEX idx_tasks_project (project_id),   -- dipakai saat tampilkan "task per project" (halaman detail project)
    INDEX idx_tasks_assignee (assignee_id), -- dipakai saat filter "task milik saya" (dashboard & list Member)
    INDEX idx_tasks_status (status),        -- dipakai saat filter status & hitung jumlah task per status (dashboard)
    INDEX idx_tasks_due_date (due_date)     -- dipakai saat sort due date & hitung task overdue (dashboard)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;