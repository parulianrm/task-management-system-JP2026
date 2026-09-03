Entity Relationship Diagram (ERD) & Database Schema

Dokumen ini mendefinisikan struktur skema basis data, tabel, kolom, tipe data, serta relasi antar entitas untuk proyek manajemen tugas.

---

## 1. Visualisasi ERD

    USERS {
        id INT PK
        name VARCHAR
        email VARCHAR UK
        password VARCHAR
        role ENUM
        is_active BOOLEAN
        created_at DATETIME
        updated_at DATETIME
    }

    PROJECTS {
        id INT PK
        name VARCHAR
        description TEXT
        status ENUM
        start_date DATE
        target_date DATE
        created_at DATETIME
        updated_at DATETIME
    }

    TASKS {
        id INT PK
        project_id INT FK
        title VARCHAR
        description TEXT
        assignee_id INT FK
        status ENUM
        priority ENUM
        due_date DATE
        created_at DATETIME
        updated_at DATETIME
    }

## 2. Detail Skema Tabel

### A. Users Table

Menyimpan data pengguna, kredensial autentikasi, serta hak akses ke dalam sistem.

| Nama Kolom   | Tipe Data                 | Keterangan / Constraint         |
| :----------- | :------------------------ | :------------------------------ |
| `id`         | `INT`                     | **Primary Key**, Auto Increment |
| `name`       | `VARCHAR`                 | Nama lengkap pengguna           |
| `email`      | `VARCHAR`                 | **Unique Key**, Not Null        |
| `password`   | `VARCHAR`                 | Hash kata sandi pengguna        |
| `role`       | `ENUM('Admin', 'Member')` | Peran/hak akses pengguna        |
| `is_active`  | `BOOLEAN`                 | Status aktif/non-aktif akun     |
| `created_at` | `DATETIME`                | Waktu data dibuat               |
| `updated_at` | `DATETIME`                | Waktu data terakhir diperbarui  |

---

### B. Projects Table

| Nama Kolom    | Tipe Data                                                 | Keterangan / Constraint         |
| :------------ | :-------------------------------------------------------- | :------------------------------ |
| `id`          | `INT`                                                     | **Primary Key**, Auto Increment |
| `name`        | `VARCHAR`                                                 | Nama proyek                     |
| `description` | `TEXT`                                                    | Deskripsi / detail proyek       |
| `status`      | `ENUM('Pending', 'In Progress', 'Completed', 'Archived')` | Status progres proyek           |
| `start_date`  | `DATE`                                                    | Tanggal mulai proyek            |
| `target_date` | `DATE`                                                    | Target tanggal penyelesaian     |
| `created_at`  | `DATETIME`                                                | Waktu data dibuat               |
| `updated_at`  | `DATETIME`                                                | Waktu data terakhir diperbarui  |

---

### C. Tasks Table

| Nama Kolom    | Tipe Data                              | Keterangan / Constraint                      |
| :------------ | :------------------------------------- | :------------------------------------------- |
| `id`          | `INT`                                  | **Primary Key**, Auto Increment              |
| `project_id`  | `INT`                                  | **Foreign Key** $\rightarrow$ `PROJECTS(id)` |
| `title`       | `VARCHAR`                              | Judul tugas                                  |
| `description` | `TEXT`                                 | Detail / instruksi tugas                     |
| `assignee_id` | `INT`                                  | **Foreign Key** $\rightarrow$ `USERS(id)`    |
| `status`      | `ENUM('To Do', 'In Progress', 'Done')` | Status pengerjaan tugas                      |
| `priority`    | `ENUM('Low', 'Medium', 'High')`        | Tingkat prioritas tugas                      |
| `due_date`    | `DATE`                                 | Tenggat waktu pengerjaan                     |
| `created_at`  | `DATETIME`                             | Waktu data dibuat                            |
| `updated_at`  | `DATETIME`                             | Waktu data terakhir diperbarui               |

---

## 3. Relasi Antar Tabel (Cardinality)

1. **`USERS` ke `TASKS` (1 to N / One-to-Many):**
   - Satu pengguna (`USERS`) dapat ditugaskan untuk menangani banyak tugas (`TASKS`) melalui kolom `assignee_id`.
   - Setiap satu tugas (`TASKS`) ditugaskan kepada satu pengguna (`USERS`).

2. **`PROJECTS` ke `TASKS` (1 to N / One-to-Many):**
   - Satu proyek (`PROJECTS`) dapat memiliki banyak tugas (`TASKS`) di dalamnya melalui kolom `project_id`.
   - Setiap satu tugas (`TASKS`) wajib terikat pada satu proyek (`PROJECTS`).

---

## 4. Catatan Teknis & Penjelasan Istilah Basis Data

### A. Konsep Relasi Antar Tabel

- **One-to-Many (1 to N):**
  - Relasi di mana satu entitas pada tabel utama (parent) dapat terhubung ke banyak entitas pada tabel turunan (child).
  - **`USERS` $
ightarrow$ `TASKS`:** Satu _User_ dapat memiliki/mengerjakan banyak _Task_, tetapi satu _Task_ hanya ditugaskan ke satu _User_ via `assignee_id`.
  - **`PROJECTS` $
ightarrow$ `TASKS`:** Satu _Project_ memuat banyak _Task_, tetapi satu _Task_ hanya terikat pada satu _Project_ via `project_id`.

---

### B. Istilah & Constraint Basis Data

1. **PK (Primary Key):**
   - Identitas unik utama untuk setiap baris (_record_) dalam tabel.
   - Nilainya tidak boleh bernilai kosong (`NOT NULL`) dan tidak boleh ganda/duplikat dalam satu tabel.
   - _Contoh:_ `id` pada tabel `USERS`, `PROJECTS`, dan `TASKS`.

2. **FK (Foreign Key):**
   - Kolom pada suatu tabel yang merujuk/menunjuk ke `Primary Key` di tabel lain.
   - Digunakan untuk membangun dan menjaga integritas relasi antar-tabel (_referential integrity_).
   - _Contoh:_ `project_id` dan `assignee_id` pada tabel `TASKS`.

3. **UK (Unique Key / Unique Constraint):**
   - Memastikan seluruh nilai dalam satu kolom bersifat unik dan tidak ada data ganda.
   - _Contoh:_ `email` pada tabel `USERS` agar satu email tidak bisa digunakan untuk mendaftar dua kali.

4. **ENUM (Enumeration):**
   - Tipe data khusus yang membatasi masukan kolom agar **hanya menerima nilai dari daftar yang telah ditentukan secara spesifik**.
   - _Contoh:_
     - `role` di `USERS`: hanya boleh diisi `'Admin'` atau `'Member'`.
     - `status` di `TASKS`: hanya boleh diisi `'To Do'`, `'In Progress'`, atau `'Done'`.
     - `priority` di `TASKS`: hanya boleh diisi `'Low'`, `'Medium'`, atau `'High'`.

5. **Type Data Umum Lainnya:**
   - **`INT`:** Angka bulat untuk identifier/ID.
   - **`VARCHAR`:** Teks/string dinamis dengan batas panjang tertentu.
   - **`TEXT`:** Teks panjang tanpa batas kaku (cocok untuk deskripsi).
   - **`BOOLEAN`:** Nilai biner (`TRUE`/`FALSE` atau `1`/`0`).
   - **`DATE`:** Menyimpan tanggal saja (`YYYY-MM-DD`).
   - **`DATETIME`:** Menyimpan tanggal beserta jam/waktu (`YYYY-MM-DD HH:mm:ss`).
