-- 1. Buat Tabel USERS
CREATE TABLE IF NOT EXISTS USERS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Member') NOT NULL DEFAULT 'Member',
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    updated_by INT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_updated_by FOREIGN KEY (updated_by) REFERENCES USERS (id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 2. Buat Tabel PROJECTS
CREATE TABLE IF NOT EXISTS PROJECTS (
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
    CONSTRAINT fk_projects_updated_by FOREIGN KEY (updated_by) REFERENCES USERS (id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 3. Buat Tabel TASKS
CREATE TABLE IF NOT EXISTS TASKS (
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


CONSTRAINT fk_tasks_project
        FOREIGN KEY (project_id) REFERENCES PROJECTS(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_tasks_assignee
        FOREIGN KEY (assignee_id) REFERENCES USERS(id)
        ON DELETE SET NULL ON UPDATE CASCADE,

    CONSTRAINT fk_tasks_updated_by
        FOREIGN KEY (updated_by) REFERENCES USERS(id)
        ON DELETE SET NULL ON UPDATE CASCADE,

    INDEX idx_tasks_project (project_id),
    INDEX idx_tasks_assignee (assignee_id),
    INDEX idx_tasks_status (status),
    INDEX idx_tasks_due_date (due_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;