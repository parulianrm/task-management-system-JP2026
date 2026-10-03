# AI Usage Log — Task Management System JP2026

Dokumen ini mencatat secara jujur penggunaan AI (Claude) selama pengerjaan final project ini, sesuai ketentuan transparansi di guideline presentasi.

## Tools yang digunakan

- **Claude** (Anthropic) — sebagai asisten diskusi desain, code reviewer, dan pembimbing debugging. Tidak pernah menulis kode langsung ke file project

## Bagaimana AI digunakan

### 1. Diskusi arsitektur & keputusan desain

- Diskusi penerapan layered architecture (Repository → Service → Controller/index.php → View) dan pembagian tanggung jawab tiap layer.
- Diskusi penambahan interface (`Contracts/`) untuk Repository, termasuk trade-off dengan pendekatan tanpa interface, atas saran mentor.
- Diskusi Dependency Injection via constructor property promotion dengan default value, dan alasan pemilihan pendekatan ini dibanding Service Container/DI Container penuh.
- Diskusi pemilihan PCOV dibanding Xdebug untuk code coverage, dan alasan tidak menambahkan `USER` non-root di Dockerfile (base image `php:apache` sudah drop privilege secara internal).

### 2. Audit & penemuan bug

AI digunakan untuk mengaudit kode yang sudah saya tulis terhadap requirement VAL-01 dan ERR-01, yang menemukan celah berikut (sebelum diperbaiki oleh saya sendiri, bukan ditulis AI):

- Tidak ada try/catch global di `public/index.php`, sehingga exception bisa menampilkan stack trace mentah ke user.
- Member bisa membuka halaman detail project yang task-nya tidak ditugaskan ke dia (celah authorization).
- `ProjectService::update()`/`archive()`/`unarchive()` tidak mengecek keberadaan project sebelum diproses.
- Email yang diketik di form login hilang ketika login gagal (field tidak dipertahankan).

Saya yang menerapkan perbaikannya secara manual ke file-file terkait, berdasarkan penjelasan dan contoh kode yang diberikan AI.

### 3. Pendampingan debugging

Selama proses development, saya berulang kali membuat kesalahan ketik manual saat menyalin instruksi dari AI ke editor (typo namespace, kode tertukar antar file, baris tak lengkap). AI membantu menemukan kesalahan-kesalahan ini dengan cara membaca ulang file yang sudah saya ubah dan membandingkannya dengan kode yang seharusnya, lalu saya perbaiki sendiri.

### 4. Fitur tambahan di luar brief

Atas diskusi bersama AI, saya menambahkan dua fitur yang tidak diwajibkan brief: reset password oleh Admin, dan penambahan task langsung dari halaman detail project. Desain alur (pakai modal konfirmasi custom, toast notifikasi, dsb.) didiskusikan dulu sebelum saya implementasikan.

## Yang dikerjakan sepenuhnya mandiri

- Seluruh penulisan kode aplikasi (`app/`, `public/`, `views/`, file JS/CSS) diketik sendiri oleh saya, baris demi baris, berdasarkan penjelasan/contoh dari AI — bukan hasil copy-paste otomatis dari AI ke file.
- Seluruh pengujian manual dan eksekusi command Docker/PHPUnit dilakukan dan diverifikasi sendiri.
- Keputusan akhir atas setiap desain dan trade-off tetap berada di tangan saya — AI memberi opsi dan konsekuensinya, saya yang memutuskan.

## Transparansi

Saya memahami seluruh keputusan teknis, alur kode, dan alasan di baliknya, dan siap menjelaskannya secara langsung saat sesi presentasi dan tanya jawab.
