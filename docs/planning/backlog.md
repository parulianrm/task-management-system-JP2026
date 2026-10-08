# Backlog — Project Activity & Task Management System

Checklist ini memecah setiap Requirement ID dari brief jadi sub-tugas.
Centang [x] kalau sudah BENAR-BENAR berfungsi (bukan cuma tampilan statis).

## Auth

### AUTH-01 — Login dan session

- [x] Login valid mengarah ke dashboard sesuai role
- [x] Kredensial salah menampilkan pesan aman (generik)
- [x] User tidak aktif tidak dapat login
- [x] Halaman terlindungi tidak dapat diakses tanpa session
- [x] Password pakai password_hash() / password_verify()

### AUTH-02 — Logout

- [x] Logout menghapus data autentikasi session
- [x] URL terlindungi tidak bisa dibuka lagi tanpa login

## User

### USR-01 — Manajemen user

- [x] Admin bisa tambah/lihat/ubah/aktifkan/nonaktifkan user
- [x] Email unik, role cuma Admin/Member
- [x] Member tidak bisa akses halaman/endpoint admin user
- [x] Tidak ada public registration

## Project

### PRJ-01 — Manajemen project

- [x] Field: nama, deskripsi, status, tanggal mulai, tanggal target tersedia
- [x] Tanggal target tidak boleh lebih awal dari tanggal mulai
- [x] Project dengan task hanya bisa diarsipkan, bukan status lain
- [x] Member cuma lihat project yang task-nya ditugaskan ke dia

## Task

### TSK-01 — Manajemen task

- [x] Field: project, judul, deskripsi, assignee, status, priority, due date, timestamps
- [x] Project & assignee harus valid di database
- [x] Due date dalam rentang tanggal project
- [x] Perubahan task konsisten di daftar & dashboard

### TSK-02 — Kontrol kepemilikan dan status

- [x] Authorization dicek server-side tiap operasi
- [x] Member A ditolak ubah task Member B
- [x] Status cuma: To Do / In Progress / Done
- [x] Admin bisa kelola semua task

## Tampilan, Pencarian, Dashboard

### VIEW-01 — Daftar, detail, empty state

- [x] Daftar tampilkan info penting + action sesuai role
- [x] Empty state informatif kalau tidak ada data
- [x] Tanggal/status/priority konsisten

### FIND-01 — Search, filter, sort, pagination

- [x] Project: search nama + filter status
- [x] Task: search judul + filter project/status/priority + sort due date
- [x] Pagination task 10/halaman
- [x] Filter & search tetap aktif saat pindah halaman
- [x] Seed minimal 25 task

### DASH-01 — Dashboard sesuai hak akses

- [x] Admin: total project aktif, task per status, overdue, 5 due terdekat
- [x] Member: ringkasan cuma dari task miliknya
- [x] Overdue = due date lewat + status belum Done
- [x] Angka dari query agregasi, bukan statis

## Validation, Error, UI

### VAL-01 — Validation dan feedback

- [x] Validasi frontend (field wajib, email, enum, tanggal, FK)
- [x] Pesan jelas cara memperbaiki, tanpa bocorkan detail teknis
- [x] Data tidak tersimpan kalau validasi gagal
- [x] Input yang sudah diisi dipertahankan kalau gagal submit

### ERR-01 — Error handling

- [x] Akses tanpa login → redirect ke login
- [x] Akses tanpa kewenangan → 403
- [x] Data/URL tidak ditemukan → 404
- [x] Exception/stack trace tidak tampil ke user

### UI-01 — Responsive dan usability

- [x] Layout dasar jalan di desktop
- [x] Dicek ulang di lebar 360px (terutama sidebar & tabel)
- [x] Form punya label (login, project, task, user)
- [ ] Kontras & focus state dicek menyeluruh

## Database

### DB-01 — Database relasional

- [x] Tabel users, projects, tasks dengan PK/FK/index
- [x] Query pakai PDO prepared statement
- [x] Schema bisa bikin database dari kondisi kosong
- [x] Seed: 1 Admin, ≥2 Member, project, ≥25 task

## Non-fungsional

- [x] Docker: minimal service app + database, `docker compose up --build` dari kondisi bersih
- [x] Unit test: minimal 6 test case, ≥3 area, tanpa database asli
- [x] Git: commit bertahap per blok kerja, branch dev/lian/\*
- [ ] `docs/testing/` — hasil test & screenshot
- [ ] `ai-usage-log.md` — diisi jujur sebelum submission
