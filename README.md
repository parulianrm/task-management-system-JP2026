# task-management-system-JP2026

This repository contains the Final Project for the Junior Programmer Training Program 2026 at PT Neuronworks Indonesia

## Cara Menjalankan Aplikasi

### Prasyarat

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) sudah terpasang dan menyala.

### 1. Clone repository

```bash
git clone   https://github.com/parulianrm/task-management-system-JP2026.git
cd task-management-system-JP2026
```

### 2. Buat file `.env`

Buat file `.env` di root project (sejajar dengan `compose.yaml`), isinya:

```env
MYSQL_ROOT_PASSWORD=<password_root_bebas>
MYSQL_DATABASE=tms_jp2026
MYSQL_USER=<username_bebas>
MYSQL_PASSWORD=<password_bebas>
```

File ini tidak ikut ter-commit ke git (ada di `.gitignore`), jadi setiap orang yang clone harus buat sendiri.

### 3. Build & jalankan container

```bash
docker compose up -d --build
```

Perintah ini akan:

- Build image `app` dari `Dockerfile` (PHP 8.2 + Apache + ekstensi PDO/PCOV).
- Menjalankan container `app` (port `8080`) dan `database` (MySQL 8, port `3306`).

Cek status container:

```bash
docker compose ps
```

Pastikan keduanya (`tms-app`, `tms-db`) berstatus `Up`.

### 4. Install dependency PHP

```bash
docker compose exec app composer install
```

### 5. Siapkan database (schema + data awal)

**Bash / Git Bash / Linux / macOS:**

```bash
cat database/schema.sql | docker compose exec -T database mysql -u root -p<MYSQL_ROOT_PASSWORD> <MYSQL_DATABASE>
cat database/seed.sql | docker compose exec -T database mysql -u root -p<MYSQL_ROOT_PASSWORD> <MYSQL_DATABASE>
```

**Windows PowerShell:**

```powershell
Get-Content database/schema.sql | docker compose exec -T database mysql -u root -p<MYSQL_ROOT_PASSWORD> <MYSQL_DATABASE>
Get-Content database/seed.sql | docker compose exec -T database mysql -u root -p<MYSQL_ROOT_PASSWORD> <MYSQL_DATABASE>
```

**Windows Command Prompt (cmd.exe):**

```cmd
type database\schema.sql | docker compose exec -T database mysql -u root -p<MYSQL_ROOT_PASSWORD> <MYSQL_DATABASE>
type database\seed.sql | docker compose exec -T database mysql -u root -p<MYSQL_ROOT_PASSWORD> <MYSQL_DATABASE>
```

Ganti `<MYSQL_ROOT_PASSWORD>` dan `<MYSQL_DATABASE>` sesuai isi `.env` yang kamu buat di langkah 2.

### 6. Buka aplikasi

Akses lewat browser: [http://localhost:8080](http://localhost:8080)

Login dengan akun yang ada di `database/seed.sql` (1 akun Admin, 2 akun Member).

### Menjalankan unit test

```bash
docker compose exec app vendor/bin/phpunit
```

### Menghentikan aplikasi

```bash
docker compose down
```

Data MySQL tetap tersimpan di volume `db_data` (tidak ikut hilang). Kalau mau reset total termasuk data database, tambahkan flag `-v`:

```bash
docker compose down -v
```
