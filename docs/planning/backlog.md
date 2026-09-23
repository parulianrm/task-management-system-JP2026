# Backlog — Project Activity & Task Management System

Checklist ini memecah setiap Requirement ID dari brief (§2) jadi sub-tugas.
Centang [x] kalau sudah BENAR-BENAR berfungsi (bukan cuma tampilan statis).

## Auth

### AUTH-01 — Login dan session

- [x] Login valid mengarah ke dashboard sesuai role
- [x] Kredensial salah menampilkan pesan aman (generik)
- [x] User tidak aktif tidak dapat login
- [x] Halaman terlindungi tidak dapat diakses tanpa session
- [x] Password pakai password_hash() / password_verify()

### AUTH-02 — Logout

- [ ] Logout menghapus data autentikasi session
- [ ] URL terlindungi tidak bisa dibuka lagi tanpa login

## User

### USR-01 — Manajemen user

- [ ] Admin bisa tambah/lihat/ubah/aktifkan/nonaktifkan user
- [ ] Email unik, role cuma Admin/Member
- [ ] Member tidak bisa akses halaman/endpoint admin user
- [ ] Tidak ada public registration

## Project

### PRJ-01 — Manajemen project

- [ ] Field: nama, deskripsi, status, tanggal mulai, tanggal target tersedia
- [ ] Tanggal target tidak boleh lebih awal dari tanggal mulai
- [ ] Project dengan task hanya bisa diarsipkan, bukan status lain
- [ ] Member cuma lihat project yang task-nya ditugaskan ke dia

## Task

### TSK-01 — Manajemen task

- [ ] Field: project, judul, deskripsi, assignee, status, priority, due date, timestamps
- [ ] Project & assignee harus valid di database
- [ ] Due date dalam rentang tanggal project
- [ ] Perubahan task konsisten di daftar & dashboard

### TSK-02 — Kontrol kepemilikan dan status

- [ ] Authorization dicek server-side tiap operasi
- [ ] Member A ditolak ubah task Member B
- [ ] Status cuma: To Do / In Progress / Done
- [ ] Admin bisa kelola semua task

## Tampilan, Pencarian, Dashboard

### VIEW-01 — Daftar, detail, empty state

- [ ] Daftar tampilkan info penting + action sesuai role
- [ ] Empty state informatif kalau tidak ada data
- [ ] Tanggal/status/priority konsisten

### FIND-01 — Search, filter, sort, pagination

- [ ] Project: search nama + filter status
- [ ] Task: search judul + filter project/status/priority + sort due date
- [ ] Pagination task 10/halaman
- [ ] Filter & search tetap aktif saat pindah halaman
- [ ] Seed minimal 25 task

### DASH-01 — Dashboard sesuai hak akses

- [ ] Admin: total project aktif, task per status, overdue, 5 due terdekat
- [ ] Member: ringkasan cuma dari task miliknya
- [ ] Overdue = due date lewat + status belum Done
- [ ] Angka dari query agregasi, bukan statis

## Validation, Error, UI

### VAL-01 — Validation dan feedback

- [ ] Validasi frontend (field wajib, email, enum, tanggal, FK)
- [ ] Pesan jelas cara memperbaiki, tanpa bocorkan detail teknis
- [ ] Data tidak tersimpan kalau validasi gagal
- [ ] Input yang sudah diisi dipertahankan kalau gagal submit

### ERR-01 — Error handling

- [ ] Akses tanpa login → redirect ke login
- [ ] Akses tanpa kewenangan → 403
- [ ] Data/URL tidak ditemukan → 404
- [ ] Exception/stack trace tidak tampil ke user

### UI-01 — Responsive dan usability

- [x] Layout dasar jalan di desktop
- [ ] Dicek ulang di lebar 360px (terutama sidebar & tabel)
- [x] Form punya label (login, project, task, user)
- [ ] Kontras & focus state dicek menyeluruh

## Database

### DB-01 — Database relasional

- [ ] Tabel users, projects, tasks dengan PK/FK/index
- [ ] Query pakai PDO prepared statement
- [ ] Schema bisa bikin database dari kondisi kosong
- [ ] Seed: 1 Admin, ≥2 Member, project, ≥25 task

## Non-fungsional

- [ ] Docker: minimal service app + database, `docker compose up --build` dari kondisi bersih
- [ ] Unit test: minimal 6 test case, ≥3 area, tanpa database asli
- [x] Git: commit bertahap per blok kerja, branch dev/lian/\*
- [ ] `docs/testing/` — hasil test & screenshot
- [ ] `ai-usage-log.md` — diisi jujur sebelum submission (sengaja ditunda ke akhir)
